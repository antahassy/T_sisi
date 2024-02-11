<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use \App\Models\MA_dashboard;

class A_dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(! Session::get('user.id')) {
            return Redirect("user"); 
        }else{
            $sess_id = Session::get('user.id');
            $sess_id_group = DB::table('tb_user_group_2')->where('id_user', $sess_id)->first()->id_group;
            $akses = DB::table('tb_user_menu')
            ->select('tb_user_rel_group.akses')
            ->where('tb_user_menu.url', 'admin_dashboard')
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
                    return view('admin.dashboard')->with('active_menu', 'Dashboard')->with('akses_menu', $akses_temp);
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
        //
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
        //
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
        //
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

    public function test_api(){
        //$data = Http::get('https://laravel.com/docs/9.x/responses');10.209.246.228
        $data = Http::get('https://tools.keycdn.com/geo.json?host=www.astanamultiarta.com');

        // $data = Http::post('https://jsonplaceholder.typicode.com/posts', [
        //     'title' => 'foo',
        //     'body' => 'bar',
        //     'userId' => 1
        // ]);
        return $data;
        //return Http::dd()->get('http://127.0.0.1:8000/api/admin');
    }
}
