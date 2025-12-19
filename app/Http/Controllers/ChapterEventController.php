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
    
                // ✅ General events → visible to everyone (NO status restriction)
                $query->where('event_type', 'general')
    
                // ✅ Chapter events → only user's chapter + upcoming
                ->orWhere(function ($q) use ($user) {
                    $q->where('event_type', 'chapter')
                      ->where('chapter_id', $user->chapter_id)
                      ->where('status', 'upcoming');
                });
    
            })
            ->orderByDesc('event_date')
            ->get();
    
        return view('member.chapter.events', compact('events'));
    }
    
}
