<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberRelationshipIntelligence extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'connection_strength', 'collaboration_history',
        'follow_up_notes', 'preferred_communication', 'interests',
        'key_date_birthday', 'key_date_anniversary',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
