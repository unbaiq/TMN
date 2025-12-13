<?php

use Illuminate\Support\Facades\Route;
Route::get('/journey', function () {
    return view('journey');
})->name('journey');

/*
|--------------------------------------------------------------------------
| LOGIN PAGE
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', function () {
    return view('auth.login');
})->name('admin.login');

/* ✅ LOGIN SUBMIT (ADD THIS HERE) */
Route::post('/admin/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])
    ->name('admin.login.submit');

/* ✅ LOGOUT ROUTE (ADD THIS HERE) */
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])
    ->name('logout');

/* Redirect root to login */
Route::get('/', function () {
    return redirect()->route('admin.login');
});



/*
|--------------------------------------------------------------------------
| HOME (Legacy)
|--------------------------------------------------------------------------
*/
Route::get('/home', function () {
    return view('member.dashboard.index');
})->name('home');



/*
|--------------------------------------------------------------------------
| MEMBER ROUTES (Protected: auth + role:member)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:member'])
    ->prefix('member')
    ->name('member.')
    ->group(function () {

    Route::get('/dashboard', fn() => view('member.dashboard.index'))->name('dashboard');
    Route::get('/settings', fn() => view('member.settings'))->name('settings');

    Route::get('/referrals', fn() => view('member.referrals'))->name('referrals');

    Route::prefix('business')->name('business.')->group(function () {
        Route::get('/list', fn() => view('member.business.businesses'))->name('list');
        Route::get('/offer', fn() => view('member.business.offer'))->name('offer');
        Route::get('/take', fn() => view('member.business.take'))->name('take');
        Route::get('/investors', fn() => view('member.business.investors'))->name('investors');
    });

    Route::prefix('chapter')->name('chapter.')->group(function () {
        Route::get('/events', fn() => view('member.chapter.events'))->name('events');
        Route::get('/eventattended', fn() => view('member.chapter.eventattended'))->name('eventattended');
    });

    Route::prefix('awards')->name('awards.')->group(function () {
        Route::get('/', fn() => view('member.awards.index'))->name('index');
        Route::get('/recognitions', fn() => view('member.awards.recognitions'))->name('recognitions');
    });

    Route::prefix('csr')->name('csr.')->group(function () {
        Route::get('/', fn() => view('member.csr.index'))->name('index');
    });

    Route::prefix('meetings')->name('meetings.')->group(function () {
        Route::get('/1-1meetup', fn() => view('member.meetings.1-1meetup'))->name('1-1meetup');
        Route::get('/clustermeetings', fn() => view('member.meetings.clustermeetings'))->name('clustermeetings');
    });

    Route::get('/branding', fn() => view('member.branding'))->name('branding');
});


/*
|--------------------------------------------------------------------------
| LEGACY HTML SUPPORT (Keep same)
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
| ADMIN ROUTES (Protected: auth + role:admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', fn() => view('admin.dashboard.index'))->name('dashboard');
    Route::get('/events', fn() => view('admin.dashboard.events'))->name('dashboard.events');

    Route::get('/awards', fn() => view('admin.awards.index'))->name('awards.index');

    Route::get('/chapter', fn() => view('admin.chapter.index'))->name('chapter.index');

    Route::prefix('member')->name('member.')->group(function () {
        Route::get('/index', fn() => view('admin.member.index'))->name('index');
        Route::get('/memberlist', fn() => view('admin.member.memberlist'))->name('memberlist');
        Route::get('/assigned', fn() => view('admin.member.assigned'))->name('assigned');
        Route::get('/enquiry', fn() => view('admin.member.enquiry'))->name('enquiry');
    });

    Route::get('/events/attended', fn() => view('admin.events.attended'))->name('events.attended');

    Route::get('/settings', fn() => view('admin.settings.index'))->name('settings.index');
});
