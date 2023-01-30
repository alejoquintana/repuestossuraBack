<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */

Route::get('/app-images','AppimageController@getAll');
Route::get('/appimage/{name}','AppimageController@getByName');

/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {

    Route::post('/app-images','AppimageController@create');
    Route::post('/banner-home','AppimageController@createBannerHome');
    Route::post('/app-images/upload','AppimageController@upload');
    Route::put('/app-images','AppimageController@update');
    Route::delete('/app-images/{id}','AppimageController@destroy');

});