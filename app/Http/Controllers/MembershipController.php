<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\User;
use App\Models\MemberBasicInfo;
use App\Models\MemberBusinessInfo;
use App\Models\MemberNetworkingData;
use App\Models\MemberRelationshipIntelligence;
use App\Models\MemberSupportingData;
use App\Models\MemberAdminData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\MembershipInviteMail;

class MembershipController extends Controller
{

    /**
     * Show all members in a table.
     */
    public function index()
    {
        $members = User::with(['basicInfo', 'businessInfo', 'adminData'])
            ->where('role', 'member')
            ->latest()
            ->paginate(20);

        return view('admin.member.index', compact('members'));
    }

    /**
     * Show a single member’s profile.
     */
    public function show($id)
    {
        $member = User::with(['basicInfo', 'businessInfo', 'adminData'])->findOrFail($id);
        return view('admin.member.show', compact('member'));
    }
    /**
     * Send membership link to enquiry
     */
    public function sendMembershipLink(Enquiry $enquiry)
    {
        // Generate unique registration token
        $token = Str::uuid();
        $enquiry->membership_token = $token;
        $enquiry->save();

        // Registration link
        $link = url("/join/{$token}");

        // ✅ Send membership invite email (HTML)
        if ($enquiry->email) {
            Mail::to($enquiry->email)->send(new MembershipInviteMail($enquiry->name, $link));
        }

        return response()->json([
            'message' => 'Membership link generated and emailed successfully!',
            'link' => $link
        ]);
    }

    /**
     * Show membership registration form
     */
    public function showJoinForm($token)
    {
        $enquiry = Enquiry::where('membership_token', $token)->firstOrFail();
        return view('admin.member.join', compact('enquiry'));
    }

    /**
     * Save completed membership form and create member structure
     */
    public function submitJoinForm(Request $request, $token)
    {
        $enquiry = Enquiry::where('membership_token', $token)->firstOrFail();

        $validated = $request->validate([
            'email' => 'required|email',
            'full_name' => 'required|string|max:255',
            'gender' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'contact_mobile' => 'required|string|max:15',
            'profession' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'website_url' => 'nullable|string|max:255',
            'business_description' => 'nullable|string|max:1000',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::transaction(function () use ($validated, $enquiry, $request) {
            // Upload photo
            $photoPath = $request->hasFile('photo')
                ? $request->file('photo')->store('member_photos', 'public')
                : null;

            // 🔑 Generate random password
            $plainPassword = Str::random(8);

            // 1️⃣ Create User
            $user = User::create([
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => Hash::make($plainPassword),
                'role' => 'member',
            ]);

            // 2️⃣ Basic Info
            MemberBasicInfo::create([
                'user_id' => $user->id,
                'full_name' => $validated['full_name'],
                'gender' => $validated['gender'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'photo' => $photoPath,
                'contact_mobile' => $validated['contact_mobile'],
                'email' => $validated['email'],
                'membership_id' => 'TMN-' . strtoupper(Str::random(6)),
                'date_joined' => now(),
            ]);

            // 3️⃣ Business Info
            MemberBusinessInfo::create([
                'user_id' => $user->id,
                'company_name' => $validated['company_name'] ?? null,
                'website_url' => $validated['website_url'] ?? null,
                'business_description' => $validated['business_description'] ?? null,
            ]);

            MemberNetworkingData::create(['user_id' => $user->id]);
            MemberRelationshipIntelligence::create(['user_id' => $user->id]);
            MemberSupportingData::create(['user_id' => $user->id]);
            MemberAdminData::create(['user_id' => $user->id, 'status' => 'inactive', 'payment_status' => 'pending']);

            // Update Enquiry
            $enquiry->update([
                'status' => 'closed',
                'membership_token' => null,
                'converted_to_member' => true,
            ]);

            // ✉️ Send password email
            Mail::raw("Hello {$validated['full_name']},\n\nYour TMN membership has been successfully registered!\n\nLogin Email: {$validated['email']}\nPassword: {$plainPassword}\n\nPlease change your password after first login.\n\nRegards,\nTMN Team", function ($message) use ($validated) {
                $message->to($validated['email'])
                    ->subject('Your TMN Membership Account Details');
            });
        });

        // ✅ Return JSON for fetch() success
        return response()->json(['success' => true]);
    }

    public function activateMember($id)
{
    $member = MemberAdminData::where('user_id', $id)->firstOrFail();

    if ($member->status === 'active') {
        return response()->json(['message' => 'This member account is already active.']);
    }

    $member->update(['status' => 'active']);

    // Optional: send email notification
    $user = User::find($id);
    if ($user) {
        Mail::raw("Dear {$user->name},\n\nYour TMN membership account has been verified and activated.\nYou can now log in using your credentials.\n\nRegards,\nTMN Team", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Your TMN Membership Account Activated');
        });
    }

    return response()->json(['success' => true, 'message' => 'Member account activated successfully.']);
}
}
