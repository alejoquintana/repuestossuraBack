<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */

Route::get('/car-models','CarModelController@get');


/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {
    
    Route::post('/car-model','CarModelController@create');
    Route::put('/car-model','CarModelController@update');
    Route::delete('/car-model/{id}','CarModelController@destroy');
    
    Route::post('/import/car-models','CarModelController@import');
});