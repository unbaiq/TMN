<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Advisory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'tagline',
        'short_description',
        'description',
        'category',
        'type',
        'session_date',
        'start_time',
        'end_time',
        'mode',
        'venue',
        'city',
        'country',
        'meeting_link',
        'timezone',

        // ADVISOR DETAILS
        'advisor_id',
        'advisor_name',
        'advisor_designation',
        'advisor_email',
        'advisor_phone',
        'organization',

        // ✅ ADVISOR EXPERIENCE (ADDED)
        'advisor_experience_years',
        'advisor_experience_summary',

        // MEDIA
        'banner',
        'thumbnail',
        'resources',
        'presentation',
        'brochure',

        // PARTICIPATION
        'max_participants',
        'registered_count',
        'is_registration_open',
        'registration_link',

        // METRICS
        'views',
        'registrations',
        'feedback_count',
        'average_rating',

        // STATUS
        'status',
        'is_featured',
        'is_public',
        'is_active',

        // SEO
        'meta_title',
        'meta_description',
        'meta_keywords',

        // AUDIT
        'created_by',
        'updated_by',
        'approved_by',
        'approved_at',
    ];

    /**
     * Auto-generate slug before creation.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($advisory) {
            if (empty($advisory->slug)) {
                $advisory->slug = Str::slug($advisory->title);
            }
        });
    }

    /**
     * Attribute Casting
     */
    protected $casts = [
        'session_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'approved_at' => 'datetime',

        'is_featured' => 'boolean',
        'is_public' => 'boolean',
        'is_active' => 'boolean',
        'is_registration_open' => 'boolean',

        'average_rating' => 'float',
        'advisor_experience_years' => 'integer', // ✅
    ];

    /**
     * Relationships
     */
    public function advisor()
    {
        return $this->belongsTo(User::class, 'advisor_id');
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
     * Accessors for Media URLs
     */
    public function getBannerUrlAttribute()
    {
        if ($this->banner && str_starts_with($this->banner, 'http')) {
            return $this->banner;
        }

        return $this->banner
            ? asset('storage/' . $this->banner)
            : asset('images/default-banner.jpg');
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail && str_starts_with($this->thumbnail, 'http')) {
            return $this->thumbnail;
        }

        return $this->thumbnail
            ? asset('storage/' . $this->thumbnail)
            : asset('images/default-thumbnail.jpg');
    }

    public function getBrochureUrlAttribute()
    {
        return $this->brochure ? asset('storage/' . $this->brochure) : null;
    }

    public function getPresentationUrlAttribute()
    {
        return $this->presentation ? asset('storage/' . $this->presentation) : null;
    }

    /**
     * Normalized meeting link
     */
    public function getMeetingLinkUrlAttribute()
    {
        if (!$this->meeting_link) return null;

        return str_starts_with($this->meeting_link, 'http')
            ? $this->meeting_link
            : 'https://' . $this->meeting_link;
    }

    /**
     * Date & Time helpers
     */
    public function getFormattedDateAttribute()
    {
        return $this->session_date ? $this->session_date->format('d M Y') : '-';
    }

    public function getTimeRangeAttribute()
    {
        if ($this->start_time && $this->end_time) {
            return date('h:i A', strtotime($this->start_time))
                . ' - '
                . date('h:i A', strtotime($this->end_time));
        }

        return $this->start_time
            ? date('h:i A', strtotime($this->start_time))
            : null;
    }

    /**
     * ✅ Advisor Experience Label (UI ready)
     * Example: "15+ Years Experience"
     */
    public function getAdvisorExperienceLabelAttribute()
    {
        return $this->advisor_experience_years
            ? $this->advisor_experience_years . '+ Years Experience'
            : null;
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'scheduled')
                     ->whereDate('session_date', '>=', now()->toDateString());
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Advisor Display Name
     */
    public function getAdvisorDisplayAttribute()
    {
        return $this->advisor_name
            ? $this->advisor_name . ($this->advisor_designation ? ' (' . $this->advisor_designation . ')' : '')
            : ($this->advisor?->name ?? 'N/A');
    }

    /**
     * Increment Views Count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }
}
