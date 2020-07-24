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

Route::get('/import', 'ImportDataController@index'); // index page to view data sources and import history

Route::post('/import/{dataSourceId}', 'ImportDataController@fetchUpdates'); //  fetch updates ffrom a datasource

Route::get('/import/edit/{dataSourceId}', 'ImportDataController@edit'); // page to edit data source record

Route::put('/import/edit/{dataSourceId}', 'ImportDataController@submitEdit'); // saving a datasource record