<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClusterMeetingParticipant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cluster_meeting_participants';

    protected $fillable = [
        'cluster_meeting_id',
        'member_id',
        'attendance',
        'notes',
    ];

    protected $casts = [
        'cluster_meeting_id' => 'integer',
        'member_id'          => 'integer',
        'attendance'         => 'string',
        'created_at'         => 'datetime',
        'updated_at'         => 'datetime',
        'deleted_at'         => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Attendance constants
    |--------------------------------------------------------------------------
    | Use these constants to avoid typos when checking/setting attendance.
    */
    public const ATTENDANCE_PENDING  = 'pending';
    public const ATTENDANCE_ACCEPTED = 'accepted';
    public const ATTENDANCE_REJECTED = 'rejected';
    public const ATTENDANCE_PRESENT  = 'present';
    public const ATTENDANCE_ABSENT   = 'absent';

    public static function allowedAttendances(): array
    {
        return [
            self::ATTENDANCE_PENDING,
            self::ATTENDANCE_ACCEPTED,
            self::ATTENDANCE_REJECTED,
            self::ATTENDANCE_PRESENT,
            self::ATTENDANCE_ABSENT,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * The cluster meeting this participant is linked to.
     */
    public function clusterMeeting()
    {
        // Adjust class name/namespace if your ClusterMeeting model lives elsewhere
        return $this->belongsTo(ClusterMeeting::class, 'cluster_meeting_id');
    }

    /**
     * The member (user) participating in the meeting.
     */
    public function member()
    {
        // Assumes members are stored in users table and User model exists
        return $this->belongsTo(User::class, 'member_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope to filter by attendance status.
     */
    public function scopeAttendance($query, ?string $status)
    {
        if (! $status) {
            return $query;
        }

        return $query->where('attendance', $status);
    }

    /**
     * Filter participants for a specific meeting id.
     */
    public function scopeForMeeting($query, int $meetingId)
    {
        return $query->where('cluster_meeting_id', $meetingId);
    }

    /**
     * Filter participants for a specific member id.
     */
    public function scopeForMember($query, int $memberId)
    {
        return $query->where('member_id', $memberId);
    }

    /**
     * Recently updated / created first.
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers / Mutators
    |--------------------------------------------------------------------------
    */

    /**
     * Mark participant as accepted.
     */
    public function markAccepted(): self
    {
        $this->attendance = self::ATTENDANCE_ACCEPTED;
        $this->save();

        return $this;
    }

    /**
     * Mark participant as rejected with optional note.
     */
    public function markRejected(?string $reason = null): self
    {
        $this->attendance = self::ATTENDANCE_REJECTED;
        if ($reason !== null) {
            $this->notes = trim($reason);
        }
        $this->save();

        return $this;
    }

    /**
     * Mark participant present or absent.
     */
    public function markPresent(): self
    {
        $this->attendance = self::ATTENDANCE_PRESENT;
        $this->save();

        return $this;
    }

    public function markAbsent(): self
    {
        $this->attendance = self::ATTENDANCE_ABSENT;
        $this->save();

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Human readable label for attendance.
     */
    public function getAttendanceLabelAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->attendance));
    }

    /**
     * Returns true if participant is confirmed (accepted or present)
     */
    public function getIsConfirmedAttribute(): bool
    {
        return in_array($this->attendance, [self::ATTENDANCE_ACCEPTED, self::ATTENDANCE_PRESENT], true);
    }
}
