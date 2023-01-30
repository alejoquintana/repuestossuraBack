<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */

Route::post('/delete-user-data','AuthController@deleteUserData');

Route::get('test','AuthController@test');

Route::get('/login/fb','AuthController@fblogin');
Route::get('/fbcallback','AuthController@fbcallback');

Route::get('/user','AuthController@getUser');

Route::get('/logout','AuthController@logout');

Route::post('/login','AuthController@login');

Route::post('/restorePass','AuthController@restorePass');
Route::post('/register','AuthController@register');
Route::post('/reg-confirm','AuthController@regConfirm');

Route::post('/new-password','AuthController@changePass');

/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {

    Route::put('/user','AuthController@updateUser');
    Route::put('/user/password','AuthController@changePassword');

    Route::get('/users-list/{search?}','AuthController@usersList');
    Route::get('/users-monthly','AuthController@usersMonthly');
    Route::get('/users-daily/{month}/{year}','AuthController@usersDaily');

    Route::get('/all-users','AuthController@getAllUsers');

});