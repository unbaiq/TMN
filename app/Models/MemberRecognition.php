<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MemberRecognition extends Model
{
    use HasFactory;

    protected $table = 'member_recognitions';

    protected $fillable = [
        'member_id',
        'given_by',
        'chapter_id',
        'member_meeting_id',
        'title',
        'category',
        'description',
        'evidence_file',
        'recognized_on',
        'business_value',
        'points',
        'status',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'recognized_on' => 'date',
        'approved_at' => 'datetime',
        'business_value' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | 🔗 Relationships
    |--------------------------------------------------------------------------
    */

    // The member who received the recognition
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    // The member/admin who gave the recognition
    public function giver()
    {
        return $this->belongsTo(User::class, 'given_by');
    }

    // The chapter associated with this recognition
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    // If linked to a meeting
    public function meeting()
    {
        return $this->belongsTo(MemberMeeting::class, 'member_meeting_id');
    }

    // Admin who approved the recognition
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /*
    |--------------------------------------------------------------------------
    | 🧠 Scopes (for filtering)
    |--------------------------------------------------------------------------
    */

    // Filter by chapter
    public function scopeForChapter($query, $chapterId)
    {
        return $query->where('chapter_id', $chapterId);
    }

    // Filter by category (referral, leadership, etc.)
    public function scopeOfCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Filter by status (approved, pending, rejected)
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /*
    |--------------------------------------------------------------------------
    | 🧩 Accessors
    |--------------------------------------------------------------------------
    */

    // Return human-readable recognition date
    public function getRecognizedDateAttribute()
    {
        return $this->recognized_on
            ? Carbon::parse($this->recognized_on)->format('d M Y')
            : '—';
    }

    // Return human-readable status badge class
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'approved' => 'bg-green-50 text-green-700',
            'pending' => 'bg-yellow-50 text-yellow-700',
            'rejected' => 'bg-red-50 text-red-700',
            default => 'bg-gray-50 text-gray-700',
        };
    }

    // Return formatted business value (e.g., ₹10,000.00)
    public function getFormattedValueAttribute()
    {
        return $this->business_value
            ? '₹' . number_format($this->business_value, 2)
            : '—';
    }

    // File URL (if stored)
    public function getEvidenceUrlAttribute()
    {
        return $this->evidence_file
            ? asset('storage/' . $this->evidence_file)
            : null;
    }
}
