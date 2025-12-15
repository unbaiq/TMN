<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'short_description',
        'description',
        'image',
        'banner',
        'video_url',
        'gallery',
        'category',
        'industry',
        'tags',
        'publish_date',
        'author_id',
        'author_name',
        'author_designation',
        'author_company',
        'chapter_name',
        'chapter_city',
        'business_generated',
        'referrals_received',
        'clients_gained',
        'team_size_growth',
        'views',
        'likes',
        'shares',
        'comments_count',
        'status',
        'is_featured',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'created_by',
        'updated_by',
    ];

    /**
     * Automatically generate slug from title if not provided.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($story) {
            if (empty($story->slug)) {
                $story->slug = Str::slug($story->title);
            }
        });
    }

    /**
     * Cast attributes.
     */
    protected $casts = [
        'gallery' => 'array',
        'publish_date' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Relationship: Story belongs to an author (User).
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Relationship: Story created by admin.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relationship: Story last updated by admin.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Accessor for full image URL.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image && str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        return $this->image ? asset('storage/' . $this->image) : asset('images/default-story.jpg');
    }

    /**
     * Accessor for full banner URL.
     */
    public function getBannerUrlAttribute()
    {
        if ($this->banner && str_starts_with($this->banner, 'http')) {
            return $this->banner;
        }

        return $this->banner ? asset('storage/' . $this->banner) : asset('images/default-banner.jpg');
    }

    /**
     * Scope for published stories.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')->where('is_active', true);
    }

    /**
     * Scope for featured stories.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('status', 'published');
    }

    /**
     * Increment view count.
     */
    public function incrementViews()
    {
        $this->increment('views');
    }
}
