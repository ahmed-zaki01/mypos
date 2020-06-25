<?php

use Illuminate\Support\Facades\Route;


// Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
// });

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        //'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function () {

            Route::get('/index', 'DashboardController@index')->name('index');
            Route::get('/logout', 'DashboardController@logout')->name('logout');


            //user routes
            Route::resource('users', 'UserController')->except(['show']);
        }); //end of dashboard routes
    }
);
