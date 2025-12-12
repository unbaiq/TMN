<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MemberDetail extends Model
{
    use HasFactory;

    protected $table = 'member_details';

    protected $fillable = [
        'user_id',
        'business_name',
        'address',
        'city',
        'pincode',
        'phone',
        'referral_code',
    ];

    protected $casts = [
        'user_id' => 'integer',
    ];

    // Relationship: Each member detail belongs to a single user (member UID)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
