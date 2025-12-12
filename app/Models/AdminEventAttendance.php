<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminEventAttendance extends Model
{
    use HasFactory;

    /**
     * Explicit table name (migration created `event_attendance`).
     *
     * @var string
     */
    protected $table = 'event_attendance';

    /**
     * Mass-assignable attributes.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'event_id',
        'member_id',
        'chapter',
        'attended_at',
        'status',
    ];

    /**
     * Attribute casts.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'attended_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * The global event this attendance belongs to.
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    /**
     * The member (user) who attended.
     */
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Filter by attendance status (Present, Late, Absent).
     */
    public function scopeStatus($query, ?string $status)
    {
        if (empty($status)) {
            return $query;
        }
        return $query->where('status', $status);
    }

    /**
     * Filter by chapter (string).
     */
    public function scopeChapter($query, ?string $chapter)
    {
        if (empty($chapter)) {
            return $query;
        }
        return $query->where('chapter', $chapter);
    }

    /**
     * Filter records between two datetimes (inclusive).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \DateTime|string|null $from
     * @param \DateTime|string|null $to
     */
    public function scopeAttendedBetween($query, $from = null, $to = null)
    {
        if ($from) {
            $query->where('attended_at', '>=', $from);
        }
        if ($to) {
            $query->where('attended_at', '<=', $to);
        }
        return $query;
    }

    /**
     * Recent attendance first.
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('attended_at', 'desc');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors / Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Human-friendly attended at.
     */
    public function getAttendedAtFormattedAttribute()
    {
        return $this->attended_at ? $this->attended_at->format('d M Y, h:i A') : null;
    }

    /**
     * Boolean helpers for quick checks.
     */
    public function getIsPresentAttribute(): bool
    {
        return strcasecmp($this->status, 'Present') === 0;
    }

    public function getIsLateAttribute(): bool
    {
        return strcasecmp($this->status, 'Late') === 0;
    }

    public function getIsAbsentAttribute(): bool
    {
        return strcasecmp($this->status, 'Absent') === 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Business helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Mark attendance (convenience method).
     *
     * @param string $status  'Present'|'Late'|'Absent'
     * @param \DateTime|string|null $time
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function markAttendance(string $status, $time = null)
    {
        $allowed = ['Present', 'Late', 'Absent'];

        if (! in_array($status, $allowed, true)) {
            throw new \InvalidArgumentException('Invalid attendance status. Allowed: ' . implode(', ', $allowed));
        }

        $this->status = $status;
        $this->attended_at = $time ? $time : now();
        $this->save();

        return $this;
    }
}
