<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MemberAward extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'chapter_id',
        'member_meeting_id',
        'event_id',
        'title',
        'award_type',
        'description',
        'month',
        'year',
        'business_value',
        'points',
        'certificate_file',
        'status',
        'approved_by',
        'approved_at',
        'created_by',
    ];

    protected $casts = [
        'business_value' => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    // Relationships
    public function member() { return $this->belongsTo(User::class, 'member_id'); }
    public function chapter() { return $this->belongsTo(Chapter::class); }
    public function meeting() { return $this->belongsTo(MemberMeeting::class, 'member_meeting_id'); }
    public function event() { return $this->belongsTo(Event::class); }
    public function approver() { return $this->belongsTo(User::class, 'approved_by'); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }

    // Accessors
    public function getPeriodAttribute()
    {
        return ($this->month ? $this->month . ' ' : '') . ($this->year ?? '');
    }

    public function getCertificateUrlAttribute()
    {
        return $this->certificate_file ? asset('storage/' . $this->certificate_file) : null;
    }
}
