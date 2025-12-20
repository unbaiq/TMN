<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EventInvitation;
use App\Models\Event;
use App\Models\User;
use App\Mail\MembershipInviteMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminInviteController extends Controller
{
    /**
     * 📌 INDEX – Dashboard / List Invitations
     */
    public function index()
    {
        $invitationStats = [
            'total'     => EventInvitation::count(),
            'pending'   => EventInvitation::whereNull('membership_token')
                                ->whereNull('converted_user_id')
                                ->count(),
            'link_sent' => EventInvitation::whereNotNull('membership_token')->count(),
            'converted' => EventInvitation::whereNotNull('converted_user_id')->count(),
        ];

        $invitations = EventInvitation::with(['event', 'inviter'])
            ->latest()
            ->paginate(10);

        return view('admin.invitations.index', compact(
            'invitationStats',
            'invitations'
        ));
    }

    /**
     * ➕ CREATE – Show Create Form
     */
    public function create()
    {
        $events  = Event::latest()->get();
        $users   = User::where('role', 'member')->get();

        return view('admin.invitations.create', compact('events', 'users'));
    }

    /**
     * 💾 STORE – Save Invitation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inviter_id'   => 'required|exists:users,id',
            'event_id'     => 'required|exists:events,id',
            'guest_name'   => 'required|string|max:255',
            'guest_email'  => 'required|email|max:255',
            'guest_phone'  => 'nullable|string|max:20',
            'profession'   => 'nullable|string|max:255',
        ]);

        EventInvitation::create($validated);

        return redirect()
            ->route('admin.invitations.index')
            ->with('success', 'Invitation created successfully.');
    }

    /**
     * 👁 SHOW – View Invitation
     */
    public function show(EventInvitation $invitation)
    {
        $invitation->load(['event', 'inviter', 'convertedUser']);

        return view('admin.invitations.show', compact('invitation'));
    }

    /**
     * ✏️ EDIT – Edit Invitation
     */
    public function edit(EventInvitation $invitation)
    {
        $events = Event::latest()->get();
        $users  = User::where('role', 'member')->get();

        return view('admin.invitations.edit', compact(
            'invitation',
            'events',
            'users'
        ));
    }

    /**
     * 🔄 UPDATE – Update Invitation
     */
    public function update(Request $request, EventInvitation $invitation)
    {
        $validated = $request->validate([
            'inviter_id'   => 'required|exists:users,id',
            'event_id'     => 'required|exists:events,id',
            'guest_name'   => 'required|string|max:255',
            'guest_email'  => 'required|email|max:255',
            'guest_phone'  => 'nullable|string|max:20',
            'profession'   => 'nullable|string|max:255',
            'status'       => 'nullable|string|max:50',
        ]);

        $invitation->update($validated);

        return redirect()
            ->route('admin.invitations.index')
            ->with('success', 'Invitation updated successfully.');
    }

    /**
     * 🗑 DELETE – Remove Invitation
     */
    public function destroy(EventInvitation $invitation)
    {
        $invitation->delete();

        return redirect()
            ->route('admin.invitations.index')
            ->with('success', 'Invitation deleted successfully.');
    }

  

    public function sendMembershipLink(EventInvitation $invitation)
    {
        // Safety check
        if (!$invitation->guest_email) {
            return response()->json([
                'success' => false,
                'message' => 'Guest email is missing'
            ], 422);
        }
    
        // Prevent duplicate link
        if ($invitation->membership_token) {
            return response()->json([
                'success' => false,
                'message' => 'Invitation link already sent'
            ], 409);
        }
    
        // Generate token
        $token = Str::uuid()->toString();
    
     
        $invitation->update([
            'membership_token' => $token,
            'status' => 'invited', // ✅ valid
        ]);
        $link = route('member.join', $token);
    
        // Send mail
        Mail::to($invitation->guest_email)
            ->send(new MembershipInviteMail(
                $invitation->guest_name,
                $link
            ));
    
        return response()->json([
            'success' => true,
            'message' => 'Membership link sent successfully',
            'link'    => $link
        ]);
    }



}
