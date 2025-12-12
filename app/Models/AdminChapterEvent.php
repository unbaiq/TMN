<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminChapterEvent extends Model
{
    use HasFactory;

    protected $table = 'chapter_events';

    protected $fillable = [
        'chapter_id',
        'event_id',
        'title',
        'event_date',
        'event_time',
        'venue',
        'is_active',
    ];

    protected $casts = [
        'event_date' => 'date',
        'event_time' => 'datetime:H:i',
        'is_active'  => 'boolean',
    ];

    /*
     |--------------------------------------------------------------------------
     | Relationships
     |--------------------------------------------------------------------------
     */

    // Chapter → belongs to a Chapter
    public function chapter()
    {
        return $this->belongsTo(AdminChapter::class, 'chapter_id');
    }

    // Optional link to global Event
    public function event()
    {
        return $this->belongsTo(AdminEvents::class, 'event_id');
    }

    // Event attendees
    public function attendees()
    {
        return $this->hasMany(EventAttendee::class, 'chapter_event_id');
    }

    /*
     |--------------------------------------------------------------------------
     | Scopes
     |--------------------------------------------------------------------------
     */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString())
                     ->orderBy('event_date', 'asc');
    }

    public function scopeSearch($query, $keyword)
    {
        if (!$keyword) return $query;

        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('venue', 'like', "%{$keyword}%");
        });
    }

    /*
     |--------------------------------------------------------------------------
     | Accessors
     |--------------------------------------------------------------------------
     */

    public function getFormattedDateAttribute()
    {
        return $this->event_date ? $this->event_date->format('d M Y') : null;
    }

    public function getFormattedTimeAttribute()
    {
        return $this->event_time ? $this->event_time->format('h:i A') : null;
    }
}
