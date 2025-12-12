<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminChapterEventAttendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'chapter_event_attendance';

    protected $fillable = [
        'member_id',
        'chapter_event_id',
        'attendance_status',
        'proof_file',
        'member_notes',
        'verification_status',
        'verified_by',
        'rejection_reason',
        'admin_notes',
    ];

    protected $casts = [
        'attendance_status'    => 'string',
        'verification_status'  => 'string',
        'created_at'           => 'datetime',
        'updated_at'           => 'datetime',
        'deleted_at'           => 'datetime',
    ];

    /*
     |--------------------------------------------------------------------------
     | Relationships
     |--------------------------------------------------------------------------
     */

    // Member who marked attendance
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    // Event they attended
    public function chapterEvent()
    {
        return $this->belongsTo(AdminChapterEvent::class, 'chapter_event_id');
    }

    // Admin who verified attendance
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /*
     |--------------------------------------------------------------------------
     | Scopes (filters)
     |--------------------------------------------------------------------------
     */

    // PRESENT | ABSENT | INTERESTED
    public function scopeStatus($query, $status)
    {
        if (!$status) return $query;
        return $query->where('attendance_status', $status);
    }

    // VERIFIED | PENDING | REJECTED
    public function scopeVerification($query, $status)
    {
        if (!$status) return $query;
        return $query->where('verification_status', $status);
    }

    // Filter by chapter event
    public function scopeForEvent($query, $eventId)
    {
        return $query->where('chapter_event_id', $eventId);
    }

    // Filter by member
    public function scopeForMember($query, $memberId)
    {
        return $query->where('member_id', $memberId);
    }

    /*
     |--------------------------------------------------------------------------
     | Accessors & Helpers
     |--------------------------------------------------------------------------
     */

    // Returns full URL of proof file
    public function getProofUrlAttribute()
    {
        return $this->proof_file
            ? asset('storage/' . $this->proof_file)
            : null;
    }

    public function getIsVerifiedAttribute(): bool
    {
        return $this->verification_status === 'verified';
    }

    public function getIsPendingAttribute(): bool
    {
        return $this->verification_status === 'pending';
    }

    public function getIsRejectedAttribute(): bool
    {
        return $this->verification_status === 'rejected';
    }
}
