<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['api']], function(){
    Route::post('auth/signup', 'AuthController@signup');
    Route::post('auth/login', 'AuthController@login');
    Route::get('auth/profile', 'AuthController@profile');

    Route::post('role/create', 'RoleController@create'); 
    Route::get('role/list', 'RoleController@list');

    Route::post('category/add', 'CategorController@add'); 
    Route::get('category/list', 'CategorController@list');

    Route::post('building-type/add', 'BuldingTypeController@add'); 
    Route::get('building-type/list', 'BuldingTypeController@list');

    Route::post('building-model/add', 'BuldingModelController@add'); 
    Route::get('building-model/list', 'BuldingModelController@list');

    Route::post('surface-area/add', 'SurfaceAreaController@add'); 
    Route::get('surface-area/list', 'SurfaceAreaController@list');

    Route::post('product/create', 'ProductController@create'); 

    Route::get('product/list', 'ProductController@filter'); 
    Route::get('product/list', 'ProductController@list'); 

});


