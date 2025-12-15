<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberSupportingData extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'business_cards', 'profile_sheet',
        'presentation_schedule', 'recent_training', 'awards',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
