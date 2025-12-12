<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandingAvailed extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'branding_availed';

    protected $fillable = [
        'chapter_id',
        'member_id',
        'type',
        'amount_paid',
        'currency',
        'package',
        'availed_at',
        'notes',
    ];

    protected $casts = [
        'chapter_id'   => 'integer',
        'member_id'    => 'integer',
        'amount_paid'  => 'decimal:2',
        'availed_at'   => 'datetime',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
        'deleted_at'   => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Constants
    |--------------------------------------------------------------------------
    */
    public const TYPE_NORMAL = 'normal';
    public const TYPE_PAID   = 'paid';

    public static function allowedTypes(): array
    {
        return [
            self::TYPE_NORMAL,
            self::TYPE_PAID,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Chapter where branding was availed (nullable).
     */
    public function chapter()
    {
        return $this->belongsTo(AdminChapter::class, 'chapter_id');
    }

    /**
     * Member who availed the branding (users table).
     */
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes / Filters
    |--------------------------------------------------------------------------
    */

    /**
     * Only paid / normal entries.
     */
    public function scopePaid($query)
    {
        return $query->where('type', self::TYPE_PAID);
    }

    public function scopeNormal($query)
    {
        return $query->where('type', self::TYPE_NORMAL);
    }

    /**
     * Filter by chapter id.
     */
    public function scopeForChapter($query, ?int $chapterId)
    {
        if (! $chapterId) return $query;
        return $query->where('chapter_id', $chapterId);
    }

    /**
     * Filter by member id.
     */
    public function scopeForMember($query, ?int $memberId)
    {
        if (! $memberId) return $query;
        return $query->where('member_id', $memberId);
    }

    /**
     * Filter by date range (availed_at).
     */
    public function scopeAvailedBetween($query, $from = null, $to = null)
    {
        if ($from) $query->where('availed_at', '>=', $from);
        if ($to)   $query->where('availed_at', '<=', $to);
        return $query;
    }

    /**
     * Recent first.
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('availed_at', 'desc');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Formatted amount (currency + value).
     */
    public function getAmountFormattedAttribute(): string
    {
        $amount = $this->amount_paid ? number_format((float)$this->amount_paid, 2) : '0.00';
        $currency = $this->currency ?? 'INR';
        return "{$currency} {$amount}";
    }

    /**
     * True if this was a paid package.
     */
    public function getIsPaidAttribute(): bool
    {
        return $this->type === self::TYPE_PAID;
    }

    /**
     * True if normal (complimentary/basic).
     */
    public function getIsNormalAttribute(): bool
    {
        return $this->type === self::TYPE_NORMAL;
    }

    /*
    |--------------------------------------------------------------------------
    | Business helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Mark record as paid with amount and currency.
     *
     * @param float|int|string $amount
     * @param string|null $currency
     * @return $this
     */
    public function markPaid($amount, ?string $currency = null)
    {
        $this->type = self::TYPE_PAID;
        $this->amount_paid = $amount;
        if ($currency) $this->currency = $currency;
        $this->availed_at = $this->availed_at ?? now();
        $this->save();

        return $this;
    }

    /**
     * Mark record as normal/complimentary.
     *
     * @return $this
     */
    public function markNormal()
    {
        $this->type = self::TYPE_NORMAL;
        $this->amount_paid = null;
        $this->availed_at = $this->availed_at ?? now();
        $this->save();

        return $this;
    }

    /**
     * Aggregate total revenue for given filters (static convenience method).
     *
     * @param \Illuminate\Database\Eloquent\Builder|null $query
     * @return float
     */
    public static function totalRevenue($query = null): float
    {
        $q = $query ?: static::query();
        // only sum paid entries
        return (float) $q->where('type', self::TYPE_PAID)->sum('amount_paid');
    }
}
