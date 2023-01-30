<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */

Route::get('/user-orders','OrderController@getUserOrders');

Route::get('/last-order/{token}','OrderController@lastOrder');

Route::post('/order','OrderController@create');
Route::post('/check-list-status', 'OrderController@checkListStatus');

Route::get('/pdf/{reg_verif_code}/{id}', 'OrderController@toPDF');

Route::get('/fullor/{id}','OrderController@getFullOrderres');
Route::get('/edited-order-items/{id}','OrderController@getEditedOrderItems');

/* RUTAS PRIVADAS : ADMIN */

Route::group(['middleware' => 'CheckAdmin'], function () {
    

    Route::get('/ufo-stats', 'OrderController@getUfoStats');
    Route::get('/stats','OrderController@getStats');
    Route::get('/stats-month/{month}/{year}','OrderController@getMonthStats');
    Route::get('/stats-provincia/{month?}/{year?}', 'OrderController@getProvinceStats');

    Route::get('/orders','OrderController@get');
    Route::get('/full-order/{id}','OrderController@getFullOrder');
    Route::post('/get-paginated-orders','OrderController@getPaginated');
    Route::post('/edited-order','OrderController@saveEditedOrder');
   
    Route::get('/new-orders','OrderController@getNew');
    Route::get('/canceled-orders','OrderController@getCanceledOrders');
    
    Route::put('/order','OrderController@update');

});