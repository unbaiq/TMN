<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'profession',
        'is_agreed',
        'source',
        'status',
        'membership_token',
        'converted_to_member',
    ];

    protected $casts = [
        'is_agreed' => 'boolean',
        'converted_to_member' => 'boolean',
    ];

    /**
     * Scope to filter only new enquiries
     */
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    /**
     * Scope to filter only converted members
     */
    public function scopeConverted($query)
    {
        return $query->where('converted_to_member', true);
    }

    /**
     * Get the registration link if token exists
     */
    public function getMembershipLinkAttribute()
    {
        return $this->membership_token ? url("/join/{$this->membership_token}") : null;
    }
}
