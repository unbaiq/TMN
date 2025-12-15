<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Insight extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'image',
        'category',
        'author_name',
        'publish_date',
        'status',
    ];

    /**
     * Automatically generate slug from title if not provided
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($insight) {
            if (empty($insight->slug)) {
                $insight->slug = Str::slug($insight->title);
            }
        });
    }

    /**
     * Scope for published insights
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Get full image URL (if using storage)
     */
    public function getImageUrlAttribute()
    {
        if ($this->image && str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        return $this->image ? asset('storage/' . $this->image) : asset('images/default-insight.jpg');
    }
}
