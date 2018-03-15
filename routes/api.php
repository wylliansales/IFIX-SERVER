<?php



Route::post('users','UserController@store');
Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken')->middleware('addScope', 'check.user');


Route::middleware('auth:api')->group(function (){

    Route::prefix('users')->group(function () {
        Route::get('','UserController@index')->middleware('scope:manage-user');
        Route::get('/blocked','UserController@blocked')->middleware('scope:manage-user');
        Route::get('/released','UserController@released')->middleware('scope:manage-user');
        Route::get('/{id}','UserController@show')->middleware('scope:manage-user,read-only-user');
        Route::put('/{id}','UserController@update')->middleware('scope:manage-user, edit-only-user');
        Route::put('/userlogin','UserController@getUserLogin');
        Route::put('/release/{id}','UserController@releaseUser')->middleware('scope:manage-user');
        Route::put('/block/{id}','UserController@blockUser')->middleware('scope:manage-user');
        Route::delete('/{id}','UserController@destroy')->middleware('scope:manage-user');
    });


    Route::prefix('attendants')->group(function (){
        Route::get('my-requests','AttendantController@myRequests')->middleware('scope:manage-user, read-only-attendant');
        Route::get('','AttendantController@index')->middleware('scope:manage-user');
        Route::post('', 'AttendantController@store')->middleware('scope:manage-attendant');
        Route::get('/{id}','AttendantController@show')->middleware('scope:manage-attendant,read-only-attendant');
        Route::put('','AttendantController@update')->middleware('scope:manage-attendant, edit-only-attendant');
        Route::delete('','AttendantController@destroy')->middleware('scope:manage-attendant');
    });



    Route::prefix('sectors')->group(function () {
        Route::get('','SectorController@index')->middleware('scope:manage-user');
        Route::post('', 'SectorController@store')->middleware('scope:manage-user');
        Route::get('/{id}','SectorController@show')->middleware('scope:manage-user,read-only-user');
        Route::put('/{id}','SectorController@update')->middleware('scope:manage-user, edit-only-user');
        Route::delete('/{id}','SectorController@destroy')->middleware('scope:manage-user');
    });

    Route::prefix('equipments')->group(function () {
        Route::get('','EquipmentController@index')->middleware('scope:manage-user');
        Route::post('', 'EquipmentController@store')->middleware('scope:manage-user');
        Route::get('/{id}','EquipmentController@show')->middleware('scope:manage-user,read-only-user');
        Route::put('/{id}','EquipmentController@update')->middleware('scope:manage-user, edit-only-user');
        Route::delete('/{id}','EquipmentController@destroy')->middleware('scope:manage-user');
    });

    Route::prefix('departments')->group(function () {
        Route::get('','DepartmentController@index')->middleware('scope:manage-user');
        Route::post('', 'DepartmentController@store')->middleware('scope:manage-user');
        Route::get('/{id}','DepartmentController@show')->middleware('scope:manage-user,read-only-user');
        Route::put('/{id}','DepartmentController@update')->middleware('scope:manage-user, edit-only-user');
        Route::delete('/{id}','DepartmentController@destroy')->middleware('scope:manage-user');
    });

    Route::prefix('categories')->group(function () {
        Route::get('','CategoryController@index')->middleware('scope:manage-user');
        Route::post('', 'CategoryController@store')->middleware('scope:manage-user');
        Route::get('/{id}','CategoryController@show')->middleware('scope:manage-user,read-only-user');
        Route::put('/{id}','CategoryController@update')->middleware('scope:manage-user, edit-only-user');
        Route::delete('/{id}','CategoryController@destroy')->middleware('scope:manage-user');
    });

    Route::prefix('requests')->group(function () {
        Route::get('','RequestController@index')->middleware('scope:manage-user');
        Route::get('news','RequestController@newsRequests')->middleware('scope:manage-user,read-only-user');
        Route::get('open','RequestController@openRequests')->middleware('scope:manage-user,read-only-user');
        Route::get('linked','RequestController@linkedRequests')->middleware('scope:manage-user,read-only-user');
        Route::get('closed','RequestController@closedRequests')->middleware('scope:manage-user,read-only-user');
        Route::post('', 'RequestController@store');
        Route::get('/{id}','RequestController@show')->middleware('scope:manage-user,read-only-user');
        Route::put('/meet/{id}','RequestController@meet')->middleware('scope:manage-user,read-only-user');
        Route::put('/finalize/{id}','RequestController@finalize')->middleware('scope:manage-user,read-only-user');
        Route::put('/{id}','RequestController@update')->middleware('scope:manage-user');
        Route::delete('/{id}','RequestController@destroy')->middleware('scope:manage-user');
    });

    Route::prefix('status')->group(function () {
        Route::get('','StatusController@index')->middleware('scope:manage-user');
        Route::post('', 'StatusController@store')->middleware('scope:manage-user');
        Route::get('/{id}','StatusController@show')->middleware('scope:manage-user,read-only-user');
        Route::put('/{id}','StatusController@update')->middleware('scope:manage-user, edit-only-user');
        Route::delete('/{id}','StatusController@destroy')->middleware('scope:manage-user');
    });

});
