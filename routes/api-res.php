<?php

use Illuminate\Http\Request;

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
/* 
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::get('/categories','CategoryController@getAll');

Route::get('/productsNotPaused','CategoryController@productsNotPaused');

Route::get('/metadatas','MetadataController@getAll');
Route::put('/metadata','MetadataController@update');

Route::get('/states','StateController@get');

Route::get('/city/{id}','StateController@getCity');


Route::get('/user','AuthController@getUser');

Route::post('/logout','AuthController@logout');

Route::post('/login','AuthController@login');

Route::get('/csrf','AuthController@csrf');

Route::get('/config','ConfigController@get');


Route::post('/contacto','MailController@contacto');

Route::post('/cotizer/send','OrderController@create');

Route::post('/searchHistory','SearchHistoryController@save');

/* ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {
    //

    Route::get('/failedjobs','AdminControllers@failedJobs');

    Route::get('/search-history','SearchHistoryController@get');

    Route::post('/category','CategoryController@create');
    Route::put('/category','CategoryController@update');

     Route::post('/category/image','CategoryController@uploadImage')->middleware('OptimizeImages');


    Route::post('/product','ProductController@create');
    Route::put('/product','ProductController@update');
    Route::delete('/product/{id}','ProductController@destroy');

    
      Route::get('/lista-de-precios','PdfController@prices');

   /*  Route::get('/busquedas','AdminController@searchHistory'); */
    
    /* Route::get('/','AdminController@cotizador'); */
   /*  Route::get('/cotizador','AdminController@cotizador'); */

    Route::put('/order','OrderController@edit');
   /*  Route::get('/ordenes','AdminController@orders'); */
    Route::get('/orders','OrderController@getOrders');

    Route::put('/config','ConfigController@update');

});


