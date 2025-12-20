<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\MembershipInviteMail;
use App\Mail\EventInvitationMail; // ✅ Import the Mailable

class EventInvitationController extends Controller
{
    public function index()
    {
        $invitations = EventInvitation::with(['event'])
            ->where('inviter_id', Auth::id())
            ->latest()
            ->get();

        $events = Event::latest()->get();

        return view('member.event_invitations.index', compact('invitations', 'events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'nullable|email|max:255',
            'guest_phone' => 'nullable|string|max:20',
            'profession' => 'nullable|string|max:255',
        ]);

        $validated['inviter_id'] = Auth::id();

        $invitation = EventInvitation::create($validated);

        // ✅ Send email if guest email exists
        if (!empty($invitation->guest_email)) {
            try {
                Mail::to($invitation->guest_email)->send(new EventInvitationMail($invitation));
            } catch (\Exception $e) {
                // Optional: Log the error for debugging
                \Log::error('Invitation email failed: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Invitation sent successfully and email notification delivered!');
    }

    public function updateStatus(Request $request, $id)
    {
        $invitation = EventInvitation::findOrFail($id);
        $invitation->update(['status' => $request->status]);

        return back()->with('success', 'Invitation status updated!');
    }

 
}
