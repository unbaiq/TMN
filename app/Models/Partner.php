<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $table = 'partners';

    protected $fillable = [
        // BASIC DETAILS
        'name',
        'slug',
        'company_name',
        'industry',
        'designation',
        'about',

        // CONTACT DETAILS
        'email',
        'phone',
        'alternate_phone',
        'website',
        'linkedin',
        'facebook',
        'instagram',

        // ADDRESS
        'address_line1',
        'address_line2',
        'city',
        'state',
        'country',
        'pincode',

        // PARTNERSHIP DETAILS
        'partner_type',
        'level',
        'partnership_duration',
        'start_date',
        'end_date',

        // MEDIA
        'logo',
        'banner',
        'gallery',
        'brochure',

        // LINKS & BRAND INFO
        'profile_link',
        'promo_video',

        // STATUS
        'is_featured',
        'is_active',
        'status',

        // ANALYTICS
        'views',
        'clicks',
        'inquiries',

        // SEO & META
        'meta_title',
        'meta_description',
        'meta_keywords',

        // AUDIT TRAIL
        'created_by',
        'updated_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'gallery' => 'array', // JSON conversion
        'approved_at' => 'datetime',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /* -----------------------------
     | Relationships
     ----------------------------- */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /* -----------------------------
     | Accessors / Mutators
     ----------------------------- */
    public function getFullAddressAttribute(): string
    {
        return collect([
            $this->address_line1,
            $this->address_line2,
            $this->city,
            $this->state,
            $this->pincode,
            $this->country,
        ])->filter()->join(', ');
    }

    /* -----------------------------
     | Scopes
     ----------------------------- */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
