<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    // Automatically generate slug from title if not provided
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title) . '-' . Str::random(5);
            }
        });
    }

    /* ---------------------------
     |  Relationships
     --------------------------- */

    // An event may belong to a chapter (for chapter events)
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    // Organizer (User) who created/hosts the event
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    // Example: Attendees relation (if you later make an event_attendees table)
    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_attendees')
            ->withTimestamps()
            ->withPivot('status', 'check_in_time');
    }

    /* ---------------------------
     |  Accessors / Mutators
     --------------------------- */

    // Format event date
    public function getFormattedDateAttribute()
    {
        return $this->event_date
            ? date('l, d M Y', strtotime($this->event_date))
            : null;
    }

    // Full address
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

    // Whether event is past
    public function getIsPastAttribute()
    {
        return $this->event_date && $this->event_date < now()->toDateString();
    }

    /* ---------------------------
     |  Scopes
     --------------------------- */

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming')
            ->where('event_date', '>=', now()->toDateString());
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
    public function attendances()
{
    return $this->hasMany(\App\Models\EventAttendance::class, 'event_id');
}

public function invitations()
{
    return $this->hasMany(EventInvitation::class);
}

}
