<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'chapter_code',
        'name',
        'slug',
        'city',
        'pincode',
        'capacity_no',
        'is_active',
        'description',
        'logo',
    ];

    /**
     * Accessor for full logo URL.
     */
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        return asset('images/default-chapter.png'); // fallback image
    }

    /**
     * A chapter can have many members.
     */
    public function members()
    {
        return $this->hasMany(User::class, 'chapter_id');
    }

    public function businessGiveTakes()
{
    return $this->hasMany(BusinessGiveTake::class);
}

    
}
