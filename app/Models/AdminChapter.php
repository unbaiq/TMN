<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminChapter extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'chapters';

    protected $fillable = [
        'chapter_code',
        'name',
        'slug',
        'description',
        'city',
        'state',
        'country',
        'pincode',
        'is_active',
        'order_no',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /*
     |--------------------------------------------------------------------------
     | Scopes (Admin Filtering)
     |--------------------------------------------------------------------------
     */

    // Filter by active/inactive
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    // Sort chapters by display order (ascending)
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_no', 'asc');
    }

    // Search Chapter by name, city, state, or code
    public function scopeSearch($query, $keyword)
    {
        if (!$keyword) return $query;

        return $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhere('chapter_code', 'like', "%{$keyword}%")
              ->orWhere('city', 'like', "%{$keyword}%")
              ->orWhere('state', 'like', "%{$keyword}%");
        });
    }

    /*
     |--------------------------------------------------------------------------
     | Accessors & Mutators
     |--------------------------------------------------------------------------
     */

    // Slug auto-generation (optional)
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;

        if (!isset($this->attributes['slug']) || empty($this->attributes['slug'])) {
            $this->attributes['slug'] = strtolower(str_replace(' ', '-', $value));
        }
    }

    // Helpful label
    public function getFullLocationAttribute()
    {
        return trim(($this->city ? $this->city . ', ' : '') . ($this->state ?? ''));
    }
}
