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

        $events = Event::where(function ($query) use ($user) {

                // Chapter-specific events
                $query->where(function ($q) use ($user) {
                    $q->where('event_type', 'chapter')
                      ->where('chapter_id', $user->chapter_id);
                })

                // OR General events (visible to all members)
                ->orWhere('event_type', 'general');

            })
            ->where('status', 'upcoming') // optional but recommended
            ->orderByDesc('event_date')
            ->get();

        return view('member.chapter.events', compact('events'));
    }
}
