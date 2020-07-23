<?php

use Illuminate\Support\Facades\Route;

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



// main search/landing page
Route::get('/', 'SearchController@index'); // home page for search functionality

Route::get('/typeaheadSearch', 'SearchController@typeaheadSearch'); // typeahead search endpoint

Route::post('/search/export', 'SearchController@export'); // typeahead search endpoint

Route::get('/search/view/{generalPaymentDataId}', 'SearchController@view'); // typeahead search endpoint

Route::get('/import', 'ImportDataController@index');

Route::post('/import/{dataSourceId}', 'ImportDataController@import');