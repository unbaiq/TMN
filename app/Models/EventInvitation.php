<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventInvitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'inviter_id',
        'event_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'profession',
        'status',
        'converted_user_id',
    ];

    public function inviter()
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function convertedUser()
    {
        return $this->belongsTo(User::class, 'converted_user_id');
    }
}
