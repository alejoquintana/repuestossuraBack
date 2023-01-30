<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */

Route::get('/configs','ConfigController@get');

/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {

    Route::post('/homebanner','ConfigController@homeBanner');

    Route::put('/configs','ConfigController@update');
    
});