<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    use HasFactory;

    protected $table = 'event_registrations';

    protected $fillable = [
        'event_id',
        'member_id',
        'registered_at',
        'status',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // The event the member registered for
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    // The member (user)
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    // registered | attended | cancelled
    public function scopeStatus($query, ?string $status)
    {
        if (!$status) return $query;

        return $query->where('status', $status);
    }

    // filter by date range
    public function scopeRegisteredBetween($query, $from = null, $to = null)
    {
        if ($from) {
            $query->where('registered_at', '>=', $from);
        }
        if ($to) {
            $query->where('registered_at', '<=', $to);
        }

        return $query;
    }

    // newest first
    public function scopeRecent($query)
    {
        return $query->orderBy('registered_at', 'desc');
    }

    // filter for a specific event
    public function scopeForEvent($query, $eventId)
    {
        return $query->where('event_id', $eventId);
    }

    // filter for a specific member
    public function scopeForMember($query, $memberId)
    {
        return $query->where('member_id', $memberId);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors / Helpers
    |--------------------------------------------------------------------------
    */

    public function getRegisteredAtFormattedAttribute()
    {
        return $this->registered_at
            ? $this->registered_at->format('d M Y, h:i A')
            : null;
    }

    public function getIsRegisteredAttribute(): bool
    {
        return $this->status === 'registered';
    }

    public function getIsAttendedAttribute(): bool
    {
        return $this->status === 'attended';
    }

    public function getIsCancelledAttribute(): bool
    {
        return $this->status === 'cancelled';
    }

    /*
    |--------------------------------------------------------------------------
    | Business Actions
    |--------------------------------------------------------------------------
    */

    /**
     * Mark the registration as attended.
     *
     * @return $this
     */
    public function markAttended()
    {
        $this->status = 'attended';
        $this->save();

        return $this;
    }

    /**
     * Cancel the registration.
     *
     * @return $this
     */
    public function cancel()
    {
        $this->status = 'cancelled';
        $this->save();

        return $this;
    }
}
