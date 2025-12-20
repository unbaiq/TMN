<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_type',
        'chapter_id',
        'title',
        'slug',
        'description',
        'organizer_id',
        'host_name',
        'host_contact',
        'host_email',
        'venue_name',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'country',
        'pincode',
        'event_date',
        'start_time',
        'end_time',
        'agenda',
        'notes',
        'is_online',
        'meeting_link',
        'meeting_password',
        'max_attendees',
        'registered_attendees',
        'status',
        'is_public',
        'is_featured',
        'banner_image',
    ];

    /**
     * ✅ CASTS (🔥 MOST IMPORTANT FIX)
     */
    protected $casts = [
        'event_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time'   => 'datetime:H:i',
        'is_online'  => 'boolean',
        'is_public'  => 'boolean',
        'is_featured'=> 'boolean',
    ];

    /**
     * Automatically generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title) . '-' . Str::random(5);
            }
        });
    }

    /* =========================
     |  RELATIONSHIPS
     ========================= */

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_attendees')
            ->withTimestamps()
            ->withPivot('status', 'check_in_time');
    }

    public function attendances()
    {
        return $this->hasMany(EventAttendance::class, 'event_id');
    }

    public function invitations()
    {
        return $this->hasMany(EventInvitation::class);
    }

    /* =========================
     |  ACCESSORS
     ========================= */

    /**
     * ✅ Safe formatted date
     */
    public function getFormattedDateAttribute()
    {
        return $this->event_date
            ? $this->event_date->format('l, d M Y')
            : null;
    }

    /**
     * ✅ Safe formatted time range
     */
    public function getFormattedTimeAttribute()
    {
        if (!$this->start_time || !$this->end_time) {
            return null;
        }

        return Carbon::parse($this->start_time)->format('h:i A')
            . ' - ' .
            Carbon::parse($this->end_time)->format('h:i A');
    }

    /**
     * Full address
     */
    public function getFullAddressAttribute()
    {
        return collect([
            $this->venue_name,
            $this->address_line1,
            $this->address_line2,
            $this->city,
            $this->state,
            $this->country,
            $this->pincode,
        ])->filter()->join(', ');
    }

    /**
     * Is event past
     */
    public function getIsPastAttribute()
    {
        return $this->event_date
            ? $this->event_date->isPast()
            : false;
    }

    /* =========================
     |  SCOPES
     ========================= */

    public function scopeUpcoming($query)
    {
        return $query
            ->where('status', 'upcoming')
            ->whereDate('event_date', '>=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeChapterEvents($query)
    {
        return $query->where('event_type', 'chapter');
    }

    public function scopeGeneralEvents($query)
    {
        return $query->where('event_type', 'general');
    }
}
