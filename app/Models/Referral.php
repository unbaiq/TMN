<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $table = 'referrals';

    protected $fillable = [
        'referrer_id',
        'referred_member_id',
        'referral_name',
        'referral_phone',
        'referral_email',
        'notes',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Member who created the referral.
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    /**
     * If referral is converted into a TMN user later.
     */
    public function referredMember()
    {
        return $this->belongsTo(User::class, 'referred_member_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes (filters)
    |--------------------------------------------------------------------------
    */

    public function scopeStatus($query, ?string $status)
    {
        if (!$status) return $query;
        return $query->where('status', $status);
    }

    public function scopeSearch($query, ?string $keyword)
    {
        if (!$keyword) return $query;

        return $query->where(function ($q) use ($keyword) {
            $q->where('referral_name', 'like', "%{$keyword}%")
              ->orWhere('referral_phone', 'like', "%{$keyword}%")
              ->orWhere('referral_email', 'like', "%{$keyword}%")
              ->orWhereHas('referrer', function ($ref) use ($keyword) {
                   $ref->where('name', 'like', "%{$keyword}%");
              });
        });
    }

    public function scopeForReferrer($query, int $memberId)
    {
        return $query->where('referrer_id', $memberId);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /*
    |--------------------------------------------------------------------------
    | Mutators (normalize data)
    |--------------------------------------------------------------------------
    */

    public function setReferralPhoneAttribute($value)
    {
        $this->attributes['referral_phone'] = $value
            ? preg_replace('/\D+/', '', $value)
            : null;
    }

    public function setReferralEmailAttribute($value)
    {
        $this->attributes['referral_email'] = $value ? strtolower(trim($value)) : null;
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getIsPendingAttribute(): bool
    {
        return $this->status === 'pending';
    }

    public function getIsConvertedAttribute(): bool
    {
        return $this->status === 'converted';
    }

    public function getIsRejectedAttribute(): bool
    {
        return $this->status === 'rejected';
    }

    /*
    |--------------------------------------------------------------------------
    | Business Logic
    |--------------------------------------------------------------------------
    */

    /**
     * Mark referral as converted and attach new TMN member id.
     */
    public function convert(int $memberId)
    {
        $this->update([
            'status'              => 'converted',
            'referred_member_id'  => $memberId,
        ]);

        return $this;
    }

    /**
     * Reject referral with optional notes.
     */
    public function reject(?string $reason = null)
    {
        $this->update([
            'status' => 'rejected',
            'notes'  => $reason ?? $this->notes,
        ]);

        return $this;
    }
}
