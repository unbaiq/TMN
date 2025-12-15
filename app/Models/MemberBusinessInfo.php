<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberBusinessInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'company_name', 'company_logo', 'industry', 'business_type',
        'business_description', 'office_address', 'website_url',
        'years_in_business', 'target_clients', 'usp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
