<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */

Route::get('/meta','MetadataController@getAll');

Route::get('/metadatas','MetadataController@getAll');

/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {
    
    Route::put('/metadata','MetadataController@update');

});