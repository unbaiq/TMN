<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberAdminData extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'status', 'payment_status', 'last_updated_by', 'remarks',
        'referral_conversion_rate', 'top_referral_partners',
        'avg_business_value_per_referral', 'member_engagement_score',
        'chapter_impact_rank',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
