<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventInvitation extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'inviter_id',
        'event_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'profession',
        'status',
        'membership_token',
        'converted_user_id',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'membership_token' => 'string',
        'created_at'       => 'datetime',
        'updated_at'       => 'datetime',
    ];

    // ────────────────────────────────
    // 🔗 RELATIONSHIPS
    // ────────────────────────────────

    /**
     * User who sent the invitation
     */
    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }

    /**
     * Event for which invitation was sent
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * User created after conversion (if any)
     */
    public function convertedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'converted_user_id');
    }

    // ────────────────────────────────
    // 🧠 BUSINESS HELPERS
    // ────────────────────────────────

    /**
     * Check if guest converted to registered user
     */
    public function isConverted(): bool
    {
        return !is_null($this->converted_user_id);
    }

    /**
     * Check if membership link has been generated
     */
    public function linkSent(): bool
    {
        return !is_null($this->membership_token);
    }

    /**
     * Check if invitation is accepted
     */
    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    /**
     * Check if invitation is declined
     */
    public function isDeclined(): bool
    {
        return $this->status === 'declined';
    }

    /**
     * Check if guest attended event
     */
    public function isAttended(): bool
    {
        return $this->status === 'attended';
    }
}
