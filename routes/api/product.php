<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */
Route::get('/all-products','ProductController@getAll');
Route::get('/most-sold','ProductController@getMostSold');
Route::get('/products','ProductController@getAll');
Route::get('/offers','ProductController@getOffers');
Route::get('/news','ProductController@getNews');
//Route::get('/found-products?model={model_code?}&category={category_code}','ProductController@getFoundProducts');
Route::post('/found-products','ProductController@getFoundProducts');
Route::get('/category-products/{category_id}','ProductController@getCategoryProducts');
Route::get('/testALL','ProductController@testALL');
Route::post('/paginated-products','ProductController@getPaginated');



/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {
    Route::post('/product','ProductController@create');
    Route::post('/import/products','ProductController@import');
    Route::put('/product', 'ProductController@update');
    Route::delete('/product/{id}','ProductController@destroy');
    Route::get('/download-image/{$id}','ProductController@downloadImage');
    Route::get('/products-updates-log','ProductController@getProductsUpdatesLog');
    Route::get('/products-no-photos','ProductController@getProductsWithNoPhotos');
});

Route::group(['middleware' => 'CheckSuper'], function () {
    
});