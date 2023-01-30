<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */

Route::post('/regalos-empresariales','MailController@regalosEmpresariales');

Route::post('/contacto','MailController@contacto');

/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {



});