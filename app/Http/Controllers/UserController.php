<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Article;
use App\Models\Consultation;
use App\Models\Partner;
use App\Models\Sponsor;



class UserController extends Controller
{
    /* ================= STORIES ================= */

    public function stories()
    {
        $stories = Story::published()
            ->orderBy('publish_date', 'desc')
            ->paginate(5);

        $latestStories = Story::published()
            ->orderBy('publish_date', 'desc')
            ->take(3)
            ->get();

        $previousStories = Story::published()
            ->where('publish_date', '<', now()->subDays(15))
            ->orderBy('publish_date', 'desc')
            ->take(4)
            ->get();

        return view('user.stories', compact(
            'stories',
            'latestStories',
            'previousStories'
        ));
    }

    public function storyDetail($slug)
    {
        $story = Story::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $story->increment('views');

        return view('user.story', compact('story'));
    }

    /* ================= ARTICLES ================= */
   /**
     * ============================
     * ARTICLES LISTING PAGE
     * ============================
     */
    public function articles()
    {
        // Main articles list
        $articles = Article::published()
            ->orderBy('publish_date', 'desc')
            ->paginate(5);

        // Latest articles (sidebar)
        $latestArticles = Article::published()
            ->orderBy('publish_date', 'desc')
            ->limit(3)
            ->get();

        // Previous articles (older than 15 days)
        $previousArticles = Article::published()
            ->whereNotNull('publish_date')
            ->where('publish_date', '<', now()->subDays(15))
            ->orderBy('publish_date', 'desc')
            ->limit(4)
            ->get();

        return view('user.articles', compact(
            'articles',
            'latestArticles',
            'previousArticles'
        ));
    }

    /**
     * ============================
     * SINGLE ARTICLE DETAIL PAGE
     * ============================
     */
public function articleDetail(string $slug)
{
    // 🔹 Current article
    $article = Article::published()
        ->where('slug', $slug)
        ->firstOrFail();

    // 🔹 Increment views
    $article->increment('views');

    // 🔹 Latest articles (sidebar)
    $latestArticles = Article::published()
        ->where('id', '!=', $article->id)
        ->orderByDesc('publish_date')
        ->limit(3)
        ->get();

    /*
    |--------------------------------------------------------------------------
    | PREVIOUS ARTICLES – SAFE LOGIC
    |--------------------------------------------------------------------------
    | 1. If publish_date exists → get older articles
    | 2. If publish_date is NULL → fallback to ID-based logic
    */

    $previousArticles = Article::published()
        ->where('id', '!=', $article->id)
        ->when(
            $article->publish_date,
            fn ($q) => $q->where('publish_date', '<', $article->publish_date),
            fn ($q) => $q->where('id', '<', $article->id) // fallback
        )
        ->orderByDesc('publish_date')
        ->limit(4)
        ->get();

    return view('user.article-detail', compact(
        'article',
        'latestArticles',
        'previousArticles'
    ));
}
  /**
     * Build Your Brand page
     */
    public function buildBrand()
    {
        // Featured / highlighted consultations
        $featuredConsultations = Consultation::active()
            ->featured()
            ->orderBy('consultation_date', 'asc')
            ->take(6)
            ->get();

        // Testimonials-style consultations (for slider)
        $testimonials = Consultation::active()
            ->whereNotNull('description')
            ->orderByDesc('views')
            ->take(10)
            ->get();

        return view('user.buildBrand', compact(
            'featuredConsultations',
            'testimonials'
        ));
    }
    /**
     * Partners page
     */
    public function partners()
{
    $partners = Partner::active()
        ->approved()
        ->orderBy('is_featured', 'desc')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('user.partners', compact('partners'));
}
/**
     * Display Partners / Sponsors page
     */
    public function index()
    {
        $partners = Sponsor::query()
            ->approved()              // status = approved
            ->active()                // is_active = true
            ->orderByDesc('is_featured')
            ->orderBy('company_name')
            ->get();

        return view('user.partners', compact('partners'));
    }
}
