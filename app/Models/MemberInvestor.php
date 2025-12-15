<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberInvestor extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'chapter_id',
        'investor_name',
        'designation',
        'company_name',
        'email',
        'phone',
        'alternate_phone',
        'city',
        'state',
        'country',
        'linkedin_profile',
        'investment_focus',
        'investment_capacity',
        'invested_value',
        'preferred_stage',
        'preferred_ticket_size',
        'years_of_experience',
        'relationship_type',
        'referral_source',
        'notes',
        'status',
        'created_by',
    ];

    // Relationships
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
