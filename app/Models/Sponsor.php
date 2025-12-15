<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'company_name',
        'industry',
        'designation',
        'about',
        'email',
        'phone',
        'alternate_phone',
        'website',
        'linkedin',
        'facebook',
        'instagram',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'country',
        'pincode',
        'sponsorship_level',
        'sponsor_type',
        'duration',
        'start_date',
        'end_date',
        'auto_renew',
        'logo',
        'banner',
        'video_link',
        'brochure',
        'gallery',
        'profile_link',
        'promo_video',
        'is_featured',
        'is_active',
        'status',
        'views',
        'clicks',
        'leads',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'created_by',
        'updated_by',
        'approved_by',
        'approved_at',
    ];

    /**
     * Automatically create slug from name.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sponsor) {
            if (empty($sponsor->slug)) {
                $sponsor->slug = Str::slug($sponsor->name);
            }
        });
    }

    /**
     * Casting dates and booleans
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'auto_renew' => 'boolean',
    ];

    /**
     * Relationships
     */
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
    public function getLogoUrlAttribute()
    {
        if ($this->logo && str_starts_with($this->logo, 'http')) {
            return $this->logo;
        }

        return $this->logo
            ? asset('storage/' . $this->logo)
            : asset('images/default-logo.png');
    }

    public function getBannerUrlAttribute()
    {
        if ($this->banner && str_starts_with($this->banner, 'http')) {
            return $this->banner;
        }

        return $this->banner
            ? asset('storage/' . $this->banner)
            : asset('images/default-banner.jpg');
    }

    public function getBrochureUrlAttribute()
    {
        return $this->brochure ? asset('storage/' . $this->brochure) : null;
    }

    public function getVideoUrlAttribute()
    {
        return $this->video_link && str_starts_with($this->video_link, 'http')
            ? $this->video_link
            : ($this->video_link ? 'https://' . $this->video_link : null);
    }

    /**
     * Accessor for formatted sponsorship duration
     */
    public function getDurationLabelAttribute()
    {
        if ($this->start_date && $this->end_date) {
            return $this->start_date->format('d M Y') . ' - ' . $this->end_date->format('d M Y');
        }
        return $this->duration ?? 'N/A';
    }

    /**
     * Status Label with proper formatting
     */
    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status ?? 'unknown');
    }

    /**
     * Scope for Active Sponsors
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for Featured Sponsors
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }

    /**
     * Scope for Approved Sponsors
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for Expired Sponsors
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired')
                     ->orWhere('end_date', '<', now()->toDateString());
    }

    /**
     * Increment analytics counters
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function incrementClicks()
    {
        $this->increment('clicks');
    }

    public function incrementLeads()
    {
        $this->increment('leads');
    }
}
