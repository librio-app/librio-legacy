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

Route::group(['middleware' => 'language'], function () {
    // auth
    Route::group(['middleware' => 'auth:web'], function () {
        Route::get('/', 'Common\DashboardController@show')->name('dashboard');
        Route::get('/quick-search', 'Common\QuickSearchController@index')->name('quick.search');

        // logout
        Route::group(['prefix' => 'admin/auth'], function () {
            Route::get('logout', 'Auth\Admin\LoginController@destroy')->name('admin.logout');
        });

        // admin|manager permissions
        Route::group(['middleware' => ['role:admin|manager', 'permission:read-admin-panel']], function () {

            // users
            Route::group(['prefix' => 'auth'], function () {
                Route::resource('users', 'Auth\Admin\UsersController');
                //Route::resource('roles', 'Auth\RolesController');
                //Route::resource('permissions', 'Auth\PermissionsController');

                Route::get('users/{user}/enable', 'Auth\Admin\UsersController@enable')->name('users.enable');
                Route::get('users/{user}/disable', 'Auth\Admin\UsersController@disable')->name('users.disable');
            });
        });

        // admin|manager|user permissions
        Route::group(['middleware' => ['role:admin|manager|user', 'permission:read-catalog-panel']], function () {
            // common
            Route::group(['prefix' => 'common'], function () {
                Route::resource('notes', 'Common\NotesController');
            });

            // catalog
            Route::group(['prefix' => 'catalog'], function () {
                Route::get('books/download', 'Catalog\BooksController@download')->name('books.download');
                Route::resource('books', 'Catalog\BooksController');
                Route::get('books/{book}/details', 'Catalog\BooksController@details')->name('books.details');
                Route::get('books/{book}/enable', 'Catalog\BooksController@enable')->name('books.enable');
                Route::get('books/{book}/disable', 'Catalog\BooksController@disable')->name('books.disable');

                Route::post('book/{book}/barcodes/add', 'Catalog\BarcodesController@store');
                Route::delete('barcodes/{barcode}', 'Catalog\BarcodesController@destroy');
                Route::get('barcode/status', 'Catalog\BarcodesController@status')->name('barcode.status');
                Route::post('barcode/status', 'Catalog\BarcodesController@changeStatus');

                Route::resource('authors', 'Catalog\AuthorsController');
                Route::get('authors/{author}/details', 'Catalog\AuthorsController@details')->name('authors.details');
                Route::get('authors/{author}/enable', 'Catalog\AuthorsController@enable')->name('authors.enable');
                Route::get('authors/{author}/disable', 'Catalog\AuthorsController@disable')->name('authors.disable');

                Route::resource('publishers', 'Catalog\PublishersController');
                Route::get('publishers/{publisher}/details', 'Catalog\PublishersController@details')->name('publishers.details');
                Route::get('publishers/{publisher}/enable', 'Catalog\PublishersController@enable')->name('publishers.enable');
                Route::get('publishers/{publisher}/disable', 'Catalog\PublishersController@disable')->name('publishers.disable');

                Route::resource('categories', 'Catalog\CategoriesController');
                Route::get('categories/{category}/enable', 'Catalog\CategoriesController@enable')->name('categories.enable');
                Route::get('categories/{category}/disable', 'Catalog\CategoriesController@disable')->name('categories.disable');

                Route::resource('series', 'Catalog\SeriesController');
                Route::delete('series/books/{book}', 'Catalog\SeriesController@removeBook');
                Route::get('series/{series}/enable', 'Catalog\SeriesController@enable')->name('series.enable');
                Route::get('series/{series}/disable', 'Catalog\SeriesController@disable')->name('series.disable');

                Route::resource('themes', 'Catalog\ThemesController');
                Route::get('themes/{theme}/add/books', 'Catalog\ThemesController@addBooks')->name('themes.add');
                Route::post('themes/{theme}/add/book', 'Catalog\ThemesController@addBook');
                Route::delete('themes/{theme}/remove/book/{book}', 'Catalog\ThemesController@removeBook');
                Route::get('themes/{theme}/enable', 'Catalog\ThemesController@enable')->name('themes.enable');
                Route::get('themes/{theme}/disable', 'Catalog\ThemesController@disable')->name('themes.disable');
                Route::get('themes/{theme}/download', 'Catalog\ThemesController@download')->name('themes.download');

                Route::resource('types', 'Catalog\TypesController');
            });

            // member
            Route::group(['prefix' => 'member'], function () {
                Route::get('lend', 'Member\LendController@index')->middleware('shortcut')->name('lend');
                Route::get('lend/{member}', 'Member\LendController@overview')->name('lend.member');
                Route::post('lend/{member}', 'Member\LendController@store')->middleware('shortcut');
                Route::get('history/{member}', 'Member\HistoryController@index');

                Route::get('take-in', 'Member\TakeInController@index')->name('take-in.member');
                Route::post('take-in', 'Member\TakeInController@store')->middleware('shortcut');

                Route::resource('reservations', 'Member\ReservationsController');
                Route::post('reserve/{member}', 'Member\ReservationsController@store');
                Route::delete('reserve/{reservation}', 'Member\ReservationsController@destroy');

                Route::get('pay/{member}', 'Member\PayController@index')->name('pay.member');
                Route::post('pay/{member}', 'Member\PayController@store');
            });

            // modals
            Route::group(['prefix' => 'modals'], function () {
                Route::get('series/create', 'Modals\SeriesController@create');
                Route::post('series', 'Modals\SeriesController@store');

                Route::get('author/create', 'Modals\AuthorController@create');
                Route::post('author', 'Modals\AuthorController@store');

                Route::get('publisher/create', 'Modals\PublisherController@create');
                Route::post('publisher', 'Modals\PublisherController@store');

                Route::get('category/create', 'Modals\CategoryController@create');
                Route::post('category', 'Modals\CategoryController@store');

                Route::get('type/create', 'Modals\TypeController@create');
                Route::post('type', 'Modals\TypeController@store');

                Route::get('theme/create', 'Modals\ThemeController@create');
                Route::post('theme', 'Modals\ThemeController@store');
            });
        });

        // admin|manager|user permissions
        Route::group(['middleware' => ['role:admin|manager|user', 'permission:read-administration-panel']], function () {
            // members
            Route::group(['prefix' => 'administration'], function () {
                Route::get('members/download', 'Administration\MembersController@download')->name('members.download');
                Route::resource('members', 'Administration\MembersController');
                Route::get('members/{member}/details', 'Administration\MembersController@details')->name('members.details');
                Route::get('members/{member}/enable', 'Administration\MembersController@enable')->name('members.enable');
                Route::get('members/{member}/disable', 'Administration\MembersController@disable')->name('members.disable');
                Route::get('members/{member}/activate-account', 'Administration\MembersController@activateAccount')->name('members.activateAccount');
                Route::get('members/{member}/deactivate-account', 'Administration\MembersController@deactivateAccount')->name('members.deactivateAccount');

                Route::resource('subscriptions', 'Administration\SubscriptionsController');
                Route::get('subscriptions/{subscription}/enable', 'Administration\SubscriptionsController@enable')->name('subscriptions.enable');
                Route::get('subscriptions/{subscription}/disable', 'Administration\SubscriptionsController@disable')->name('subscriptions.disable');
            });
        });

        // admin|manager|user permissions
        Route::group(['middleware' => ['role:admin|manager|user', 'permission:read-statistics-panel']], function () {
            // members
            Route::group(['prefix' => 'statistics'], function () {
                Route::get('books', 'Statistics\BooksController@books');
                Route::get('year', 'Api\ChartController@year');
                Route::get('month', 'Api\ChartController@month');
            });
        });
    });

    // guest web
    Route::group(['middleware' => 'guest:web'], function () {
        Route::get('activate/{confirmationKey}', 'Auth\ActivateMemberController@show')->name('member.activate');
        Route::post('activate/{confirmationKey}', 'Auth\ActivateMemberController@activate')->name('member.confirm');

        Route::group(['prefix' => 'admin/auth'], function () {
            Route::get('login', 'Auth\Admin\LoginController@show')->name('admin.login');
            Route::post('login', 'Auth\Admin\LoginController@store');

            Route::get('forgot', 'Auth\Admin\ForgotPasswordController@show')->name('admin.forgot');
            Route::post('forgot', 'Auth\Admin\ForgotPasswordController@store');

            Route::get('reset/{token}', 'Auth\Admin\ResetPasswordController@show')->name('admin.reset');
            Route::post('reset', 'Auth\Admin\ResetPasswordController@store');
        });

        Route::group(['middleware' => 'install'], function () {
            Route::group(['prefix' => 'install'], function () {
                Route::get('/', 'Install\RequirementsController@show');
                Route::get('requirements', 'Install\RequirementsController@show');

                Route::get('language', 'Install\LanguageController@show');
                Route::post('language', 'Install\LanguageController@store');

                Route::get('database', 'Install\DatabaseController@show');
                Route::post('database', 'Install\DatabaseController@store');

                Route::get('settings', 'Install\SettingsController@show');
                Route::post('settings', 'Install\SettingsController@store');
            });
        });
    });

    // guest opac
    Route::group(['middleware' => 'guest:opac'], function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::get('login', 'Auth\LoginController@show')->name('login');
            Route::post('login', 'Auth\LoginController@store');

            Route::get('forgot', 'Auth\ForgotPasswordController@show')->name('forgot');
            Route::post('forgot', 'Auth\ForgotPasswordController@store');

            Route::get('reset/{token}', 'Auth\ResetPasswordController@show')->name('reset');
            Route::post('reset', 'Auth\ResetPasswordController@store');
        });
    });
});
