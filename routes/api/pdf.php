<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */

Route::get('/url-lista-de-precios','PdfController@getPricesList');
Route::get('/url-catalogo','PdfController@getCatalogo');

/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {

    Route::post('/replace-catalogo','PdfController@replaceCatalogo');
    Route::post('/replace-catalogo-sin-precios','PdfController@replaceCatalogoSinPrecios');    
    
    Route::get('/prices-list-job','PdfController@dispatchPricesListJob');
    Route::get('/sorteo-pdf','PdfController@dispatchSorteoCuponsJob');
    
    Route::get('/category-catalogo-job/{id}','PDFController@dispatchCategoryCatalogJob');
    Route::get('/catalogo-job','PdfController@dispatchCatalogoJob');
    Route::get('/catalogo-deposito-job','PdfController@dispatchCatalogoJob');
    Route::get('/processing-job', 'PdfController@processingJob');

    Route::get('/refresh-prices','PdfController@prices');

});