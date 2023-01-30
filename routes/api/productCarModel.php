<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */
Route::get('/all-product-car-model','ProductCarModelController@getAll');
Route::get('/relations/{type}/{id}','ProductCarModelController@getById');

/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {
    Route::post('/product-car-model','ProductCarModelController@create');
    Route::put('/product-car-model','ProductCarModelController@update');
    Route::delete('/product-car-model/{id}','ProductCarModelController@destroy');
    //Route::delete('/product/{product_id}/car-model/{car_model_id}','ProductCarModelController@destroy');
    Route::post('/import/product-car-model','ProductCarModelController@import');
});

Route::group(['middleware' => 'CheckSuper'], function () {
    
});