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

     // ⭐ REFERRALS PAGE
    Route::get('/referrals', fn() => view('member.referrals'))->name('referrals');

    /*
    |--------------------------------------------------------------------------
    | BUSINESS
    |--------------------------------------------------------------------------
    */
    Route::prefix('business')->name('business.')->group(function () {
        Route::get('/list', fn() => view('member.business.businesses'))->name('list');
        Route::get('/offer', fn() => view('member.business.offer'))->name('offer');
        Route::get('/take', fn() => view('member.business.take'))->name('take');
        Route::get('/investors', fn() => view('member.business.investors'))->name('investors');
    });


    /*
    |--------------------------------------------------------------------------
    | CHAPTER
    |--------------------------------------------------------------------------
    */
    Route::prefix('chapter')->name('chapter.')->group(function () {

        // ⭐ Missing route added here
        Route::get('/events', fn() => view('member.chapter.events'))->name('events');
        Route::get('/eventattended', fn() => view('member.chapter.eventattended'))->name('eventattended');
    });


    /*
    |--------------------------------------------------------------------------
    | AWARDS
    |--------------------------------------------------------------------------
    */
    Route::prefix('awards')->name('awards.')->group(function () {
        Route::get('/', fn() => view('member.awards.index'))->name('index');
        Route::get('/recognitions', fn() => view('member.awards.recognitions'))->name('recognitions');
    });


    /*
    |--------------------------------------------------------------------------
    | CSR
    |--------------------------------------------------------------------------
    */
    Route::prefix('csr')->name('csr.')->group(function () {
        Route::get('/', fn() => view('member.csr.index'))->name('index');
    });

    /*|--------------------------------------------------------------------------
    | MEETINGS
    |--------------------------------------------------------------------------*/
    Route::prefix('meetings')->name('meetings.')->group(function () {
        Route::get('/1-1meetup', fn() => view('member.meetings.1-1meetup'))->name('1-1meetup');
        Route::get('/clustermeetings', fn() => view('member.meetings.clustermeetings'))->name('clustermeetings');
    });

    /*|--------------------------------------------------------------------------
    | BRANDING
    |--------------------------------------------------------------------------*/
    Route::get('/branding', fn() => view('member.branding'))->name('branding');

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



/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard.index');
    })->name('dashboard');
    Route::get('/events', function () {
        return view('admin.dashboard.events');
    })->name('dashboard.events');

    // Awards
    Route::get('/awards', function () {
        return view('admin.awards.index');
    })->name('awards.index');

    // Chapter Management
    Route::get('/chapter', function () {
        return view('admin.chapter.index');
    })->name('chapter.index');

    // Member Module
    Route::prefix('member')->name('member.')->group(function () {

        Route::get('/index', function () {
            return view('admin.member.index');
        })->name('index');
        Route::get('/memberlist', function () {
            return view('admin.member.memberlist');
        })->name('memberlist');

        Route::get('/list', function () {
            return view('admin.member.memberlist');
        })->name('list');

        Route::get('/enquiry', function () {
            return view('admin.member.enquiry');
        })->name('enquiry');

    });

    
    /*
    |--------------------------------------------------------------------------
    | ADMIN EVENT ATTENDED PAGE (UI ONLY)
    |--------------------------------------------------------------------------
    */
    Route::get('/events/attended', function () {
        return view('admin.events.attended');
    })->name('events.attended');


    // Settings
    Route::get('/settings', function () {
        return view('admin.settings.index');
    })->name('settings.index');

});
