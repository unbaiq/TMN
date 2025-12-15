<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberBasicInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'full_name', 'gender', 'date_of_birth', 'photo',
        'contact_mobile', 'contact_whatsapp', 'contact_office', 'email',
        'linkedin', 'social_links', 'bni_chapter_name', 'bni_chapter_role',
        'membership_id', 'date_joined', 'membership_renewal_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
