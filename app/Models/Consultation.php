<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
        'category',
        'consultation_date',
        'start_time',
        'end_time',
        'mode',
        'meeting_link',
        'venue',
        'city',
        'country',
        'consultant_id',
        'consultant_name',
        'consultant_designation',
        'consultant_email',
        'consultant_phone',
        'client_id',
        'client_name',
        'client_email',
        'client_phone',
        'organization',
        'duration_minutes',
        'fee_amount',
        'currency',
        'is_paid',
        'key_takeaways',
        'notes',
        'rating',
        'follow_up_required',
        'follow_up_date',
        'status',
        'is_featured',
        'is_public',
        'is_active',
        'views',
        'registrations',
        'feedback_count',
        'average_rating',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'created_by',
        'updated_by',
        'approved_by',
        'approved_at',
    ];

    /**
     * Auto generate slug on creation.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($consultation) {
            if (empty($consultation->slug)) {
                $consultation->slug = Str::slug($consultation->title);
            }
        });
    }

    /**
     * Attribute casting
     */
    protected $casts = [
        'consultation_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'follow_up_date' => 'date',
        'approved_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_public' => 'boolean',
        'is_active' => 'boolean',
        'is_paid' => 'boolean',
        'follow_up_required' => 'boolean',
        'fee_amount' => 'decimal:2',
        'average_rating' => 'float',
    ];

    /**
     * Relationships
     */
    public function consultant()
    {
        return $this->belongsTo(User::class, 'consultant_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Accessor: Full meeting link
     */
    public function getMeetingLinkUrlAttribute()
    {
        if (!$this->meeting_link) return null;

        return str_starts_with($this->meeting_link, 'http')
            ? $this->meeting_link
            : 'https://' . $this->meeting_link;
    }

    /**
     * Accessor: Combined readable session time
     */
    public function getSessionTimingAttribute()
    {
        if ($this->start_time && $this->end_time) {
            return date('h:i A', strtotime($this->start_time)) . ' - ' . date('h:i A', strtotime($this->end_time));
        }

        return $this->start_time ? date('h:i A', strtotime($this->start_time)) : null;
    }

    /**
     * Accessor: Rating stars
     */
    public function getStarRatingAttribute()
    {
        return str_repeat('⭐', $this->rating ?? 0);
    }

    /**
     * Scope: Active consultations
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Upcoming sessions
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'scheduled')
                     ->whereDate('consultation_date', '>=', now()->toDateString());
    }

    /**
     * Scope: Completed consultations
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope: Featured consultations
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                     ->where('is_active', true);
    }

    /**
     * Accessor: Formatted date
     */
    public function getFormattedDateAttribute()
    {
        return $this->consultation_date ? $this->consultation_date->format('d M Y') : '-';
    }

    /**
     * Helper: Full consultant name display
     */
    public function getConsultantDisplayAttribute()
    {
        return $this->consultant_name
            ? $this->consultant_name . ($this->consultant_designation ? ' (' . $this->consultant_designation . ')' : '')
            : ($this->consultant?->name ?? 'N/A');
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }
}
