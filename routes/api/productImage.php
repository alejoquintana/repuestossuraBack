<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */



/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {

    Route::post('/product/image', 'ProductImageController@create')->middleware('OptimizeImages');;
    Route::put('/product/image', 'ProductImageController@update');
    Route::delete('/product/image/{id}', 'ProductImageController@destroy');
    Route::put('/product/images-order', 'ProductImageController@reOrder');


});