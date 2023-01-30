<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */

Route::get('/locations','LocationController@get');

/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {

    Route::post('/location','LocationController@create');
    Route::put('/location','LocationController@update');
    Route::delete('/location/{id}','LocationController@destroy');

});