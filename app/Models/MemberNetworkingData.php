<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberNetworkingData extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'referrals_given', 'referrals_received',
        'closed_business_value', 'one_to_one_meetings',
        'testimonials_given', 'testimonials_received',
        'visitor_invites', 'substitute_attendance',
        'weekly_attendance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
