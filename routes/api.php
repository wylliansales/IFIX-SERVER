<?php


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
Route::post('login', 'UserController@createToken');

Route::post('users','UserController@store');
Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken')->middleware('addScope');


Route::middleware('auth:api')->group(function (){

    Route::prefix('users')->group(function () {
        Route::get('','UserController@index')->middleware('scope:manage-user');
        Route::get('/{id}','UserController@show')->middleware('scope:manage-user,read-only-user');
        Route::put('/{id}','UserController@update')->middleware('scope:manage-user, edit-only-user');
        Route::delete('/{id}','UserController@destroy')->middleware('scope:manage-user');
    });



       Route::get('/attendants','AttendantController@index')->middleware('scope:manage-attendant');
       Route::post('/attendants', 'AttendantController@store')->middleware('scope:manage-attendant');
       Route::get('/attendants/{id}','AttendantController@show')->middleware('scope:manage-attendant,read-only-attendant');
       Route::put('/attendants','AttendantController@update')->middleware('scope:manage-attendant, edit-only-attendant');
       Route::delete('/attendants','AttendantController@destroy')->middleware('scope:manage-attendant');


    Route::prefix('sectors')->group(function () {
        Route::get('','SectorController@index')->middleware('scope:manage-user');
        Route::post('', 'SectorController@store')->middleware('scope:manage-user');
        Route::get('/{id}','SectorController@show')->middleware('scope:manage-user,read-only-user');
        Route::put('/{id}','SectorController@update')->middleware('scope:manage-user, edit-only-user');
        Route::delete('/{id}','SectorController@destroy')->middleware('scope:manage-user');
    });
});



Route::resource('/departments', 'DepartmentController');
Route::resource('/categories','CategoryController');
Route::resource('/equipments','EquipmentController');
Route::resource('/requests','RequestController');