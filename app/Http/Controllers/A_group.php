<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use \App\Models\MA_group;
use \App\Models\MA_admin;

class A_group extends Controller
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
            ->where('tb_user_menu.url', 'group_admin')
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
                    $data = MA_group::select(
                        'id',
                        'name',
                        'description',
                        'created_by',
                        'created_at',
                        'updated_by',
                        'updated_at'
                    )
                    ->where('deleted_at', null)
                    ->orderBy('id', 'asc')
                    ->get();
                    foreach ($data as $row) {
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
                    }
                    return view('admin.group')->with('active_menu', 'Group User')->with('akses_menu', $akses_temp);
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

        $data = MA_group::create(
            [
                'name'          => $request->level,
                'description'   => $request->deskripsi,
                'created_by'    => $sess_id,
                'created_at'    => date('Y-m-d H:i:s')
            ]
        );
        if($data){
            return response()->json([
                'success'   => true,
                'activity'  => 'Menambahkan id_group ' . $data->id,
                'type'      => 'disimpan'
            ]);
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
        $data = MA_group::find($id);
        return response()->json([
            'id'            => $data->id,
            'name'          => $data->name,
            'description'   => $data->description
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

        $data = MA_group::find($id);
        $data->name         = $request->level;
        $data->description  = $request->deskripsi;
        $data->updated_by   = $sess_id;
        $data->updated_at   = date('Y-m-d H:i:s');
        $data->save();

        return response()->json([
            'success'   => true,
            'activity'  => 'Mengupdate id_group ' . $id,
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
        // $data = MA_group::find($id);
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
        $data = MA_group::find($id);
        $data->deleted_by   = $sess_id;
        $data->deleted_at   = date('Y-m-d H:i:s');
        $data->save();

        DB::table('tb_user_group_2')
        ->where('id_group', $id)
        ->update([
            'deleted_by'   => $sess_id,
            'deleted_at'   => date('Y-m-d H:i:s')
        ]);
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

    public function akses(Request $request, $parameter)
    {
        $sess_id = Session::get('user.id');
        $sess_username = MA_admin::select('username')->where('id', $sess_id)->first()->username;
        $sess_id_group = DB::table('tb_user_group_2')->where('id_user', $sess_id)->first()->id_group;

        if(! Session::get('user.id')) {
            return Redirect("/"); 
        }else{
            if($sess_id_group == '1'){
                $deskripsi = MA_group::find($parameter)->description;
                $menu = DB::table('tb_user_menu')
                ->orderBy('tb_user_menu.urutan', 'asc')
                ->select('tb_user_menu.id', 'tb_user_menu.menu', 'tb_user_menu.urutan')
                ->where('tb_user_menu.rel', '0')
                ->where('tb_user_menu.deleted_at', null)
                ->get();
                foreach ($menu as $row) {
                    $akses = DB::table('tb_user_rel_group')
                    ->orderBy('tb_user_rel_group.akses', 'asc')
                    ->select('tb_user_rel_group.akses')
                    ->where('tb_user_rel_group.id_menu', $row->id)
                    ->where('tb_user_rel_group.id_group', $parameter)
                    ->where('tb_user_rel_group.deleted_at', null)
                    ->get();
                    if(count($akses) != 0){
                        $row->akses = array();
                        $arr_akses = array(1, 2, 3, 4);
                        $akses_temp = array();
                        foreach ($akses as $key) {
                            array_push($akses_temp, $key->akses);
                        }
                        foreach ($arr_akses as $key) {
                            if (in_array($key, $akses_temp)){
                                $key =  $key;
                                array_push($row->akses, $key);
                            }else{
                                $key = 0;
                                array_push($row->akses, $key);
                            }
                        }
                    }else{
                        $row->akses = array(0, 0, 0, 0);
                    }
                }
                if($request->ajax()){
                    return response()->json($menu);
                }
                return view('admin.group_access')->with('active_menu', 'Akses ' . $deskripsi)->with('id_group', $parameter);
            }else{
                return view('unauthorized');
            }
        }
    }

    public function sub_akses(Request $request, $parameter, $id)
    {
        $sess_id = Session::get('user.id');
        $sess_username = MA_admin::select('username')->where('id', $sess_id)->first()->username;

        $menu = DB::table('tb_user_menu')
        ->orderBy('tb_user_menu.urutan', 'asc')
        ->select('tb_user_menu.id', 'tb_user_menu.menu', 'tb_user_menu.urutan')
        ->where('tb_user_menu.rel', $id)
        ->where('tb_user_menu.deleted_at', null)
        ->get();
        foreach ($menu as $row) {
            $akses = DB::table('tb_user_rel_group')
            ->orderBy('tb_user_rel_group.akses', 'asc')
            ->select('tb_user_rel_group.akses')
            ->where('tb_user_rel_group.id_menu', $row->id)
            ->where('tb_user_rel_group.id_group', $parameter)
            ->where('tb_user_rel_group.deleted_at', null)
            ->get();
            if(count($akses) != 0){
                $row->akses = array();
                $arr_akses = array(1, 2, 3, 4);
                $akses_temp = array();
                foreach ($akses as $key) {
                    array_push($akses_temp, $key->akses);
                }
                foreach ($arr_akses as $key) {
                    if (in_array($key, $akses_temp)){
                        $key =  $key;
                        array_push($row->akses, $key);
                    }else{
                        $key = 0;
                        array_push($row->akses, $key);
                    }
                }
            }else{
                $row->akses = array(0, 0, 0, 0);
            }
        }
        if($request->ajax()){
            return response()->json($menu);
        }
    }

    public function update_akses(Request $request)
    {
        $sess_id = Session::get('user.id');
        $sess_username = MA_admin::select('username')->where('id', $sess_id)->first()->username;

        $arr_akses = array(1, 2, 3, 4);
        $id = $request->id_group;
        $arr_akses = $request->data;
        foreach ($arr_akses as $row) {
            $akses = DB::table('tb_user_rel_group')
            ->select('tb_user_rel_group.akses')
            ->where('tb_user_rel_group.id_menu', $row['id_menu'])
            ->where('tb_user_rel_group.id_group', $id)
            ->get();
            if(count($akses) == 0){
                for($i = 0; $i < count($row['akses']); $i ++){
                    if($row['akses'][$i] == 0){
                        DB::table('tb_user_rel_group')->insert([
                            'tb_user_rel_group.id_group'      => $id,
                            'tb_user_rel_group.id_menu'       => $row['id_menu'],
                            'tb_user_rel_group.akses'         => ($i + 1),
                            'tb_user_rel_group.created_by'    => $sess_id,
                            'tb_user_rel_group.created_at'    => date('Y-m-d H:i:s'),
                            'tb_user_rel_group.deleted_by'    => $sess_id,
                            'tb_user_rel_group.deleted_at'    => date('Y-m-d H:i:s')
                        ]);
                    }else{
                        DB::table('tb_user_rel_group')->insert([
                            'tb_user_rel_group.id_group'      => $id,
                            'tb_user_rel_group.id_menu'       => $row['id_menu'],
                            'tb_user_rel_group.akses'         => $row['akses'][$i],
                            'tb_user_rel_group.created_by'    => $sess_id,
                            'tb_user_rel_group.created_at'    => date('Y-m-d H:i:s')
                        ]);
                    }
                }
            }else{
                for($i = 0; $i < count($row['akses']); $i ++){
                    if($row['akses'][$i] == 0){
                        DB::table('tb_user_rel_group')
                        ->where('tb_user_rel_group.id_group', $id)
                        ->where('tb_user_rel_group.id_menu', $row['id_menu'])
                        ->where('tb_user_rel_group.akses', ($i + 1))
                        ->update([
                            'deleted_by'   => $sess_id,
                            'deleted_at'   => date('Y-m-d H:i:s')
                        ]);
                    }else{
                        DB::table('tb_user_rel_group')
                        ->where('tb_user_rel_group.id_group', $id)
                        ->where('tb_user_rel_group.id_menu', $row['id_menu'])
                        ->where('tb_user_rel_group.akses', $row['akses'][$i])
                        ->update([
                            'deleted_by'   => '',
                            'deleted_at'   => null
                        ]);
                    }
                }
            }
        }

        return response()->json([
            'success'   => true,
            'activity'  => 'Mengupdate akses menu id_group ' . $id,
            'type'      => 'diupdate'
        ]);
    }
}
