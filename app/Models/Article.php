<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'short_description',
        'content',
        'thumbnail',
        'banner',
        'video_url',
        'gallery',
        'category',
        'subcategory',
        'tags',
        'industry',
        'author_id',
        'author_name',
        'author_designation',
        'author_company',
        'author_profile_image',
        'author_bio',
        'publish_date',
        'publish_time',
        'read_time',
        'status',
        'is_featured',
        'is_trending',
        'is_active',
        'views',
        'unique_views',
        'likes',
        'shares',
        'comments_count',
        'bookmarks',
        'average_rating',
        'ratings_count',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'og_title',
        'og_image',
        'twitter_card',
        'region',
        'language',
        'created_by',
        'updated_by',
        'approved_by',
        'approved_at',
    ];

    /**
     * Automatically generate slug from title if not provided.
     */
    protected static function boot()
    {
            parent::boot();

    static::creating(function ($article) {

        // Auto slug
        if (empty($article->slug)) {
            $article->slug = Str::slug($article->title);
        }

        // Auto read time
        if (empty($article->read_time) && !empty($article->content)) {
            $article->read_time = ceil(
                str_word_count(strip_tags($article->content)) / 200
            );
        }

        // ✅ AUTO publish_date when published
        if (
            $article->status === 'published' &&
            empty($article->publish_date)
        ) {
            $article->publish_date = now();
        }
    });

    }

    /**
     * Attribute casts
     */
    protected $casts = [
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'is_active' => 'boolean',
        'publish_date' => 'date',
        'publish_time' => 'datetime:H:i',
        'approved_at' => 'datetime',
        'average_rating' => 'float',
    ];

    /**
     * Relationships
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
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
     * Scopes
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('status', 'published');
    }

    public function scopeTrending($query)
    {
        return $query->where('is_trending', true)->where('status', 'published');
    }

    /**
     * Accessors for full media URLs
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail && str_starts_with($this->thumbnail, 'http')) {
            return $this->thumbnail;
        }

        return $this->thumbnail
            ? asset('storage/' . $this->thumbnail)
            : asset('images/default-thumbnail.jpg');
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

    public function getOgImageUrlAttribute()
    {
        if ($this->og_image && str_starts_with($this->og_image, 'http')) {
            return $this->og_image;
        }

        return $this->og_image
            ? asset('storage/' . $this->og_image)
            : $this->thumbnail_url;
    }

    /**
     * Increment view count and unique view (customizable)
     */
    public function incrementViews($unique = false)
    {
        $this->increment('views');
        if ($unique) {
            $this->increment('unique_views');
        }
    }

    /**
     * Generate estimated read time dynamically (optional accessor)
     */
    public function getEstimatedReadTimeAttribute()
    {
        return $this->read_time ?? ceil(str_word_count(strip_tags($this->content)) / 200);
    }

    /**
     * Get formatted publish date
     */
    public function getFormattedDateAttribute()
    {
        return $this->publish_date ? $this->publish_date->format('d M Y') : null;
    }
}
