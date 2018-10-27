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
Route::group(['middleware' => 'cors'], function() {
    Route::get('user', 'Api\UserController@index');

});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//User
Route::get('user', 'Api\UserController@index');
Route::post('user', 'Api\UserController@store');
//Auth
Route::post('login', 'Api\AuthController@login');

//Role
Route::resource('role', 'Api\RoleController');
Route::resource('ca', 'Api\CaController');
Route::resource('thu', 'Api\ThuController');
Route::resource('hoc-ky', 'Api\HocKyController');

//Import Lich Day
Route::post('import-excel','Api\LichDayController@import');
Route::get('get-lich','Api\LichDayController@index');
Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function ($router) {


    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

