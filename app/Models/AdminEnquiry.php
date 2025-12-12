<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminEnquiry extends Model
{
    use HasFactory;

    // This model uses the SAME TABLE as enquiries
    protected $table = 'enquiries';

    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'profession',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
     |--------------------------------------------------------------------------
     | Admin-specific Query Filters
     |--------------------------------------------------------------------------
     */

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%$keyword%")
              ->orWhere('email', 'like', "%$keyword%")
              ->orWhere('contact_number', 'like', "%$keyword%")
              ->orWhere('profession', 'like', "%$keyword%");
        });
    }

    public function scopeStatus($query, $status)
    {
        if (! in_array($status, ['new', 'in_progress', 'closed'])) {
            return $query;
        }

        return $query->where('status', $status);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }
}
