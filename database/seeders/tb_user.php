<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tb_user extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_user')->insert([
        	'username' 			=> 'administrator',
        	'password' 			=> \Hash::make('password'),
        	'email' 			=> 'admin@admin.com',
        	'active' 			=> '1',
        	'phone'			 	=> '087770067003',
        	'image'			 	=> '',
        	'nama'			 	=> 'administrator',
            'created_by'        => 'System',
        	'created_at'		=> date('Y-m-d H:i:s')
        ]);
    }
}
