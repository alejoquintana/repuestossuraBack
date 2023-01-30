<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */

Route::get('/states','StateController@get');

Route::get('/city/{id}','StateController@getCity');

Route::get('/states','StateController@get');
Route::get('/city/{id}','StateController@getCity');

/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {



});