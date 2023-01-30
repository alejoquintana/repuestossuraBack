<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */

Route::post('/upload-excel-file', 'TemporalImportController@tempImport');
Route::get('/failed-jobs','AdminController@getFailedJobs');


/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {



});