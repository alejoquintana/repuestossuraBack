<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */

Route::get('/black-bar-texts','BlackBarTextController@get');


/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {
    
    Route::post('/black-bar-text','BlackBarTextController@create');
    Route::put('/black-bar-text','BlackBarTextController@update');
    Route::delete('/black-bar-text/{id}','BlackBarTextController@destroy');

});