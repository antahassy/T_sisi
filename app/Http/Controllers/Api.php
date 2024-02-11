<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MA_admin;
use App\Http\Resources\Api_resource;

class Api extends Controller
{
    public function index(){
        $data = MA_admin::select(
            'id',
            'username',
            'email',
            'active',
            'phone',
            'image',
            'nama',
            'alamat',
            'created_by',
            'created_at',
            'updated_by',
            'updated_at'
        )
        ->where('deleted_at', null)
        ->orderBy('id', 'asc')
        ->get();
        // Api non resource
        // return response()->json([
        //     'data'      => $data
        // ]);

        // Api resource
        return Api_resource::collection($data);
    }
    public function detail($id){
        $data = MA_admin::findOrFail($id);
        return response()->json(['data' => $data]);
    }
}
