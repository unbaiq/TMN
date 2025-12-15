<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class ChapterEventController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch all events from user's chapter
        $events = Event::where('chapter_id', $user->chapter_id)
            ->orderByDesc('event_date')
            ->get();

        return view('member.chapter.events', compact('events'));
    }
}
