<?php

namespace App\Http\Controllers;

use App\Models\EventAttendance;
use Illuminate\Support\Facades\Auth;

class MemberAttendanceController extends Controller
{
    /**
     * Show all attended events of the logged-in member.
     */
    public function index()
    {
        $user = Auth::user();

        // Fetch all events this member has attended
        $attendances = EventAttendance::with(['event.chapter'])
            ->where('member_id', $user->id)
            ->where('status', 'present')
            ->latest()
            ->get();

        return view('member.chapter.attended', compact('attendances'));
    }
}
