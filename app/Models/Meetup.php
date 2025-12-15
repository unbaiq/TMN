<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Meetup extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'tagline',
        'short_description',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'timezone',
        'venue_name',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'country',
        'pincode',
        'google_map_link',
        'max_capacity',
        'registered_count',
        'is_registration_open',
        'registration_link',
        'organizer_id',
        'organizer_name',
        'organizer_designation',
        'organizer_phone',
        'organizer_email',
        'banner',
        'thumbnail',
        'gallery',
        'brochure',
        'category',
        'theme',
        'topics',
        'status',
        'is_featured',
        'is_public',
        'is_active',
        'views',
        'registrations',
        'check_ins',
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
     * Automatically generate slug if missing
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($meetup) {
            if (empty($meetup->slug)) {
                $meetup->slug = Str::slug($meetup->title);
            }
        });
    }

    /**
     * Attribute casting
     */
    protected $casts = [
        'event_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'approved_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_public' => 'boolean',
        'is_active' => 'boolean',
        'is_registration_open' => 'boolean',
        'average_rating' => 'float',
    ];

    /**
     * Relationships
     */
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
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
     * Accessors for image URLs
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

    /**
     * Scopes for filtering
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('status', 'upcoming');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming')
                     ->whereDate('event_date', '>=', now()->toDateString());
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Helper: formatted event date
     */
    public function getFormattedDateAttribute()
    {
        return $this->event_date ? $this->event_date->format('d M Y') : '-';
    }

    /**
     * Helper: display readable event timing
     */
    public function getEventTimingAttribute()
    {
        if ($this->start_time && $this->end_time) {
            return date('h:i A', strtotime($this->start_time)) . ' - ' . date('h:i A', strtotime($this->end_time));
        }

        return $this->start_time ? date('h:i A', strtotime($this->start_time)) : null;
    }

    /**
     * Increment views safely
     */
    public function incrementViews($unique = false)
    {
        $this->increment('views');
    }
}
