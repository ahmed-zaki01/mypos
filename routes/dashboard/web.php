<?php

use Illuminate\Support\Facades\Route;


// Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
// });

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function () {

            Route::get('/', 'DashboardController@index')->name('index');
            Route::get('/logout', 'DashboardController@logout')->name('logout');


            //user routes
            Route::resource('users', 'UserController')->except(['show']);

            //category routes
            Route::resource('cats', 'CatController')->except(['show']);
            // Route::prefix('cats')->name('cats.')->group(function () {
            //     Route::get('/create', ['middleware' => ['permission:create_cats'], 'uses' => 'CatController@create'])->name('create');
            // });

            //product routes
            Route::resource('products', 'ProductController')->except(['show']);

            //orders routes
            Route::resource('orders', 'OrderController')->only(['index', 'show', 'destroy']);

            //client routes
            Route::resource('clients', 'ClientController')->except(['show']);
            Route::resource('clients.orders', 'Client\OrderController')->except(['show']);
        }); //end of dashboard routes
    }
);
