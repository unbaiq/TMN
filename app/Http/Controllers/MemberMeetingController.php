<?php

namespace App\Http\Controllers;

use App\Models\MemberMeeting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberMeetingController extends Controller
{
    /* =========================================================
     | 1-TO-1 MEETINGS LIST
     ========================================================= */
    public function oneToOne()
    {
        $user = Auth::user();

        $meetings = MemberMeeting::with('participants')
            ->where('chapter_id', $user->chapter_id)
            ->where('meeting_type', '1to1')
            ->latest()
            ->paginate(10);

        return view('member.meetings.index', [
            'meetings' => $meetings,
            'type'     => '1to1',
        ]);
    }

    /* =========================================================
     | CLUSTER MEETINGS LIST
     ========================================================= */
    public function cluster()
    {
        $user = Auth::user();

        $meetings = MemberMeeting::with('participants')
            ->where('chapter_id', $user->chapter_id)
            ->where('meeting_type', 'cluster')
            ->latest()
            ->paginate(10);

        return view('member.meetings.index', [
            'meetings' => $meetings,
            'type'     => 'cluster',
        ]);
    }

    /* =========================================================
     | CREATE MEETING FORM
     | IMPORTANT: TYPE COMES FROM URL {type}
     ========================================================= */
    public function create(string $type)
    {
        // 🔒 Allow only valid types
        if (!in_array($type, ['1to1', 'cluster'])) {
            abort(404);
        }

        $user = Auth::user();

        // Members from same chapter (excluding self)
        $members = User::where('chapter_id', $user->chapter_id)
            ->where('id', '!=', $user->id)
            ->orderBy('name')
            ->get();

        return view('member.meetings.create', [
            'type'    => $type,
            'members' => $members,
        ]);
    }

    /* =========================================================
     | STORE MEETING
     ========================================================= */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'meeting_type' => 'required|in:1to1,cluster',
            'meeting_date' => 'required|date',
            'meeting_time' => 'nullable',
            'venue'        => 'nullable|string|max:255',
            'title'        => 'nullable|string|max:255',
            'agenda'       => 'nullable|string',
            'participants' => 'required|array|min:1',
        ]);

        // 🔒 Ensure participants belong to same chapter
        $invalid = User::whereIn('id', $validated['participants'])
            ->where('chapter_id', '!=', $user->chapter_id)
            ->exists();

        if ($invalid) {
            return back()
                ->withErrors(['participants' => 'You can only select members from your chapter.'])
                ->withInput();
        }

        // 🔒 1-to-1 must have exactly ONE participant
        if ($validated['meeting_type'] === '1to1' && count($validated['participants']) !== 1) {
            return back()
                ->withErrors(['participants' => '1-to-1 meeting must have exactly one participant.'])
                ->withInput();
        }

        // ✅ Create meeting (DO NOT pass participants here)
        $meeting = MemberMeeting::create([
            'created_by'   => $user->id,
            'chapter_id'   => $user->chapter_id,
            'meeting_type' => $validated['meeting_type'],
            'meeting_date' => $validated['meeting_date'],
            'meeting_time' => $validated['meeting_time'] ?? null,
            'venue'        => $validated['venue'] ?? null,
            'title'        => $validated['title'] ?? null,
            'agenda'       => $validated['agenda'] ?? null,
        ]);

        // ✅ Attach participants (pivot table)
        $meeting->participants()->sync($validated['participants']);

        return redirect()->route(
            $validated['meeting_type'] === '1to1'
                ? 'member.meetings.onetoone'
                : 'member.meetings.cluster'
        )->with('success', 'Meeting added successfully.');
    }

    /* =========================================================
     | SHOW MEETING DETAILS
     ========================================================= */
    public function show(MemberMeeting $meeting)
    {
        // 🔒 Only same chapter users can view
        if ($meeting->chapter_id !== Auth::user()->chapter_id) {
            abort(403);
        }

        $meeting->load('participants', 'creator', 'chapter');

        return view('member.meetings.show', compact('meeting'));
    }
}
