<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OneToOneMeeting
 *
 * @property int $id
 * @property int|null $chapter_id
 * @property int $requester_id
 * @property int $requested_id
 * @property \Illuminate\Support\Carbon|null $scheduled_at
 * @property string $status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class OneToOneMeeting extends Model
{
    use HasFactory;

    protected $table = 'one_to_one_meetings';

    // Status constants to avoid typos
    public const STATUS_REQUESTED = 'requested';
    public const STATUS_SCHEDULED = 'scheduled';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    public static function allowedStatuses(): array
    {
        return [
            self::STATUS_REQUESTED,
            self::STATUS_SCHEDULED,
            self::STATUS_COMPLETED,
            self::STATUS_CANCELLED,
        ];
    }

    protected $fillable = [
        'chapter_id',
        'requester_id',
        'requested_id',
        'scheduled_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'chapter_id'   => 'integer',
        'requester_id' => 'integer',
        'requested_id' => 'integer',
        'scheduled_at' => 'datetime',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Optional chapter this meeting belongs to.
     */
    public function chapter()
    {
        return $this->belongsTo(AdminChapter::class, 'chapter_id');
    }

    /**
     * Member who requested the meeting.
     */
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    /**
     * Member who was requested.
     */
    public function requested()
    {
        return $this->belongsTo(User::class, 'requested_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope for meetings in a given status.
     */
    public function scopeStatus($query, ?string $status)
    {
        if (! $status || ! in_array($status, self::allowedStatuses(), true)) {
            return $query;
        }

        return $query->where('status', $status);
    }

    /**
     * Scope meetings scheduled between two datetimes.
     */
    public function scopeScheduledBetween($query, $from = null, $to = null)
    {
        if ($from) {
            $query->where('scheduled_at', '>=', $from);
        }
        if ($to) {
            $query->where('scheduled_at', '<=', $to);
        }
        return $query;
    }

    /**
     * Meetings related to a specific member (either requester or requested).
     */
    public function scopeForMember($query, int $memberId)
    {
        return $query->where(function ($q) use ($memberId) {
            $q->where('requester_id', $memberId)
              ->orWhere('requested_id', $memberId);
        });
    }

    /**
     * Recent first.
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('scheduled_at', 'desc');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers / Business methods
    |--------------------------------------------------------------------------
    */

    /**
     * Mark meeting as scheduled and set scheduled_at.
     *
     * @param \DateTime|string $datetime
     * @return $this
     */
    public function schedule($datetime)
    {
        $this->scheduled_at = $datetime;
        $this->status = self::STATUS_SCHEDULED;
        $this->save();

        return $this;
    }

    /**
     * Mark meeting as completed.
     *
     * @return $this
     */
    public function markCompleted()
    {
        $this->status = self::STATUS_COMPLETED;
        $this->save();

        return $this;
    }

    /**
     * Cancel meeting with optional notes/reason.
     *
     * @param string|null $reason
     * @return $this
     */
    public function cancel(?string $reason = null)
    {
        $this->status = self::STATUS_CANCELLED;
        if ($reason !== null) {
            $this->notes = trim($reason);
        }
        $this->save();

        return $this;
    }

    /**
     * Convenience boolean attributes.
     */
    public function getIsRequestedAttribute(): bool
    {
        return $this->status === self::STATUS_REQUESTED;
    }

    public function getIsScheduledAttribute(): bool
    {
        return $this->status === self::STATUS_SCHEDULED;
    }

    public function getIsCompletedAttribute(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function getIsCancelledAttribute(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }
}
