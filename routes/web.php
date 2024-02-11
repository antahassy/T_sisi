<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\A_login;
use App\Http\Controllers\A_dashboard;
use App\Http\Controllers\A_admin;
use App\Http\Controllers\A_menu;
use App\Http\Controllers\A_group;
use App\Http\Controllers\A_setting;
use App\Http\Controllers\A_error;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/', function () {
//     return 'Homepage'; 
// });
Route::resource('/', A_login::class);
Route::post('admin/login', [A_login::class, 'login']);

Route::group(['middleware' => 'user_session'], function() {
	Route::resource('admin_dashboard', A_dashboard::class);
	
	Route::resource('list_admin', A_admin::class);
	Route::post('list_admin/hapus', [A_admin::class, 'hapus']);
	Route::post('list_admin/aktifkan', [A_admin::class, 'aktifkan']);
	Route::post('list_admin/non_aktifkan', [A_admin::class, 'non_aktifkan']);

	Route::resource('group_admin', A_group::class);
	Route::post('group_admin/hapus', [A_group::class, 'hapus']);
	Route::get('group_admin/akses/{parameter}', [A_group::class, 'akses']);
	Route::get('group_admin/sub_akses/{parameter}/{id}', [A_group::class, 'sub_akses']);
	Route::post('group_admin/update_akses', [A_group::class, 'update_akses']);

	Route::resource('menu_admin', A_menu::class);
	Route::post('menu_admin/hapus', [A_menu::class, 'hapus']);
	Route::post('menu_admin/rel_menu', [A_menu::class, 'rel_menu']);

	Route::resource('setting_admin', A_setting::class); 

	Route::get('admin_logout', [A_login::class, 'logout']);

	Route::get('test_api', [A_dashboard::class, 'test_api']);
});
Route::resource('error', A_error::class);
