<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use \App\Models\MA_admin;
use \App\Models\MA_menu;

class A_menu extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(! Session::get('user.id')) {
            return Redirect("user"); 
        }else{
            $sess_id = Session::get('user.id');
            $sess_id_group = DB::table('tb_user_group_2')->where('id_user', $sess_id)->first()->id_group;
            $akses = DB::table('tb_user_menu')
            ->select('tb_user_rel_group.akses')
            ->where('tb_user_menu.url', 'menu_admin')
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
                    $object = array();
                    $data = MA_menu::select(
                        'id',
                        'menu',
                        'url',
                        'urutan',
                        'rel',
                        'created_by',
                        'created_at',
                        'updated_by',
                        'updated_at'
                    )
                    ->where('rel', '0')
                    ->orderBy('urutan', 'asc')
                    ->get();
                    foreach ($data as $row) {
                        array_push($object, $row);
                        $sub_data = MA_menu::select(
                            'id',
                            'menu',
                            'url',
                            'urutan',
                            'rel',
                            'created_by',
                            'created_at',
                            'updated_by',
                            'updated_at'
                        )
                        ->where('rel', $row->id)
                        ->orderBy('urutan', 'asc')
                        ->get();
                        if(count($sub_data) != 0){
                            foreach ($sub_data as $sub_row) {
                                array_push($object, $sub_row);
                            }
                        }
                    }
                    foreach ($object as $row) {
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
                        return datatables()->of($object)->addIndexColumn()->toJson();
                    }
                    return view('admin.menu')->with('active_menu', 'Menu')->with('akses_menu', $akses_temp);
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

        $cek_url = MA_menu::select('id', 'url')->where('url', $request->url)->first();
        if($cek_url && $cek_url->url != '#'){
            return response()->json([
                'url'   => true
            ]);
        }else{
            $rel_menu = '0';
            if($request->s_rel != ''){
                $rel_menu = $request->s_rel;
            }
            $data = MA_menu::create(
                [
                    'menu'          => $request->menu,
                    'url'           => $request->url,
                    'urutan'        => $request->urutan,
                    'rel'           => $rel_menu,
                    'created_by'    => $sess_id,
                    'created_at'    => date('Y-m-d H:i:s')
                ]
            );
            if($data){
                return response()->json([
                    'success'   => true,
                    'activity'  => 'Menambahkan id_menu ' . $data->id,
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
        $data = MA_menu::find($id);
        return response()->json([
            'id'        => $data->id,
            'menu'      => $data->menu,
            'url'       => $data->url,
            'urutan'    => $data->urutan,
            'rel'       => $data->rel
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

        $rel_menu = '0';
        if($request->s_rel != ''){
            $rel_menu = $request->s_rel;
        }
        $data = MA_menu::find($id);
        $data->menu         = $request->menu;
        $data->url          = $request->url;
        $data->urutan       = $request->urutan;
        $data->rel          = $rel_menu;
        $data->updated_by   = $sess_id;
        $data->updated_at   = date('Y-m-d H:i:s');
        $data->save();

        return response()->json([
            'success'   => true,
            'activity'  => 'Mengupdate id_menu ' . $id,
            'type'      => 'diupdate'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function hapus(Request $request)
    {
        $sess_id = Session::get('user.id');
        $sess_username = MA_admin::select('username')->where('id', $sess_id)->first()->username;

        $id = $request->id;
        $data = MA_menu::find($id);
        $data->deleted_by   = $sess_id;
        $data->deleted_at   = date('Y-m-d H:i:s');
        $data->save();

        DB::table('tb_user_rel_group')
        ->where('id_group', $id)
        ->update([
            'deleted_by'   => $sess_id,
            'deleted_at'   => date('Y-m-d H:i:s')
        ]);
        // DB::table('tb_user_rel_group')->where('id_menu', $id)->delete();
        return response()->json([
            'success'   => true
        ]);
    }

    public function rel_menu(Request $request)
    {
        $data = MA_menu::select(
            'id',
            'menu'
        )
        ->where('rel', '0')
        ->orderBy('urutan', 'asc')
        ->get();
        if($request->ajax()){
            return response()->json($data);
        }
    }
}
