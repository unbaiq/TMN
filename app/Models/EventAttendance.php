<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'member_id',
        'status',
    ];

    /**
     * Get the event associated with this attendance record.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the member (user) associated with this attendance record.
     */
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }
}
