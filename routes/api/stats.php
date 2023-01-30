<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */

Route::get('/sales-years','StatsController@getSalesYears');
Route::get('/sales-chart-stats','StatsController@getSalesChartStats');

Route::get('/sales-states','StatsController@getSalesByStates');
Route::get('/sales-states-date/{year}/{month}','StatsController@getSalesByStatesAndDate');

Route::get('/surveys-stats-years','StatsController@getSurveysYears');
Route::get('/surveys-stats-by-date/{year}/{month}','StatsController@getSurveysStatDate');
Route::get('/surveys-by-date/{year}/{month}','StatsController@getSurveysDate');

Route::get('/sales-stats','StatsController@getSalesStats');
Route::get('/canceled-sales-stats','StatsController@getCanceledSalesStats');

Route::get('/most-sold-stats/{year}/{month}','StatsController@getMostSoldStat');

Route::get('/search-history/{year}/{month}','StatsController@getSearchHistory');
Route::get('/search-history-years','StatsController@getSearchHistoryYears');

Route::get('/ufos-stats','StatsController@getUfoStats');

Route::get('/stats-month/{month}/{year}','StatsController@getMonthStats');
Route::get('/stats-month-by-delivery/{month}/{year}', 'StatsController@getMonthStatsByDelivery');
Route::get('/canceled-stats', 'StatsController@getCanceledStats');
Route::get('/canceled-stats-month/{month}/{year}', 'StatsController@getCanceledMonthStats');

/* RUTAS PRIVADAS : ADMIN */
Route::group(['middleware' => 'CheckAdmin'], function () {
    
    Route::get('/repeated-url','StatsController@getRepeatedUrl');

});