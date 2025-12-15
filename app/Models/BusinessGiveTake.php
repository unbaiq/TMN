<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessGiveTake extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'giver_id',
        'taker_id',
        'chapter_id',
        'service_name',
        'description',
        'business_value',
        'status',
        'referral_type',
        'referral_level',
        'referral_company',
        'referral_contact_person',
        'referral_contact_phone',
        'referral_contact_email',
        'thank_you_given',
        'thank_you_message',
        'thank_you_amount',
        'follow_up_status',
        'follow_up_date',
        'follow_up_notes',
        'reference_document',
        'internal_notes',
        'reject_reason',
        'accepted_at',
        'rejected_at',
        'closed_at',
        'taker_request',
        'is_visible_to_chapter',
        'created_by',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'business_value' => 'decimal:2',
        'thank_you_amount' => 'decimal:2',
        'thank_you_given' => 'boolean',
        'taker_request' => 'boolean',
        'is_visible_to_chapter' => 'boolean',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
        'closed_at' => 'datetime',
        'follow_up_date' => 'datetime',
    ];

    // ===========================
    // 🔗 RELATIONSHIPS
    // ===========================

    /**
     * The member who gave the business.
     */
    public function giver()
    {
        return $this->belongsTo(User::class, 'giver_id');
    }

    /**
     * The member who received the business.
     */
    public function taker()
    {
        return $this->belongsTo(User::class, 'taker_id');
    }

    /**
     * The chapter involved in this transaction.
     */
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * The user who created this record (admin or system).
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ===========================
    // ⚙️ SCOPES
    // ===========================

    /**
     * Scope for given businesses by a user.
     */
    public function scopeGivenBy($query, $userId)
    {
        return $query->where('giver_id', $userId);
    }

    /**
     * Scope for taken businesses by a user.
     */
    public function scopeTakenBy($query, $userId)
    {
        return $query->where('taker_id', $userId);
    }

    /**
     * Scope for filtering by status.
     */
    public function scopeStatus($query, $status)
    {
        if (!empty($status)) {
            return $query->where('status', $status);
        }
        return $query;
    }

    /**
     * Scope for filtering by referral type.
     */
    public function scopeType($query, $type)
    {
        if (!empty($type)) {
            return $query->where('referral_type', $type);
        }
        return $query;
    }

    // ===========================
    // 🧠 ACCESSORS
    // ===========================

    /**
     * Display label for referral type (user-friendly).
     */
    public function getReferralTypeLabelAttribute()
    {
        return match ($this->referral_type) {
            'referral'   => 'Referral Given',
            'thank_you'  => 'Thank You Slip',
            '1to1'       => '1-to-1 Meeting',
            'visitor'    => 'Visitor Invited',
            'training'   => 'Training Attended',
            'testimony'  => 'Testimony Shared',
            default      => ucfirst($this->referral_type ?? 'Unknown'),
        };
    }

    /**
     * Display-friendly business value (e.g., ₹ 50,000)
     */
    public function getFormattedBusinessValueAttribute()
    {
        return $this->business_value ? '₹ ' . number_format($this->business_value, 2) : '—';
    }
}
