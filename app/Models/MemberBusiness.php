<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberBusiness extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'member_businesses';

    // Member roles
    public const ROLE_GIVER = 'giver';
    public const ROLE_TAKER = 'taker';

    // Status values
    public const STATUS_INITIATED   = 'initiated';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED   = 'completed';
    public const STATUS_CANCELLED   = 'cancelled';

    protected $fillable = [
        'member_one_id',
        'member_two_id',
        'member_one_role',
        'business_title',
        'description',
        'business_value',
        'attachment',
        'status',
        'member_one_notes',
        'member_two_notes',
        'completed_at',
    ];

    protected $casts = [
        'business_value' => 'decimal:2',
        'completed_at'   => 'datetime',
        'created_at'     => 'datetime',
        'updated_at'     => 'datetime',
        'deleted_at'     => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Member one (required).
     */
    public function memberOne()
    {
        return $this->belongsTo(User::class, 'member_one_id');
    }

    /**
     * Member two (optional).
     */
    public function memberTwo()
    {
        return $this->belongsTo(User::class, 'member_two_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeStatus($query, $status = null)
    {
        if (!$status) {
            return $query;
        }

        return $query->where('status', $status);
    }

    public function scopeForMember($query, $memberId)
    {
        return $query->where(function ($q) use ($memberId) {
            $q->where('member_one_id', $memberId)
              ->orWhere('member_two_id', $memberId);
        });
    }

    public function scopeHighValue($query, $threshold = 100000.00)
    {
        return $query->where('business_value', '>=', $threshold);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    public function getAttachmentUrlAttribute()
    {
        return $this->attachment ? asset('storage/' . $this->attachment) : null;
    }

    public function getIsCompletedAttribute()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function getIsInProgressAttribute()
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    public function getIsCancelledAttribute()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Normalize business_value on set (ensure decimal).
     */
    public function setBusinessValueAttribute($value)
    {
        if ($value === null) {
            $this->attributes['business_value'] = 0;
            return;
        }

        // store as numeric string acceptable by decimal cast
        $this->attributes['business_value'] = number_format((float)$value, 2, '.', '');
    }

    /*
    |--------------------------------------------------------------------------
    | Business helpers
    |--------------------------------------------------------------------------
    */

    public function markInProgress()
    {
        $this->status = self::STATUS_IN_PROGRESS;
        $this->save();

        return $this;
    }

    public function markCompleted($when = null)
    {
        $this->status = self::STATUS_COMPLETED;
        $this->completed_at = $when ? $when : now();
        $this->save();

        return $this;
    }

    public function cancel($note = null)
    {
        $this->status = self::STATUS_CANCELLED;
        if ($note !== null) {
            $this->member_one_notes = trim(($this->member_one_notes ?? '') . "\n" . $note);
        }
        $this->save();

        return $this;
    }

    public function addNote($memberNumber, $note)
    {
        if ($memberNumber == 1) {
            $this->member_one_notes = trim(($this->member_one_notes ?? '') . "\n" . $note);
        } else {
            $this->member_two_notes = trim(($this->member_two_notes ?? '') . "\n" . $note);
        }

        $this->save();

        return $this;
    }
}
