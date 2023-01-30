<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */

Route::get('/categories','CategoryController@getAll');
Route::get('/category/{id}','CategoryController@get');

Route::get('/productsnotpaused','CategoryController@getNotPaused');

Route::get('/categories/{category}','CategoryController@get');

Route::get('/productsNotPaused','CategoryController@productsNotPaused');

/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {

    Route::post('/category/image','CategoryController@uploadImage')->middleware('OptimizeImages');
    
    Route::post('/category','CategoryController@create');
    Route::put('/category','CategoryController@update');
    Route::delete('/category/{id}','CategoryController@destroy');
    
    Route::post('/import/categories','CategoryController@import');
});