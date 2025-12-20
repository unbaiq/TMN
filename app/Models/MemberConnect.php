<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberConnect extends Model
{
    use HasFactory;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'user_id',

        // Personal details
        'person_name',
        'designation',

        // Business details
        'company_name',
        'industry',
        'profession',
        'services',
        'website',

        // Contact details
        'contact_phone',
        'contact_email',
        'whatsapp_number',

        // Location & chapter
        'location',
        'chapter_name',

        // Visibility & trust
        'visibility',
        'is_verified',
        'is_active',

        // Engagement
        'recommendation_count',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'is_verified' => 'boolean',
        'is_active'   => 'boolean',
    ];

    /**
     * Default attribute values
     */
    protected $attributes = [
        'visibility'            => 'members',
        'is_verified'           => false,
        'is_active'             => true,
        'recommendation_count'  => 0,
    ];

    /**
     * Relationship: Owner member
     */
    public function member()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope: Only active connects
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Only verified connects
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope: Visibility filter
     */
    public function scopeVisibleToMembers($query)
    {
        return $query->whereIn('visibility', ['members', 'public']);
    }
}
