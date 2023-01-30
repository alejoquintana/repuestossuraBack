<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */

Route::post('/search-history','SearchHistoryController@save');


/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {

    Route::get('/search-history','SearchHistoryController@get');

});