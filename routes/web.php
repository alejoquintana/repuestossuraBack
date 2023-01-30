<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/testoi','OrderController@testoi');

//Route::get('/testimage','MiniatureController@testcreate');

Route::get('/assign-tokens','AuthController@assign_reg_verif_codes'); 
Route::get('/sitemap.xml','SitemapController@sitemap');


/* 
Route::middleware('CheckSuper')->prefix('super')->group(function(){

    Route::get('/failed-jobs','SuperController@failedJobsView');

    Route::get('/', 'SuperController@panel');

    Route::put('/metadata','MetadataController@update');
    Route::get('/products','AdminController@tableView');
});
*/


 Route::get('/download-product-image/{id}','ProductImageController@downloadImage');

Route::middleware('CheckAdmin')->prefix('admin')->group(function(){

    Route::get('/lista-de-precios','PdfController@prices');

  
 
});

Route::get('/pdf/{reg_verif_code}/{order}','OrderController@toPDF');
Route::get('/pdf-original/{reg_verif_code}/{order}','OrderController@originalToPDF');
Route::get('/pdf-last-edition/{reg_verif_code}/{order}','OrderController@lastEditionToPDF');

Route::get('/descargar-lista-de-precios','PdfController@downloadPricesList');
Route::get('/descargar-cupones-sorteo','PdfController@downloadSorteoCupons');

Route::get('/descargar-catalogo-grande','PdfController@redirectCatalogoRaw');

Route::get('/descargar-catalogo-digital','PdfController@redirectCatalogo');
Route::get('/descargar-catalogo-sin-precios','PdfController@redirectCatalogoSinPrecios');

/* Route::get('/home', function(){return redirect('/');}); */
/* 
Route::get('/cotizador','HomeController@cotizer');
Route::get('/regalos-empresariales','HomeController@regalosEmpresariales'); */

/* Route::post('/regalos-empresariales','MailController@regalosEmpresariales')->middleware('OptimizeImages');; */
/* 
Route::get('/franquicia','HomeController@franquicia'); */
/* Route::post('/franquicia','MailController@franquicia'); */
/* 
Route::get('/sucursales','HomeController@sucursales');
Route::get('/contacto','HomeController@contacto'); */

/* Route::get('/buscar','ProductController@searchResults'); */

Route::get('/logout',function(){
    Auth::logout();
    return redirect('/');
});
Auth::routes();


Route::get('/getUser','HomeController@getUser');


Route::post('/suscription','SuscriptionController@create');

/* ESTAS RUTAS SIEMPRE AL FINAL */

Route::get('/{any}','SinglePageController@index')->where('any', '.*');
/* 

Route::get('/{category}','CategoryController@detail');

Route::get('/{category}/{product}','ProductController@detail'); */