<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'meeting_type',
        'title',
        'agenda',
        'meeting_date',
        'meeting_time',
        'venue',
        'chapter_id',
        'key_discussion_points',
        'outcomes',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'member_meeting_participants')
            ->withPivot('attended')
            ->withTimestamps();
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('meeting_type', $type);
    }
}
