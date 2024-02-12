<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use \App\Models\MA_admin;

class A_admin extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(! Session::get('user.id')) {
            return Redirect("/"); 
        }else{
            $sess_id = Session::get('user.id');
            $sess_id_group = DB::table('tb_user_group_2')->where('id_user', $sess_id)->first()->id_group;
            $akses = DB::table('tb_user_menu')
            ->select('tb_user_rel_group.akses')
            ->where('tb_user_menu.url', 'list_admin')
            ->where('tb_user_menu.deleted_at', null)
            ->where('tb_user_rel_group.id_group', $sess_id_group)
            ->where('tb_user_rel_group.deleted_at', null)
            ->join('tb_user_rel_group', 'tb_user_menu.id', '=', 'tb_user_rel_group.id_menu')
            ->get();
            if(count($akses) != 0){
                $akses_temp = array();
                foreach ($akses as $key) {
                    array_push($akses_temp, $key->akses);
                }
                if (in_array('1', $akses_temp)){
                    $data = MA_admin::select(
                        'id',
                        'username',
                        'active',
                        'email',
                        'phone',
                        'image',
                        'nama',
                        'created_by',
                        'created_at',
                        'updated_by',
                        'updated_at'
                    )
                    ->orderBy('id', 'asc')
                    ->get();
                    foreach ($data as $row) {
                        $group = DB::table('tb_user_group_2')
                        ->select('tb_user_group.description')
                        ->where('tb_user_group.deleted_at', null)
                        ->where('tb_user_group_2.id_user', $row->id)
                        ->join('tb_user_group', 'tb_user_group_2.id_group', '=', 'tb_user_group.id')
                        ->first();
                        if($group){
                            $row->group = $group->description;
                        }else{
                            $row->group = '';
                        }
                        $row->created = $row->created_by;
                        if(is_numeric($row->created_by)){
                            $created = DB::table('tb_user')
                            ->select('tb_user.username')
                            ->where('tb_user.id', $row->created_by)
                            ->first();
                            $row->created = $created->username;
                        }
                        $row->updated = $row->updated_by;
                        if(is_numeric($row->updated_by)){
                            $updated = DB::table('tb_user')
                            ->select('tb_user.username')
                            ->where('tb_user.id', $row->updated_by)
                            ->first();
                            $row->updated = $updated->username;
                        }
                    }
                    if($request->ajax()){
                        return datatables()->of($data)->addIndexColumn()->toJson();
                        //return response()->json($data);
                    }
                    return view('admin.admin')->with('active_menu', 'User')->with('akses_menu', $akses_temp);
                }else{
                    return view('unauthorized');
                }
            }else{
                return view('unauthorized');
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sess_id = Session::get('user.id');
        $sess_username = MA_admin::select('username')->where('id', $sess_id)->first()->username;

        $cek_akun = MA_admin::select('id')->where('username', $request->username)->first();
        if($cek_akun != ''){
            return response()->json([
                'account'   => true
            ]);
        }else{
            $delete_berkas = $request->delete_berkas;
            $last_berkas = $request->get_berkas;

            $file_path = public_path('project/admin/image');
            $file_extension = array('jpg', 'jpeg', 'png', 'bmp', 'gif', 'svg', 'ico');
            $file_size = 5120000;//5 mb
            $file_upload = $request->file('berkas');
            if($file_upload != ''){
                if($file_upload->getSize() > $file_size){
                    return response()->json([
                        'size'   => true
                    ]);
                }else{
                    if (in_array($file_upload->guessClientExtension(), $file_extension)){
                        $berkas = time() . '-' . $file_upload->getClientOriginalName();
                        $request->berkas->move($file_path, $berkas);
                        if($last_berkas != ''){
                            File::delete($file_path . '/' . $last_berkas);
                        }elseif($delete_berkas != ''){
                            File::delete($file_path . '/' . $delete_berkas);
                        }
                    }else{
                        return response()->json([
                            'extension'   => true
                        ]);
                    }
                }
            }else{
                if($last_berkas == '' && $delete_berkas != ''){
                    File::delete($file_path . '/' . $delete_berkas);
                    $berkas  = '';
                }elseif($last_berkas == '' && $delete_berkas == ''){
                    $berkas  = '';
                }else{
                    $berkas  = $last_berkas;
                }
            }
            $data = MA_admin::create(
                [
                    'username'      => $request->username,
                    'password'      => Hash::make($request->password),
                    'nama'          => $request->nama,
                    'active'        => '1',
                    'email'         => $request->email,
                    'phone'         => $request->telepon,
                    'image'         => $berkas,
                    'created_by'    => $sess_id,
                    'created_at'    => date('Y-m-d H:i:s')
                ]
            );
            $cek_akun = MA_admin::select('id')->where('username', $request->username)->first();
            $group = DB::table('tb_user_group_2')->insert([
                'id_user'      => $cek_akun->id,
                'id_group'      => $request->s_group,
                'created_by'    => $sess_id,
                'created_at'    => date('Y-m-d H:i:s')
            ]);
            if($group){
                return response()->json([
                    'success'   => true,
                    'activity'  => 'Menambahkan id_user ' . $cek_akun->id,
                    'type'      => 'disimpan'
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = MA_admin::find($id);
        $group = DB::table('tb_user_group_2')
        ->select('tb_user_group.id')
        ->where('tb_user_group_2.id_user', $id)
        ->join('tb_user_group', 'tb_user_group_2.id_group', '=', 'tb_user_group.id')
        ->first();
        if($group){
            $group = $group->id;
        }else{
            $group = '0';
        }
        return response()->json([
            'id'        => $data->id,
            'username'  => $data->username,
            'nama'      => $data->nama,
            'phone'     => $data->phone,
            'email'     => $data->email,
            'group'     => $group,
            'image'     => $data->image
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sess_id = Session::get('user.id');
        $sess_username = MA_admin::select('username')->where('id', $sess_id)->first()->username;

        $file_path = public_path('project/admin/image');
        $file_extension = array('jpg', 'jpeg', 'png', 'bmp', 'gif', 'svg', 'ico');
        $file_size = 5120000;//5 mb

        $delete_berkas = $request->delete_berkas;
        $last_berkas = $request->get_berkas;
        $file_upload = $request->file('berkas');
        if($file_upload != ''){
            if($file_upload->getSize() > $file_size){
                return response()->json([
                    'size'   => true
                ]);
            }else{
                if (in_array($file_upload->guessClientExtension(), $file_extension)){
                    $berkas = time() . '-' . $file_upload->getClientOriginalName();
                    $request->berkas->move($file_path, $berkas);
                    if($last_berkas != ''){
                        File::delete($file_path . '/' . $last_berkas);
                    }elseif($delete_berkas != ''){
                        File::delete($file_path . '/' . $delete_berkas);
                    }
                }else{
                    return response()->json([
                        'extension'   => true
                    ]);
                }
            }
        }else{
            if($last_berkas == '' && $delete_berkas != ''){
                File::delete($file_path . '/' . $delete_berkas);
                $berkas  = '';
            }elseif($last_berkas == '' && $delete_berkas == ''){
                $berkas  = '';
            }else{
                $berkas  = $last_berkas;
            }
        }

        $data = MA_admin::find($id);
        $data->username     = $request->username;
        $data->nama         = $request->nama;
        $data->phone        = $request->telepon;
        $data->email        = $request->email;
        $data->image        = $berkas;
        $data->updated_by   = $sess_id;
        $data->updated_at   = date('Y-m-d H:i:s');
        if($request->password != ''){
            $data->password     = Hash::make($request->password);
        }
        $data->save();

        $group = DB::table('tb_user_group_2')
        ->where('id_user', $id)
        ->update([
            'id_group'      => $request->s_group,
            'updated_by'    => $sess_id,
            'updated_at'    => date('Y-m-d H:i:s')
        ]);
        if($group){
            return response()->json([
                'success'   => true,
                'activity'  => 'Mengupdate id_user ' . $id,
                'type'      => 'diupdate'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $data = MA_admin::find($id);
        // $data->delete();
        // return response()->json([
        //     'success'   => true
        // ]);
    }

    public function hapus(Request $request)
    {
        $sess_id = Session::get('user.id');
        $sess_username = MA_admin::select('username')->where('id', $sess_id)->first()->username;

        $id = $request->id;
        $data = MA_admin::find($id);
        $data->deleted_by   = $sess_id;
        $data->deleted_at   = date('Y-m-d H:i:s');
        $data->save();

        DB::table('tb_user_group_2')
        ->where('id_user', $id)
        ->update([
            'deleted_by'   => $sess_id,
            'deleted_at'   => date('Y-m-d H:i:s')
        ]);
        return response()->json([
            'success'   => true
        ]);
    }

    public function aktifkan(Request $request)
    {
        $sess_id = Session::get('user.id');
        $sess_username = MA_admin::select('username')->where('id', $sess_id)->first()->username;

        $id = $request->id;
        $data = MA_admin::find($id);
        $data->active       = '1';
        $data->updated_by   = $sess_id;
        $data->updated_at   = date('Y-m-d H:i:s');
        $data->save();
        return response()->json([
            'success'   => true
        ]);
    }

    public function non_aktifkan(Request $request)
    {
        $sess_id = Session::get('user.id');
        $sess_username = MA_admin::select('username')->where('id', $sess_id)->first()->username;

        $id = $request->id;
        $data = MA_admin::find($id);
        $data->active   = '0';
        $data->updated_by   = $sess_id;
        $data->updated_at   = date('Y-m-d H:i:s');
        $data->save();
        return response()->json([
            'success'   => true
        ]);
    }
}
