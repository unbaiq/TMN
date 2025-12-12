<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminEvent extends Model
{
    use HasFactory;

    // Use the "events" table
    protected $table = 'events';

    protected $fillable = [
        'title',
        'description',
        'location',
        'starts_at',
        'ends_at',
        'capacity',
        'status',
        'poster_path',
        'created_by',
    ];

    protected $casts = [
        'starts_at'  => 'datetime',
        'ends_at'    => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Admin filters
    public function scopeSearch($query, $keyword)
    {
        if (!$keyword) return $query;

        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%$keyword%")
              ->orWhere('location', 'like', "%$keyword%")
              ->orWhere('description', 'like', "%$keyword%");
        });
    }

    public function scopeStatus($query, $status)
    {
        if (!$status) return $query;

        return $query->where('status', $status);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('starts_at', '>=', now())->orderBy('starts_at', 'asc');
    }

    // Relationship with admin user
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
