<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\EventAttendance;
use Illuminate\Http\Request;

class EventAttendanceController extends Controller
{
    /**
     * Display ERP-style dashboard with all events and stats.
     */
    public function index()
    {
        // ✅ Load all events with attendances
        $events = Event::with('attendances')->latest()->get();

        // ✅ Precompute all stats using fresh queries, not the $events collection
        $stats = [
            'total'           => Event::count(),
            'this_month'      => Event::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count(),
            'with_attendance' => Event::has('attendances')->count(),
            'pending'         => Event::count() - Event::has('attendances')->count(),
        ];

        return view('admin.events.attended', compact('events', 'stats'));
    }

    /**
     * Show the attendance management screen for one event.
     */
    public function manage(Event $event)
    {
        $members = User::orderBy('name')->get();

        // ✅ Collect attendance status in associative array
        $attendances = EventAttendance::where('event_id', $event->id)
            ->pluck('status', 'member_id')
            ->toArray();

        return view('admin.events.attendance', compact('event', 'members', 'attendances'));
    }

    /**
     * Update or create attendance records.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'attendance' => 'required|array',
        ]);

        foreach ($validated['attendance'] as $member_id => $status) {
            EventAttendance::updateOrCreate(
                ['event_id' => $event->id, 'member_id' => $member_id],
                ['status' => $status]
            );
        }

        return redirect()->back()->with('success', 'Attendance updated successfully!');
    }
}
