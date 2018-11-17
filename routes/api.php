<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::group(['middleware' => 'cors'], function() {
//     Route::get('user', 'Api\UserController@index');

// });
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//User
//social
//Route::get('/redirect', 'Auth\LoginController@redirectToProvider');
//Route::get('/callback/google', 'Auth\LoginController@handleProviderCallback');
//Route::get('user', 'Api\UserController@index');
//Route::post('user', 'Api\UserController@store');
Route::resource('user', 'Api\UserController');

//Auth
Route::post('login', 'Api\AuthController@login');
Route::get('get-user', 'Api\AuthController@getUser');
Route::post('google', 'Api\CaController@google');
//Role
Route::resource('role', 'Api\RoleController');
Route::resource('ca', 'Api\CaController');
Route::resource('thu', 'Api\ThuController');
Route::resource('hoc-ky', 'Api\HocKyController');
Route::resource('tuan', 'Api\TuanController');
Route::resource('phong-may', 'Api\PhongMayController');
Route::put('change-password/{id}', 'Api\UserController@changePassword');

Route::get('show-mo-ta-id/{id}', 'Api\PhongMayController@showMoTaID');
Route::delete('delete-id/{id}', 'Api\PhongMayController@deleteID');



Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');

Route::get('get-lich', 'Api\LichDayController@index');

//Import Lich Day
Route::post('import-excel', 'Api\LichDayController@import');

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('get-lich-gv', 'Api\LichDayController@getLichDayFromGv');
    Route::resource('mon-hoc', 'Api\MonHocController');
    Route::resource('dk-muon-phong', 'Api\MuonPhongController');
    Route::resource('dang-ky-nghi', 'Api\DangKyNghiController');
    Route::post('add-mo-ta', 'Api\PhongMayController@addMoTaMay');
    Route::get('list-mo-ta', 'Api\PhongMayController@getMoTaMay');
    Route::put('ktv-update-mo-ta/{id}', 'Api\PhongMayController@ktvUpdateMoTa');
    Route::put('gv-update-mo-ta/{id}', 'Api\PhongMayController@gvUpdateMoTa');


});
// Route::group([

//     'middleware' => 'api',
//     'namespace' => 'App\Http\Controllers',
//     'prefix' => 'auth'

// ], function ($router) {


//     Route::post('logout', 'AuthController@logout');
//     Route::post('refresh', 'AuthController@refresh');
//     Route::post('me', 'AuthController@me');

// });

