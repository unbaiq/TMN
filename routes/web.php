<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Member Only)
|--------------------------------------------------------------------------
|
| Homepage → Member Dashboard
|
*/

// HOME → Member Dashboard
Route::get('/', function () {
    return view('member.dashboard.index');
})->name('home');


// ================================
// MEMBER ROUTES
// ================================
Route::prefix('member')->name('member.')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('member.dashboard.index');
    })->name('dashboard');

    // Settings
    Route::get('/settings', function () {
        return view('member.dashboard.settings');
    })->name('settings');

    // ----------------------------
    // BUSINESS MODULE
    // ----------------------------
    Route::prefix('business')->name('business.')->group(function () {

        Route::get('/list', function () {
            return view('member.business.businesses');
        })->name('list');

        Route::get('/offer', function () {
            return view('member.business.offer');
        })->name('offer');

        Route::get('/take', function () {
            return view('member.business.take');
        })->name('take');
    });

    // ----------------------------
    // CHAPTER MODULE
    // ----------------------------
    Route::prefix('chapter')->name('chapter.')->group(function () {

        Route::get('/', function () {
            return view('member.chapter.index');
        })->name('index');

        Route::get('/eventattended', function () {
            return view('member.chapter.eventattended');
        })->name('eventattended');
    });
     Route::prefix('awards')->name('awards.')->group(function () {

        Route::get('/awards', function () {
            return view('member.awards.index');
        })->name('awards');
    });
     Route::prefix('csr')->name('csr.')->group(function () {

        Route::get('/csr', function () {
            return view('member.csr.index');
        })->name('csr');
    });

});
