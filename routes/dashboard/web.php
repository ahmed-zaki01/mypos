<?php

use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->name('dashboard.')->group(function () {

    Route::get('/check', function () {
        return view('dashboard.index');
    });
});
