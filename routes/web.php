<?php

use Illuminate\Support\Facades\Route;

/* HOME → Member Dashboard */
Route::get('/', function () {
    return view('member.dashboard.index');
})->name('home');

/* MEMBER ROUTES */
Route::prefix('member')->name('member.')->group(function () {

    /* Dashboard */
    Route::get('/dashboard', function () {
        return view('member.dashboard.index');
    })->name('dashboard');

    /* Settings */
    Route::get('/settings', function () {
        return view('member.dashboard.settings');
    })->name('settings');

    /* BUSINESS MODULE */
    Route::prefix('business')->name('business.')->group(function () {
        Route::get('/list', fn() => view('member.business.businesses'))->name('list');
        Route::get('/offer', fn() => view('member.business.offer'))->name('offer');
        Route::get('/take', fn() => view('member.business.take'))->name('take');
    });

    /* CHAPTER MODULE */
    Route::prefix('chapter')->name('chapter.')->group(function () {

        // ⭐ Your Chapter Events Page (THE VIEW YOU SENT)
        Route::get('/events', function () {
            return view('member.chapter.index');  // your HTML page
        })->name('events');

        Route::get('/eventattended', fn() => view('member.chapter.eventattended'))
            ->name('eventattended');
    });

    /* AWARDS MODULE */
    Route::prefix('awards')->name('awards.')->group(function () {
        Route::get('/', fn() => view('member.awards.index'))->name('index');
    });

    /* CSR MODULE */
    Route::prefix('csr')->name('csr.')->group(function () {
        Route::get('/', fn() => view('member.csr.index'))->name('index');
    });

});
