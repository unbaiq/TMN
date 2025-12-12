<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MemberBrandingPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'member_branding_posts';

    protected $fillable = [
        'member_id',
        'post_type',
        'title',
        'slug',
        'content',
        'featured_image',
        'video_url',
        'short_description',

        // SEO
        'meta_title',
        'meta_description',
        'meta_keywords',

        // Workflow
        'status',
        'approved_by',
        'rejection_reason',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Boot: Slug auto-generation
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::saving(function (MemberBrandingPost $post) {
            if (empty($post->slug) && !empty($post->title)) {
                $post->slug = static::generateUniqueSlug($post->title);
            }
        });
    }

    public static function generateUniqueSlug(string $title): string
    {
        $base = Str::slug(substr($title, 0, 180));
        $slug = $base;
        $i = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * The member who created the post.
     */
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    /**
     * Admin/chapter user who approved the post.
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes (Filters)
    |--------------------------------------------------------------------------
    */

    public function scopeStatus($query, ?string $status)
    {
        if (!$status) return $query;
        return $query->where('status', $status);
    }

    public function scopeType($query, ?string $type)
    {
        if (!$type) return $query;
        return $query->where('post_type', $type);
    }

    public function scopeSearch($query, ?string $keyword)
    {
        if (!$keyword) return $query;

        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('short_description', 'like', "%{$keyword}%")
              ->orWhere('meta_title', 'like', "%{$keyword}%")
              ->orWhere('meta_description', 'like', "%{$keyword}%")
              ->orWhereHas('member', function ($m) use ($keyword) {
                   $m->where('name', 'like', "%{$keyword}%");
              });
        });
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image
            ? asset('storage/' . $this->featured_image)
            : null;
    }

    public function getMetaTitleOrFallbackAttribute()
    {
        return $this->meta_title ?: $this->title;
    }

    public function getMetaDescriptionOrFallbackAttribute()
    {
        return $this->meta_description ?: ($this->short_description ?? '');
    }

    /*
    |--------------------------------------------------------------------------
    | Business Logic / Workflow
    |--------------------------------------------------------------------------
    */

    public function submit()
    {
        $this->status = 'submitted';
        $this->save();

        return $this;
    }

    public function approve($approverId)
    {
        $this->status = 'approved';
        $this->approved_by = $approverId;
        $this->rejection_reason = null;
        $this->save();

        return $this;
    }

    public function reject($reason, $approverId = null)
    {
        $this->status = 'rejected';
        $this->approved_by = $approverId;
        $this->rejection_reason = $reason;
        $this->save();

        return $this;
    }
}
