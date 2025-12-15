<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventAttendanceController;
use App\Http\Controllers\ChapterEventController;
use App\Http\Controllers\MemberAttendanceController;
use App\Http\Controllers\BusinessGiveTakeController;
use App\Http\Controllers\MemberMeetingController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\MemberSettingsController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MeetupController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\AdvisoryController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\SponsorController;


/*
|--------------------------------------------------------------------------
| LOGIN PAGE
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('auth.login');
})->name('admin.login');

/* ✅ LOGIN SUBMIT (ADD THIS HERE) */
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])
    ->name('admin.login.submit');

/* ✅ LOGOUT ROUTE (ADD THIS HERE) */
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])
    ->name('logout');

/* Redirect root to login */
Route::get('/', function () {
    return redirect()->route('admin.login');
});
Route::get('/journey', function () {
    return view('journey');
})->name('journey');
// SUPER ADMIN SECTION

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});
// Public form submission
Route::prefix('admin')->group(function () {
    Route::get('/enquiries', [EnquiryController::class, 'index'])->name('admin.enquiries.index');
    Route::post('/enquiries', [EnquiryController::class, 'store'])->name('admin.enquiries.store');
    Route::get('/enquiries/{enquiry}', [EnquiryController::class, 'show'])->name('admin.enquiries.show');
    Route::put('/enquiries/{enquiry}', [EnquiryController::class, 'update'])->name('admin.enquiries.update');
    Route::delete('/enquiries/{enquiry}', [EnquiryController::class, 'destroy'])->name('admin.enquiries.destroy');
    // ✅ NEW: send membership link
    Route::post('/enquiries/{enquiry}/send-link', [MembershipController::class, 'sendMembershipLink'])->name('admin.enquiries.sendLink');
});

// Frontend Journey form
Route::post('/enquiry/submit', [EnquiryController::class, 'storeJourney'])->name('enquiry.submit');

// ✅ Show membership registration form (GET)
Route::get('/join/{token}', [MembershipController::class, 'showJoinForm'])->name('member.join');
Route::post('/join/{token}', [MembershipController::class, 'submitJoinForm'])->name('member.join.submit');
// membership list
Route::prefix('admin')->group(function () {
    Route::get('/members', [MembershipController::class, 'index'])->name('admin.members.index');
    Route::get('/members/{id}', [MembershipController::class, 'show'])->name('admin.members.show');
    Route::post('/members/{id}/activate', [MembershipController::class, 'activateMember'])
        ->name('admin.members.activate');
});


// Chapter 
Route::prefix('admin')->as('admin.')->middleware(['auth'])->group(function () {
    Route::resource('chapters', ChapterController::class);
    // 👇 Add routes for member assignment
    Route::get('chapters/{chapter}/members', [ChapterController::class, 'members'])->name('chapters.members');
    Route::post('chapters/{chapter}/assign', [ChapterController::class, 'assignMembers'])->name('chapters.assign');
});

// Admin Event Attendance Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/events/attended', [EventAttendanceController::class, 'index'])
        ->name('events.attended'); // <-- this is the route your sidebar uses

    Route::get('/events/{event}/attendance', [EventAttendanceController::class, 'manage'])
        ->name('events.attendance');

    Route::post('/events/{event}/attendance', [EventAttendanceController::class, 'update'])
        ->name('events.attendance.update');
});


// Events
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('events', EventController::class);
    Route::resource('insights', InsightController::class);
    Route::resource('stories', StoryController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('meetups', MeetupController::class);
    Route::resource('consultations', ConsultationController::class);
    Route::resource('advisories', AdvisoryController::class);
    Route::resource('partners', PartnerController::class);
    Route::resource('sponsors', SponsorController::class);
    
});










/*
|--------------------------------------------------------------------------
| MEMBER ROUTES (Protected: auth + role:member)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:member'])
    ->prefix('member')
    ->name('member.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [MemberDashboardController::class, 'index'])
            ->name('dashboard');

            // ✅ Add settings route
      // ⚙️ Settings
      Route::get('/settings', [MemberSettingsController::class, 'index'])->name('settings');
      Route::post('/settings/update', [MemberSettingsController::class, 'update'])->name('settings.update');
        // ✅ Member dashboard & other pages already here...
    
        Route::prefix('chapter')->name('chapter.')->group(function () {
            // 👇 Add this route for chapter events
            Route::get('/events', [ChapterEventController::class, 'index'])->name('events');
            // ✅ Chapter attended events
            Route::get('/attended', [MemberAttendanceController::class, 'index'])->name('attended');

        });
        // ✅ MEMBER EVENT INVITATIONS (BNI-style guest invites)
        Route::prefix('invitations')->name('invitations.')->group(function () {
            Route::get('/', [\App\Http\Controllers\EventInvitationController::class, 'index'])->name('index');
            Route::post('/', [\App\Http\Controllers\EventInvitationController::class, 'store'])->name('store');
            Route::post('/{id}/status', [\App\Http\Controllers\EventInvitationController::class, 'updateStatus'])->name('updateStatus');
        });

        // ✅ MEMBER GIVE & TAKE OF BUSINESS (BNI-style)
        Route::prefix('business')->name('business.')->group(function () {
            Route::get('/', [BusinessGiveTakeController::class, 'index'])->name('index'); // List (Given/Taken)
            Route::get('/create', [BusinessGiveTakeController::class, 'create'])->name('create'); // Add new
            Route::post('/', [BusinessGiveTakeController::class, 'store'])->name('store'); // Save
            Route::get('/{businessGiveTake}', [BusinessGiveTakeController::class, 'show'])->name('show'); // View details
            Route::get('/{businessGiveTake}/edit', [BusinessGiveTakeController::class, 'edit'])->name('edit'); // Edit
            Route::put('/{businessGiveTake}', [BusinessGiveTakeController::class, 'update'])->name('update'); // Update
            Route::delete('/{businessGiveTake}', [BusinessGiveTakeController::class, 'destroy'])->name('destroy'); // Delete
    
            // Custom actions for accept/reject (like in your JS UI)
            Route::post('/{businessGiveTake}/accept', [BusinessGiveTakeController::class, 'accept'])->name('accept');
            Route::post('/{businessGiveTake}/reject', [BusinessGiveTakeController::class, 'reject'])->name('reject');
        });

        /*
        |--------------------------------------------------------------------------
        | MEMBER MEETINGS (1-to-1 & Cluster)
        |--------------------------------------------------------------------------
        */
        Route::prefix('meetings')->name('meetings.')->group(function () {

            // 🧑‍🤝‍🧑 1-to-1 Meetups
            Route::get('/onetoone', [MemberMeetingController::class, 'oneToOne'])->name('onetoone');

            // 👥 Cluster Meetings
            Route::get('/cluster', [MemberMeetingController::class, 'cluster'])->name('cluster');

            // ➕ Create New Meeting
            Route::get('/create', [MemberMeetingController::class, 'create'])->name('create');
            Route::post('/', [MemberMeetingController::class, 'store'])->name('store');

            // 👁 View Meeting Details
            Route::get('/{meeting}', [MemberMeetingController::class, 'show'])->name('show');
        });

        /*
                |--------------------------------------------------------------------------
                | MEMBER RECOGNITIONS (BNI-style appreciation system)
                |--------------------------------------------------------------------------
                */
        Route::prefix('recognitions')->name('recognitions.')->group(function () {
            Route::get('/', [\App\Http\Controllers\MemberRecognitionController::class, 'index'])->name('index');      // List all recognitions
            Route::get('/create', [\App\Http\Controllers\MemberRecognitionController::class, 'create'])->name('create'); // Add new recognition
            Route::post('/', [\App\Http\Controllers\MemberRecognitionController::class, 'store'])->name('store');       // Save new recognition
            Route::get('/{recognition}', [\App\Http\Controllers\MemberRecognitionController::class, 'show'])->name('show'); // View recognition details
            Route::get('/{recognition}/edit', [\App\Http\Controllers\MemberRecognitionController::class, 'edit'])->name('edit'); // Edit recognition
            Route::put('/{recognition}', [\App\Http\Controllers\MemberRecognitionController::class, 'update'])->name('update'); // Update recognition
            Route::delete('/{recognition}', [\App\Http\Controllers\MemberRecognitionController::class, 'destroy'])->name('destroy'); // Delete recognition
        });

        /*
|--------------------------------------------------------------------------
| MEMBER AWARDS (BNI-Style)
|--------------------------------------------------------------------------
*/
        Route::prefix('awards')->name('awards.')->group(function () {
            Route::get('/', [\App\Http\Controllers\MemberAwardController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\MemberAwardController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\MemberAwardController::class, 'store'])->name('store');
            Route::get('/{award}', [\App\Http\Controllers\MemberAwardController::class, 'show'])->name('show');
            Route::get('/{award}/edit', [\App\Http\Controllers\MemberAwardController::class, 'edit'])->name('edit');
            Route::put('/{award}', [\App\Http\Controllers\MemberAwardController::class, 'update'])->name('update');
            Route::delete('/{award}', [\App\Http\Controllers\MemberAwardController::class, 'destroy'])->name('destroy');
        });

        /*
       |--------------------------------------------------------------------------
       | MEMBER INVESTORS (BNI-Style)
       |--------------------------------------------------------------------------
       */
        Route::prefix('investors')->name('investors.')->group(function () {
            Route::get('/', [\App\Http\Controllers\MemberInvestorController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\MemberInvestorController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\MemberInvestorController::class, 'store'])->name('store');
            Route::get('/{investor}', [\App\Http\Controllers\MemberInvestorController::class, 'show'])->name('show');
            Route::get('/{investor}/edit', [\App\Http\Controllers\MemberInvestorController::class, 'edit'])->name('edit');
            Route::put('/{investor}', [\App\Http\Controllers\MemberInvestorController::class, 'update'])->name('update');
            Route::delete('/{investor}', [\App\Http\Controllers\MemberInvestorController::class, 'destroy'])->name('destroy');
        });
        /*
        |--------------------------------------------------------------------------
        | MEMBER CSR (Corporate Social Responsibility)
        |--------------------------------------------------------------------------
        */
        Route::prefix('csrs')->name('csrs.')->group(function () {
            Route::get('/', [\App\Http\Controllers\MemberCsrController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\MemberCsrController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\MemberCsrController::class, 'store'])->name('store');
            Route::get('/{csr}', [\App\Http\Controllers\MemberCsrController::class, 'show'])->name('show');
            Route::get('/{csr}/edit', [\App\Http\Controllers\MemberCsrController::class, 'edit'])->name('edit');
            Route::put('/{csr}', [\App\Http\Controllers\MemberCsrController::class, 'update'])->name('update');
            Route::delete('/{csr}', [\App\Http\Controllers\MemberCsrController::class, 'destroy'])->name('destroy');
        });

        /*
                |--------------------------------------------------------------------------
                | MEMBER BRANDINGS (BNI-Style Branding / Media Activities)
                |--------------------------------------------------------------------------
                */
        /*
     |--------------------------------------------------------------------------
     | MEMBER BRANDINGS (BNI-Style Branding / Media Activities)
     |--------------------------------------------------------------------------
     */
        Route::prefix('brandings')->name('brandings.')->group(function () {

            // 📋 List all branding & media entries
            Route::get('/', [\App\Http\Controllers\MemberBrandingController::class, 'index'])
                ->name('index');

            // ➕ Create new branding/media record
            Route::get('/create', [\App\Http\Controllers\MemberBrandingController::class, 'create'])
                ->name('create');
            Route::post('/', [\App\Http\Controllers\MemberBrandingController::class, 'store'])
                ->name('store');

            // 👁 View and manage specific record
            Route::get('/{branding}', [\App\Http\Controllers\MemberBrandingController::class, 'show'])
                ->name('show');
            Route::get('/{branding}/edit', [\App\Http\Controllers\MemberBrandingController::class, 'edit'])
                ->name('edit');
            Route::put('/{branding}', [\App\Http\Controllers\MemberBrandingController::class, 'update'])
                ->name('update');
            Route::delete('/{branding}', [\App\Http\Controllers\MemberBrandingController::class, 'destroy'])
                ->name('destroy');

            // 🧾 Optional admin/moderator actions
            Route::post('/{branding}/approve', [\App\Http\Controllers\MemberBrandingController::class, 'approve'])
                ->name('approve');
            Route::post('/{branding}/reject', [\App\Http\Controllers\MemberBrandingController::class, 'reject'])
                ->name('reject');
        });
    });




// User 
Route::view('/about', 'user.about');
Route::view('/advisory-committee', 'user.advisory-committee');
Route::view('/article-one', 'user.article_one');
Route::view('/article-two', 'user.article_two');
Route::view('/article-three', 'user.article_three');
Route::view('/articles', 'user.articles');
Route::view('/articles-new', 'user.articles-new');
Route::view('/build-brand', 'user.buildBrand');
Route::view('/chapter', 'user.chapter');
Route::view('/contact', 'user.contact');
Route::view('/detail-locads', 'user.detail-locads');
Route::view('/detail-stories', 'user.detail-stories');
Route::view('/detail-traveltalk', 'user.detail-traveltalk');
Route::view('/detailed-event', 'user.detailed-event');
Route::view('/details-article', 'user.details-article');

// Blade Pages
Route::view('/easy-to-join', 'user.easy-to-joinsection');
Route::view('/events', 'user.events');
Route::view('/index', 'user.index');
Route::view('/index-updated', 'user.index-updated');
Route::view('/indexold', 'user.indexold');
Route::view('/indexold-without-loader', 'user.indexold-without-loader');

// Insights
Route::view('/insight', 'user.insight');
Route::view('/insight2', 'user.insight2');
Route::view('/insight3', 'user.insight3');
Route::view('/insightindex', 'user.insightIndex');

// Other Pages
Route::view('/journey', 'user.journey');
Route::view('/partners', 'user.partners');
Route::view('/programs-meetup', 'user.programs-meetup');
Route::view('/services-portion', 'user.services.portion');
Route::view('/sponsors', 'user.sponsors');
Route::view('/stories', 'user.stories');
Route::view('/stories-new', 'user.stories-new');
Route::view('/story', 'user.story');

// Optional: Default homepage
Route::get('/', function () {
    return view('user.index');
});