<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Consultation extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        // IDENTIFICATION
        'key',

        // CONTENT
        'title',
        'subtitle',
        'content',

        // CTA
        'cta_text',
        'cta_link',

        // FEED CONTROL
        'display_order',
        'is_featured',
        'is_active',
        'is_public',

        // ANALYTICS
        'views',
        'clicks',

        // AUDIT
        'created_by',
        'updated_by',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
        'is_public'   => 'boolean',
        'views'       => 'integer',
        'clicks'      => 'integer',
    ];

    /**
     * Auto-generate key if not provided
     */
    protected static function booted()
    {
        static::creating(function ($consultation) {
            if (empty($consultation->key) && $consultation->title) {
                $consultation->key = Str::slug($consultation->title);
            }
        });
    }

    /* =====================
     |  RELATIONSHIPS
     |=====================*/

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /* =====================
     |  SCOPES (FEED)
     |=====================*/

    /**
     * Public & active feed items
     */
    public function scopePublicFeed($query)
    {
        return $query->where('is_active', true)
                     ->where('is_public', true)
                     ->orderBy('display_order');
    }

    /**
     * Featured feed items
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                     ->where('is_active', true);
    }

    /* =====================
     |  ACCESSORS
     |=====================*/

    /**
     * Normalized CTA link
     */
    public function getCtaUrlAttribute()
    {
        if (!$this->cta_link) {
            return null;
        }

        return str_starts_with($this->cta_link, 'http')
            ? $this->cta_link
            : url($this->cta_link);
    }

    /* =====================
     |  HELPERS
     |=====================*/

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Increment CTA clicks
     */
    public function incrementClicks()
    {
        $this->increment('clicks');
    }
}
