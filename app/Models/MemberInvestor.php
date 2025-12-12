<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberInvestor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'member_investors';

    // Status constants
    public const STATUS_PENDING  = 'pending';
    public const STATUS_VERIFIED = 'verified';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'member_id',
        'investment_amount',
        'interested_categories',
        'startup_interest',
        'member_notes',
        'status',
        'verified_by',
        'rejection_reason',
        'admin_notes',
        'investment_proof',
    ];

    protected $casts = [
        'investment_amount' => 'decimal:2',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
        'deleted_at'        => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * The member who declared interest in investing.
     */
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    /**
     * The admin/user who verified the investor record.
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeStatus($query, ?string $status)
    {
        if (! $status) {
            return $query;
        }

        return $query->where('status', $status);
    }

    public function scopeVerified($query)
    {
        return $query->where('status', self::STATUS_VERIFIED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    public function scopeForMember($query, int $memberId)
    {
        return $query->where('member_id', $memberId);
    }

    public function scopeHighValue($query, float $threshold = 1000000.00)
    {
        return $query->where('investment_amount', '>=', $threshold);
    }

    /**
     * Search across member name and startup_interest and categories.
     */
    public function scopeSearch($query, ?string $keyword)
    {
        if (! $keyword) return $query;

        return $query->where(function ($q) use ($keyword) {
            $q->where('startup_interest', 'like', "%{$keyword}%")
              ->orWhere('interested_categories', 'like', "%{$keyword}%")
              ->orWhereHas('member', function ($m) use ($keyword) {
                  $m->where('name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
              });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    /**
     * Return interested categories as array if stored as comma-separated string.
     */
    public function getInterestedCategoriesArrayAttribute(): array
    {
        if (empty($this->interested_categories)) {
            return [];
        }

        // If JSON, decode; otherwise split by comma
        $value = $this->interested_categories;

        if (strpos($value, '{') === 0 || strpos($value, '[') === 0) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $value))));
    }

    /**
     * Set interested categories from array or string; stores as comma-separated string.
     */
    public function setInterestedCategoriesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['interested_categories'] = implode(',', array_map('trim', $value));
            return;
        }

        $this->attributes['interested_categories'] = $value;
    }

    /**
     * Return full URL for investment proof if present.
     */
    public function getInvestmentProofUrlAttribute(): ?string
    {
        return $this->investment_proof ? asset('storage/' . $this->investment_proof) : null;
    }

    /*
    |--------------------------------------------------------------------------
    | Business helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Verify this investor record.
     *
     * @param int|null $verifierId
     * @return $this
     */
    public function verify(?int $verifierId = null)
    {
        $this->status = self::STATUS_VERIFIED;
        $this->verified_by = $verifierId ?? auth()->id();
        $this->rejection_reason = null;
        $this->save();

        return $this;
    }

    /**
     * Reject this investor record with optional reason.
     *
     * @param string|null $reason
     * @param int|null $verifierId
     * @return $this
     */
    public function reject(?string $reason = null, ?int $verifierId = null)
    {
        $this->status = self::STATUS_REJECTED;
        $this->verified_by = $verifierId ?? auth()->id();
        $this->rejection_reason = $reason;
        $this->save();

        return $this;
    }

    /**
     * Convenience method to attach investment proof path and save.
     *
     * @param string $path
     * @return $this
     */
    public function attachProof(string $path)
    {
        $this->investment_proof = $path;
        $this->save();

        return $this;
    }
}
