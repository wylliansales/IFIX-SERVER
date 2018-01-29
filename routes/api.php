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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

//Route::resource('/users', 'UserController');

Route::post('login', 'UserController@createToken');


Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken')->middleware(\App\Http\Middleware\AddScopes::class);

/*Route::group(['App' => 'Auth'], function(){
   Route::post('login', 'ApiController@login');
});*/



Route::get('/users','UserController@index')->middleware('auth:api','scope:manage-user');
Route::get('/users/{id}','UserController@show')->middleware('auth:api','scope:manage-user, read-only-user');
Route::put('/users/{id}','UserController@update');
Route::post('/users', 'UserController@store');

Route::resource('/attendants', 'AttendantController')->middleware('auth:api');
Route::resource('/departments', 'DepartmentController');
Route::resource('/categories','CategoryController');
Route::resource('/equipments','EquipmentController');
Route::resource('/requests','RequestController');