<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
        $chapterId = $member->chapter_id ?? null;

        // Current financial/year range (you can adjust as needed)
        $startOfYear = now()->startOfYear();
        $endOfYear   = now()->endOfYear();

        /*
        |--------------------------------------------------------------------------
        | BUSINESS (Expected vs Actual)
        |--------------------------------------------------------------------------
        | Actual = closed business
        | Expected = open/pending/in-progress pipeline
        */

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

        // Total business given and taken
        $totalBusinessGiven = BusinessGiveTake::givenBy($memberId)
            ->whereBetween('created_at', [$startOfYear, $endOfYear])
            ->sum('business_value');

        $totalBusinessTaken = BusinessGiveTake::takenBy($memberId)
            ->whereBetween('created_at', [$startOfYear, $endOfYear])
            ->sum('business_value');

        /*
        |--------------------------------------------------------------------------
        | Monthly Chart Data (Expected vs Actual)
        |--------------------------------------------------------------------------
        */

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
            $monthLabel = Carbon::createFromFormat('Y-m', $row->ym)->format('M Y');
            $chartLabels[] = $monthLabel;
            $chartActual[] = (float) $row->actual_value;
            $chartExpected[] = (float) $row->expected_value;
        }

        /*
        |--------------------------------------------------------------------------
        | Referral / Activity Metrics (BNI Style)
        |--------------------------------------------------------------------------
        */

        // Referrals given (by member)
        $totalReferralsGiven = BusinessGiveTake::where('giver_id', $memberId)
            ->where('referral_type', 'referral')
            ->count();

        // Referrals received
        $totalReferralsReceived = BusinessGiveTake::where('taker_id', $memberId)
            ->where('referral_type', 'referral')
            ->count();

        // Thank you slips (amount)
        $totalThankYouAmount = BusinessGiveTake::where('giver_id', $memberId)
            ->where('referral_type', 'thank_you')
            ->sum('thank_you_amount');

        // 1-to-1 meetings
        $oneToOneCount = BusinessGiveTake::where(function ($q) use ($memberId) {
                $q->where('giver_id', $memberId)
                  ->orWhere('taker_id', $memberId);
            })
            ->where('referral_type', '1to1')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Event / Invitation / Attendance
        |--------------------------------------------------------------------------
        */

        $visitorsInvited = EventInvitation::where('inviter_id', $memberId)->count();
        $visitorsConverted = EventInvitation::where('inviter_id', $memberId)
            ->whereNotNull('converted_user_id')
            ->count();

        $eventsAttended = EventAttendance::where('member_id', $memberId)
            ->where('status', 'present')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | CSR, Investors, Meetings, Recognition
        |--------------------------------------------------------------------------
        */

        $csrImpact = MemberCsr::where('member_id', $memberId)
            ->selectRaw('
                COALESCE(SUM(amount_spent),0) as total_amount,
                COALESCE(SUM(beneficiaries_count),0) as total_beneficiaries,
                COALESCE(SUM(volunteer_hours),0) as total_hours
            ')
            ->first();

        $investorCount = MemberInvestor::where('member_id', $memberId)->count();

        $meetingsAttended = MemberMeeting::whereHas('participants', function ($q) use ($memberId) {
                $q->where('user_id', $memberId)
                  ->where('attended', true);
            })
            ->count();

        $recognitionStats = MemberRecognition::where('member_id', $memberId)
            ->selectRaw('
                COUNT(*) as total_recognitions,
                COALESCE(SUM(business_value),0) as total_recognition_value,
                COALESCE(SUM(points),0) as total_points
            ')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Distribution of activity types (for pie/donut chart)
        |--------------------------------------------------------------------------
        */

        $activityDistribution = BusinessGiveTake::where('giver_id', $memberId)
            ->selectRaw('referral_type, COUNT(*) as total')
            ->groupBy('referral_type')
            ->pluck('total', 'referral_type')
            ->toArray();

        return view('member.dashboard', [
            'member' => $member,
            'actualBusiness' => $actualBusiness,
            'expectedBusiness' => $expectedBusiness,
            'totalBusinessGiven' => $totalBusinessGiven,
            'totalBusinessTaken' => $totalBusinessTaken,
            'totalReferralsGiven' => $totalReferralsGiven,
            'totalReferralsReceived' => $totalReferralsReceived,
            'totalThankYouAmount' => $totalThankYouAmount,
            'oneToOneCount' => $oneToOneCount,
            'visitorsInvited' => $visitorsInvited,
            'visitorsConverted' => $visitorsConverted,
            'eventsAttended' => $eventsAttended,
            'csrImpact' => $csrImpact,
            'investorCount' => $investorCount,
            'meetingsAttended' => $meetingsAttended,
            'recognitionStats' => $recognitionStats,
            'chartLabels' => $chartLabels,
            'chartActual' => $chartActual,
            'chartExpected' => $chartExpected,
            'activityDistribution' => $activityDistribution,
        ]);
    }
}
