<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Chapter;
use App\Models\BusinessGiveTake;
use App\Models\Event;
use App\Models\MemberAdminData;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // =======================
        // 📊 STATS OVERVIEW
        // =======================
        $stats = [
            'total_members'     => User::count(),
            'active_chapters'   => Chapter::where('is_active', true)->count(),
            'total_referrals'   => BusinessGiveTake::count(),
            'business_value'    => '₹ ' . number_format(BusinessGiveTake::sum('business_value'), 2),
            'events_this_month' => Event::whereMonth('event_date', now()->month)->count(),
            'pending_approvals' => MemberAdminData::where('status', 'pending')->count(),
        ];

        // =======================
        // 🏆 TOP CHAPTERS
        // =======================
        $topChapters = Chapter::withCount('members')
            ->withSum('businessGiveTakes', 'business_value')
            ->orderByDesc('business_give_takes_sum_business_value')
            ->take(5)
            ->get()
            ->map(function ($chapter) {
                return [
                    'name'           => $chapter->name,
                    'members'        => $chapter->members_count,
                    'business_value' => '₹ ' . number_format($chapter->business_give_takes_sum_business_value, 2),
                    'growth'         => '+' . rand(2, 15) . '%', // demo value
                ];
            });

        // =======================
        // 🧑‍🤝‍🧑 RECENT MEMBERS
        // =======================
        $recentMembers = User::latest()->take(5)->get()->map(function ($member) {
            return [
                'name'       => $member->name,
                'profession' => $member->businessInfo->profession ?? '—',
                'chapter'    => $member->chapter->name ?? 'Unassigned',
                'joined'     => $member->created_at->diffForHumans(),
            ];
        });

        // =======================
        // 🎟 UPCOMING EVENTS
        // =======================
        $upcomingEvents = Event::where('event_date', '>=', now())
            ->orderBy('event_date')
            ->take(5)
            ->get()
            ->map(function ($event) {
                return [
                    'title'    => $event->title,
                    'location' => $event->city ?? 'Online',
                    'date'     => Carbon::parse($event->event_date)->format('d M'),
                ];
            });

        // =======================
        // 🔔 RECENT ACTIVITIES
        // =======================
        $recentActivities = [
            ['icon' => 'users',      'message' => 'New member joined "Downtown Chapter"', 'time' => '2 hrs ago'],
            ['icon' => 'briefcase',  'message' => 'Business worth ₹1,20,000 recorded',    'time' => '5 hrs ago'],
            ['icon' => 'calendar',   'message' => 'Upcoming networking meetup added',      'time' => '1 day ago'],
            ['icon' => 'check',      'message' => '3 membership applications approved',   'time' => '2 days ago'],
            ['icon' => 'trending-up','message' => 'Total business growth +12%',            'time' => '3 days ago'],
        ];

        return view('admin.dashboard', compact(
            'stats',
            'topChapters',
            'recentMembers',
            'upcomingEvents',
            'recentActivities'
        ));
    }
}
