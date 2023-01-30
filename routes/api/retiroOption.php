<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */

Route::get('retiro-options','RetiroOptionController@get');

/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {

    Route::post('/retiro-option','RetiroOptionController@create');
    Route::put('/retiro-option','RetiroOptionController@update');
    Route::delete('/retiro-option/{id}','RetiroOptionController@destroy');

});