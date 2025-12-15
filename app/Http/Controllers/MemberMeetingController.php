<?php

namespace App\Http\Controllers;

use App\Models\MemberMeeting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberMeetingController extends Controller
{
    // 🧑‍🤝‍🧑 1-to-1 meetings list
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
            'type' => '1to1',
        ]);
    }

    // 👥 Cluster meetings list
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
            'type' => 'cluster',
        ]);
    }

    // 📝 Create form
    public function create(Request $request)
    {
        $user = Auth::user();

        // ✅ Only show members from same chapter (excluding self)
        $members = User::where('chapter_id', $user->chapter_id)
            ->where('id', '!=', $user->id)
            ->orderBy('name')
            ->get();

        $type = $request->get('type', '1to1');

        return view('member.meetings.create', compact('members', 'type'));
    }

    // 💾 Store meeting
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'meeting_type' => 'required|in:1to1,cluster',
            'meeting_date' => 'required|date',
            'meeting_time' => 'nullable',
            'venue' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'agenda' => 'nullable|string',
            'participants' => 'required|array|min:1',
        ]);

        // ✅ Validate that selected participants are from the same chapter
        $invalidCount = User::whereIn('id', $validated['participants'])
            ->where('chapter_id', '!=', $user->chapter_id)
            ->count();

        if ($invalidCount > 0) {
            return back()->withErrors(['participants' => 'You can only add members from your chapter.'])->withInput();
        }

        $validated['created_by'] = $user->id;
        $validated['chapter_id'] = $user->chapter_id;

        $meeting = MemberMeeting::create($validated);
        $meeting->participants()->attach($validated['participants']);

        return redirect()->route(
            $validated['meeting_type'] === '1to1'
                ? 'member.meetings.onetoone'
                : 'member.meetings.cluster'
        )->with('success', 'Meeting added successfully.');
    }

    // 👁 Show meeting details
    public function show(MemberMeeting $meeting)
    {
        $meeting->load('participants', 'creator', 'chapter');
        return view('member.meetings.show', compact('meeting'));
    }
}
