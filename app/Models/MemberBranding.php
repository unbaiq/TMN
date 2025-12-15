<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MemberBranding extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'chapter_id',
        'event_id',
        'branding_type',
        'title',
        'headline',
        'description',
        'theme',
        'activity_date',
        'duration',
        'location',
        'collaborators',
        'sponsor_name',
        'agency_name',
        'media_platform',
        'media_link',
        'media_type',
        'proof_document',
        'thumbnail_image',
        'reach_count',
        'engagement_count',
        'views_count',
        'downloads_count',
        'estimated_value',
        'media_mentions',
        'featured_by_tmn',
        'publication_name',
        'journalist_name',
        'press_contact_email',
        'press_contact_phone',
        'video_length',
        'episode_number',
        'series_name',
        'key_highlights',
        'member_quote',
        'resulting_leads',
        'followup_action',
        'status',
        'review_notes',
        'approved_by',
        'approved_at',
        'created_by',
    ];

    protected $casts = [
        'featured_by_tmn' => 'boolean',
        'activity_date' => 'date',
        'approved_at' => 'datetime',
        'estimated_value' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | 🔗 RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /** Member who created the branding */
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    /** Chapter the branding belongs to */
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    /** Related event if any (e.g. video shoot during event) */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /** Admin/Member who approved */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /** Creator record */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /*
    |--------------------------------------------------------------------------
    | 🧠 ACCESSORS / MUTATORS
    |--------------------------------------------------------------------------
    */

    /** Return formatted activity date or placeholder */
    public function getFormattedDateAttribute()
    {
        return $this->activity_date ? $this->activity_date->format('d M Y') : '—';
    }

    /** Return formatted estimated PR/media value */
    public function getFormattedValueAttribute()
    {
        return $this->estimated_value ? '₹' . number_format($this->estimated_value, 2) : '—';
    }

    /** Return storage URL for proof document */
    public function getProofDocumentUrlAttribute()
    {
        return $this->proof_document ? Storage::url($this->proof_document) : null;
    }

    /** Return storage URL for thumbnail */
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail_image ? Storage::url($this->thumbnail_image) : asset('images/default-thumbnail.png');
    }

    /** Combined reach/engagement summary */
    public function getImpactSummaryAttribute()
    {
        return sprintf(
            'Reach: %s | Engagement: %s',
            $this->reach_count ?? '—',
            $this->engagement_count ?? '—'
        );
    }

    /** Simple status color (for badge UI) */
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'approved' => 'bg-green-100 text-green-700',
            'under_review' => 'bg-yellow-100 text-yellow-700',
            'rejected' => 'bg-gray-100 text-gray-600',
            default => 'bg-blue-100 text-blue-700',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | 🔍 SCOPES (Reusable Query Filters)
    |--------------------------------------------------------------------------
    */

    /** Filter by branding type */
    public function scopeOfType($query, $type)
    {
        return $query->when($type, fn($q) => $q->where('branding_type', $type));
    }

    /** Filter by status */
    public function scopeOfStatus($query, $status)
    {
        return $query->when($status, fn($q) => $q->where('status', $status));
    }

    /** Filter by chapter */
    public function scopeOfChapter($query, $chapterId)
    {
        return $query->when($chapterId, fn($q) => $q->where('chapter_id', $chapterId));
    }

    /** Filter by keyword (title, description, media platform) */
    public function scopeSearch($query, $keyword)
    {
        return $query->when($keyword, function ($q, $keyword) {
            $q->where(function ($sub) use ($keyword) {
                $sub->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('media_platform', 'like', "%{$keyword}%")
                    ->orWhere('publication_name', 'like', "%{$keyword}%");
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | 🧾 HELPER METHODS
    |--------------------------------------------------------------------------
    */

    /** Check if branding is approved */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /** Check if featured by TMN */
    public function isFeatured(): bool
    {
        return $this->featured_by_tmn === true;
    }
}
