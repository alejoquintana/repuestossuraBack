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
/* 
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

/* Route::get('danger-set-ufo', 'OrderController@dangerSetUFOS'); */

/* 
Route::get('/slides','SlideController@get');

Route::get('/fileuris','FileuriController@get');
 */



/* ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {
    // 

    

    /* Route::get('/failedjobs','AdminController@failedJobs'); */

    
    
    
    
    
    

   /*  Route::get('/busquedas','AdminController@searchHistory'); */
    
    /* Route::get('/','AdminController@cotizador'); */
   /*  Route::get('/cotizador','AdminController@cotizador'); */
    
   /*  Route::get('/ordenes','AdminController@orders'); */  

});
