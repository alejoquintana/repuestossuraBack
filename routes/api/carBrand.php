<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */

Route::get('/car-brands','CarBrandController@get');


/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {
    
    Route::post('/car-brand','CarBrandController@create');
    Route::put('/car-brand','CarBrandController@update');
    Route::delete('/car-brand/{id}','CarBrandController@destroy');
    
    Route::post('/import/car-brand/','CarBrandController@import');

});