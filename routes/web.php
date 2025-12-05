<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| HOME = Member Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('member.dashboard.index');
})->name('home');


/*
|--------------------------------------------------------------------------
| MEMBER ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('member')->name('member.')->group(function () {

    // Dashboard + Settings
    Route::get('/dashboard', fn() => view('member.dashboard.index'))->name('dashboard');
    Route::get('/settings', fn() => view('member.settings'))->name('settings');


    /*
    |--------------------------------------------------------------------------
    | BUSINESS
    |--------------------------------------------------------------------------
    */
    Route::prefix('business')->name('business.')->group(function () {
        Route::get('/list', fn() => view('member.business.businesses'))->name('list');
        Route::get('/offer', fn() => view('member.business.offer'))->name('offer');
        Route::get('/take', fn() => view('member.business.take'))->name('take');
    });


    /*
    |--------------------------------------------------------------------------
    | CHAPTER
    |--------------------------------------------------------------------------
    */
    Route::prefix('chapter')->name('chapter.')->group(function () {
        Route::get('/', fn() => view('member.chapter.index'))->name('index');
        Route::get('/eventattended', fn() => view('member.chapter.eventattended'))->name('eventattended');
    });


    /*
    |--------------------------------------------------------------------------
    | AWARDS
    |--------------------------------------------------------------------------
    |
    | Correct canonical URL: /member/awards
    | Name: member.awards.index
    |
    */
    Route::prefix('awards')->name('awards.')->group(function () {
        Route::get('/', fn() => view('member.awards.index'))->name('index');
    });


    /*
    |--------------------------------------------------------------------------
    | CSR
    |--------------------------------------------------------------------------
    */
    Route::prefix('csr')->name('csr.')->group(function () {
        Route::get('/', fn() => view('member.csr.index'))->name('index');
    });

});



/*
|--------------------------------------------------------------------------
| LEGACY HTML SUPPORT (old links redirect)
|--------------------------------------------------------------------------
*/

Route::get('/chapterattended.html', fn() => redirect()->route('member.chapter.eventattended'));
Route::get('/awards.html', fn() => redirect()->route('member.awards.index'));
Route::get('/businesses.html', fn() => redirect()->route('member.business.list'));
Route::get('/dashboard.html', fn() => redirect()->route('member.dashboard'));
Route::get('/csr.html', fn() => redirect()->route('member.csr.index'));
Route::get('/settings.html', fn() => redirect()->route('member.settings'));