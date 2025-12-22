<?php

namespace App\Http\Controllers;

use App\Models\BusinessGiveTake;
use App\Models\EventAttendance;
use App\Models\EventInvitation;
use App\Models\MemberCsr;
use App\Models\MemberInvestor;
use App\Models\MemberMeeting;
use App\Models\MemberRecognition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class MemberDashboardController extends Controller
{
    public function index()
    {
        $member = Auth::user();
        $memberId = $member->id;
        $chapterId = $member->chapter_id;

        /* ============================================================
         | FINANCIAL YEAR RANGE
         ============================================================ */
        $startOfYear = now()->startOfYear();
        $endOfYear   = now()->endOfYear();

        /* ============================================================
         | BUSINESS (Expected vs Actual)
         ============================================================ */
        $baseBusinessQuery = BusinessGiveTake::where(function ($q) use ($memberId) {
                $q->where('giver_id', $memberId)
                  ->orWhere('taker_id', $memberId);
            })
            ->whereBetween('created_at', [$startOfYear, $endOfYear]);

        $actualBusiness = (clone $baseBusinessQuery)
            ->where('status', 'closed')
            ->sum('business_value');

        $expectedBusiness = (clone $baseBusinessQuery)
            ->whereIn('status', ['open', 'pending', 'in_progress'])
            ->sum('business_value');

        $totalBusinessGiven = BusinessGiveTake::givenBy($memberId)
            ->whereBetween('created_at', [$startOfYear, $endOfYear])
            ->sum('business_value');

        $totalBusinessTaken = BusinessGiveTake::takenBy($memberId)
            ->whereBetween('created_at', [$startOfYear, $endOfYear])
            ->sum('business_value');

        /* ============================================================
         | MONTHLY BUSINESS CHART
         ============================================================ */
        $monthlyBusiness = (clone $baseBusinessQuery)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as ym')
            ->selectRaw('SUM(CASE WHEN status = "closed" THEN business_value ELSE 0 END) as actual_value')
            ->selectRaw('SUM(CASE WHEN status IN ("open","pending","in_progress") THEN business_value ELSE 0 END) as expected_value')
            ->groupBy('ym')
            ->orderBy('ym')
            ->get();

        $chartLabels = [];
        $chartActual = [];
        $chartExpected = [];

        foreach ($monthlyBusiness as $row) {
            $chartLabels[]   = Carbon::createFromFormat('Y-m', $row->ym)->format('M Y');
            $chartActual[]   = (float) $row->actual_value;
            $chartExpected[] = (float) $row->expected_value;
        }

        /* ============================================================
         | REFERRALS / ACTIVITY
         ============================================================ */
        $totalReferralsGiven = BusinessGiveTake::where('giver_id', $memberId)
            ->where('referral_type', 'referral')
            ->count();

        $totalReferralsReceived = BusinessGiveTake::where('taker_id', $memberId)
            ->where('referral_type', 'referral')
            ->count();

        $totalThankYouAmount = BusinessGiveTake::where('giver_id', $memberId)
            ->where('referral_type', 'thank_you')
            ->sum('thank_you_amount');

        /* ============================================================
         | ✅ REAL MEETING COUNTS (FIXED)
         ============================================================ */

        // 1-to-1 meetings (created OR participated)
        $oneToOneCount = MemberMeeting::where('meeting_type', '1to1')
            ->where(function ($q) use ($memberId) {
                $q->where('created_by', $memberId)
                  ->orWhereHas('participants', function ($p) use ($memberId) {
                      $p->where('user_id', $memberId);
                  });
            })
            ->count();

        // Cluster meetings (chapter based)
        $clusterMeetingCount = MemberMeeting::where('meeting_type', 'cluster')
            ->where('chapter_id', $chapterId)
            ->count();

        // Meetings actually attended
        $meetingsAttended = MemberMeeting::whereHas('participants', function ($q) use ($memberId) {
                $q->where('user_id', $memberId)
                  ->where('attended', true);
            })
            ->count();

        /* ============================================================
         | EVENTS / ATTENDANCE
         ============================================================ */
        $visitorsInvited = EventInvitation::where('inviter_id', $memberId)->count();

        $visitorsConverted = EventInvitation::where('inviter_id', $memberId)
            ->whereNotNull('converted_user_id')
            ->count();

        $eventsAttended = EventAttendance::where('member_id', $memberId)
            ->where('status', 'present')
            ->count();

        /* ============================================================
         | CSR / INVESTORS / RECOGNITION
         ============================================================ */
        $csrImpact = MemberCsr::where('member_id', $memberId)
            ->selectRaw('
                COALESCE(SUM(amount_spent),0) as total_amount,
                COALESCE(SUM(beneficiaries_count),0) as total_beneficiaries,
                COALESCE(SUM(volunteer_hours),0) as total_hours
            ')
            ->first();

        $investorCount = MemberInvestor::where('member_id', $memberId)->count();

        $recognitionStats = MemberRecognition::where('member_id', $memberId)
            ->selectRaw('
                COUNT(*) as total_recognitions,
                COALESCE(SUM(business_value),0) as total_recognition_value,
                COALESCE(SUM(points),0) as total_points
            ')
            ->first();

        /* ============================================================
         | ACTIVITY DISTRIBUTION
         ============================================================ */
        $activityDistribution = BusinessGiveTake::where('giver_id', $memberId)
            ->selectRaw('referral_type, COUNT(*) as total')
            ->groupBy('referral_type')
            ->pluck('total', 'referral_type')
            ->toArray();

        return view('member.dashboard', compact(
            'member',
            'actualBusiness',
            'expectedBusiness',
            'totalBusinessGiven',
            'totalBusinessTaken',
            'totalReferralsGiven',
            'totalReferralsReceived',
            'totalThankYouAmount',
            'oneToOneCount',
            'clusterMeetingCount',
            'visitorsInvited',
            'visitorsConverted',
            'eventsAttended',
            'csrImpact',
            'investorCount',
            'meetingsAttended',
            'recognitionStats',
            'chartLabels',
            'chartActual',
            'chartExpected',
            'activityDistribution'
        ));
    }
}
