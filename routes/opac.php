<?php

/*
|--------------------------------------------------------------------------
| Opac Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "opac" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'language'], function () {
    // auth
    Route::group(['middleware' => 'auth:opac,web'], function () {
        Route::get('/', 'Opac\OpacController@index')->name('opac');
        Route::get('search', 'Opac\OpacController@search');
        Route::get('quick-search', 'Opac\OpacController@quickSearch');

        Route::group(['prefix' => 'auth'], function () {
            Route::get('logout', 'Auth\LoginController@destroy')->name('logout');
        });
    });
});
