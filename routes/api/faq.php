<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */

Route::get('/faq','FaqController@get');

/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {

    Route::post('/faq','FaqController@create');
    Route::put('/faq','FaqController@update');
    Route::delete('/faq/{id}','FaqController@destroy');

});