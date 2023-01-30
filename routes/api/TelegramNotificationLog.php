<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/telegram_notifications_listener', 'TelegramNotificationLogController@handle');
Route::post('/suspend-telegram-notifications', 'TelegramNotificationLogController@suspend');
Route::get('/test-job', 'TelegramNotificationLogController@testJob');


Route::middleware('CheckSuper')->group(function(){


});

/* FACEBOOK LOGIN */


/* */

Route::middleware('CheckAdmin')->group(function(){


});
