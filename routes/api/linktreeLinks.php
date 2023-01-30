<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */

Route::get('/linktree','LinktreeLinksController@get');

/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {

    Route::post('/link','LinktreeLinksController@create');
    Route::put('/link','LinktreeLinksController@update');
    Route::delete('/link/{id}','LinktreeLinksController@destroy');

});