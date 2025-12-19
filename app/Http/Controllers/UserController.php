<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* ================= MODELS ================= */
use App\Models\Story;
use App\Models\Article;
use App\Models\Consultation;
use App\Models\Partner;
use App\Models\Sponsor;
use App\Models\Event;
use App\Models\Advisory;
use App\Models\Meetup;
use App\Models\Insight;
use App\Models\Chapter;
use App\Models\User;

class UserController extends Controller
{
    /* =========================================================
     | HOME PAGE
     ========================================================= */

    public function index()
    {
        /* ================= EVENTS ================= */
        $latestEvents = Event::take(3)
            ->get();

        /* ================= ADVISORIES ================= */
        $advisories = Advisory::where('is_active', true)
            ->where('is_public', true)
            ->latest()
            ->take(4)
            ->get();

        /* ================= STORIES ================= */
        $stories = Story::published()
            ->take(6)
            ->get();

        /* ================= MEETUPS ================= */
        $meetups = Meetup::where('is_active', true)
            ->where('is_public', true)
            ->where('status', 'upcoming')
            ->whereDate('event_date', '>=', now())
            ->orderBy('event_date')
            ->take(3)
            ->get();

        /* ================= ACTIVE MEMBERS ================= */
        /* ================= ACTIVE TMNIANS ================= */
         $activeMembers = User::with('basicInfo')
            ->whereHas('adminData', function ($q) {
                $q->where('status', 'active');
            })
            ->latest()
            ->take(8)
            ->get();

        return view('user.index', compact(
            'latestEvents',
            'advisories',
            'stories',
            'meetups',
            'activeMembers'
        ));
    }
    /* =========================================================
     | STORIES
     ========================================================= */

    public function stories()
    {
        $stories = Story::published()
            ->latest('publish_date')
            ->paginate(5);

        $latestStories = Story::published()
            ->latest('publish_date')
            ->take(3)
            ->get();

        $previousStories = Story::published()
            ->where('publish_date', '<', now()->subDays(15))
            ->latest('publish_date')
            ->take(4)
            ->get();

        return view('user.stories', compact(
            'stories',
            'latestStories',
            'previousStories'
        ));
    }

    public function storyDetail(string $slug)
    {
        $story = Story::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $story->increment('views');

        return view('user.story', compact('story'));
    }

    /* =========================================================
     | ARTICLES
     ========================================================= */

    public function articles()
    {
        $articles = Article::published()
            ->latest('publish_date')
            ->paginate(5);

        $latestArticles = Article::published()
            ->latest('publish_date')
            ->take(3)
            ->get();

        $previousArticles = Article::published()
            ->where('publish_date', '<', now()->subDays(15))
            ->latest('publish_date')
            ->take(4)
            ->get();

        return view('user.articles', compact(
            'articles',
            'latestArticles',
            'previousArticles'
        ));
    }

    public function articleDetail(string $slug)
    {
        $article = Article::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $article->increment('views');

        $latestArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->latest('publish_date')
            ->take(3)
            ->get();

        $previousArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->when(
                $article->publish_date,
                fn($q) => $q->where('publish_date', '<', $article->publish_date),
                fn($q) => $q->where('id', '<', $article->id)
            )
            ->latest('publish_date')
            ->take(4)
            ->get();

        return view('user.article-detail', compact(
            'article',
            'latestArticles',
            'previousArticles'
        ));
    }

    /* =========================================================
     | EVENTS
     ========================================================= */

    public function events()
    {
        $events = Event::where('is_public', true)
            ->whereIn('status', ['upcoming', 'ongoing'])
            ->orderBy('event_date')
            ->paginate(12);

        return view('user.events', compact('events'));
    }

    public function eventShow(Event $event)
    {
        abort_if(!$event->is_public, 404);

        return view('user.detailed-event', compact('event'));
    }

    /* =========================================================
     | ADVISORY COMMITTEE
     ========================================================= */

    public function advisoryCommittee()
    {
        $advisories = Advisory::where('is_active', true)
            ->where('is_public', true)
            ->latest()
            ->get();

        return view('user.advisory-committee', compact('advisories'));
    }

    /* =========================================================
     | PROGRAMS & MEETUPS
     ========================================================= */

    public function programsMeetup()
    {
        $meetups = Meetup::where('is_active', true)
            ->where('is_public', true)
            ->where('status', 'upcoming')
            ->whereDate('event_date', '>=', now())
            ->orderBy('event_date')
            ->paginate(12);

        return view('user.programs-meetup', compact('meetups'));
    }

    /* =========================================================
     | INSIGHTS
     ========================================================= */

    public function insightIndex()
    {
        $insights = Insight::published()
            ->latest('publish_date')
            ->paginate(12);

        return view('user.insightIndex', compact('insights'));
    }

    /* =========================================================
     | CHAPTERS
     ========================================================= */

    public function chapters(Request $request)
    {
        $query = Chapter::where('is_active', true);

        if ($request->filled('state')) {
            $query->where('state', 'like', '%' . $request->state . '%');
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        $chapters = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('user.chapter', compact('chapters'));
    }

    /* =========================================================
     | BUILD BRAND
     ========================================================= */

    public function buildBrand()
    {
        $banner = Consultation::where('key', 'build_brand_banner')
            ->publicFeed()
            ->first();

        $intro = Consultation::where('key', 'build_brand_intro')
            ->publicFeed()
            ->first();

        $cta = Consultation::where('key', 'build_brand_cta')
            ->publicFeed()
            ->first();

        $testimonials = Consultation::where('key', 'testimonial')
            ->where('is_active', true)
            ->where('is_public', true)
            ->orderByDesc('is_featured')
            ->take(6)
            ->get();

        return view('user.build-brand', compact(
            'banner',
            'intro',
            'cta',
            'testimonials'
        ));
    }

    /* =========================================================
     | PARTNERS & SPONSORS
     ========================================================= */

    public function partners()
    {
        $partners = Partner::active()
            ->approved()
            ->orderByDesc('is_featured')
            ->latest()
            ->get();

        return view('user.partners', compact('partners'));
    }

    public function sponsors()
    {
        $sponsors = Sponsor::active()
            ->approved()
            ->orderByDesc('is_featured')
            ->latest()
            ->get();

        return view('user.sponsors', compact('sponsors'));
    }
}
