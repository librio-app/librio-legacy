<?php

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


Route::group(['middleware' => 'language'], function () {
    Route::group(['middleware' => 'api'], function () {
        Route::group(['prefix' => 'catalog'], function () {

            // code check
            Route::post('categories/codes', 'Api\CatalogController@categoriesCodes');
            Route::post('authors/codes', 'Api\CatalogController@authorsCodes');
            Route::post('publishers/codes', 'Api\CatalogController@publishersCodes');
            Route::post('books/codes', 'Api\CatalogController@booksCodes');
            Route::post('series/codes', 'Api\CatalogController@seriesCodes');
            Route::post('types/codes', 'Api\CatalogController@typesCodes');
        });
    });
});