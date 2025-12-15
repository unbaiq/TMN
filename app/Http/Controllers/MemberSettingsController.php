<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberSettingsController extends Controller
{
    /**
     * Display the current logged-in member’s settings and details.
     */
    public function index()
    {
     
        $user = Auth::user();

        // Load all related data safely
        $user->loadMissing([
            'basicInfo',
            'businessInfo',
            'networkingData',
            'relationshipIntelligence',
            'supportingData',
            'adminData',
        ]);

        // Pass user to view for display
        return view('member.settings', compact('user'));
    }

    /**
     * Update the member profile and related info tables.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate basic fields (you can expand these rules as needed)
        $request->validate([
            'full_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'contact_mobile' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:255',
            'website_url' => 'nullable|url|max:255',
        ]);

        DB::transaction(function () use ($user, $request) {

            // 🧍 BASIC INFO
            $user->basicInfo()->updateOrCreate(
                ['user_id' => $user->id],
                $request->only([
                    'full_name',
                    'gender',
                    'date_of_birth',
                    'contact_mobile',
                    'contact_office',
                    'email',
                    'linkedin',
                    'social_links',
                    'bni_chapter_name',
                    'bni_chapter_role',
                ])
            );

            // 🏢 BUSINESS INFO
            $user->businessInfo()->updateOrCreate(
                ['user_id' => $user->id],
                $request->only([
                    'company_name',
                    'industry',
                    'business_type',
                    'business_description',
                    'office_address',
                    'website_url',
                    'years_in_business',
                    'target_clients',
                    'usp',
                ])
            );

            // 🔗 NETWORKING DATA
            $user->networkingData()->updateOrCreate(
                ['user_id' => $user->id],
                $request->only([
                    'referrals_given',
                    'referrals_received',
                    'closed_business_value',
                    'one_to_one_meetings',
                    'testimonials_given',
                    'testimonials_received',
                    'visitor_invites',
                    'substitute_attendance',
                    'weekly_attendance',
                ])
            );

            // 🧠 RELATIONSHIP INTELLIGENCE
            $user->relationshipIntelligence()->updateOrCreate(
                ['user_id' => $user->id],
                $request->only([
                    'connection_strength',
                    'collaboration_history',
                    'follow_up_notes',
                    'preferred_communication',
                    'interests',
                    'key_date_birthday',
                    'key_date_anniversary',
                ])
            );

            // 📎 SUPPORTING DATA
            $user->supportingData()->updateOrCreate(
                ['user_id' => $user->id],
                $request->only([
                    'business_cards',
                    'profile_sheet',
                    'presentation_schedule',
                    'recent_training',
                    'awards',
                ])
            );

            // 🛠 ADMIN DATA (for admins only)
            if ($user->role === 'admin') {
                $user->adminData()->updateOrCreate(
                    ['user_id' => $user->id],
                    $request->only([
                        'status',
                        'payment_status',
                        'remarks',
                        'referral_conversion_rate',
                        'top_referral_partners',
                        'avg_business_value_per_referral',
                        'member_engagement_score',
                        'chapter_impact_rank',
                    ])
                );
            }
        });

        return redirect()
            ->route('member.settings')
            ->with('success', 'Profile updated successfully!');
    }
}
