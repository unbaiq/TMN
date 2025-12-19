<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class User extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable, CanResetPasswordTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ────────────────────────────────
    // 🔗 RELATIONSHIPS
    // ────────────────────────────────

    public function basicInfo()
    {
        return $this->hasOne(MemberBasicInfo::class);
    }

    public function businessInfo()
    {
        return $this->hasOne(MemberBusinessInfo::class);
    }

    public function networkingData()
    {
        return $this->hasOne(MemberNetworkingData::class);
    }

    public function relationshipIntelligence()
    {
        return $this->hasOne(MemberRelationshipIntelligence::class);
    }

    public function supportingData()
    {
        return $this->hasOne(MemberSupportingData::class);
    }

    public function adminData()
    {
        return $this->hasOne(MemberAdminData::class);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function invitationsGiven()
    {
        return $this->hasMany(EventInvitation::class, 'inviter_id');
    }

    public function businessesGiven()
    {
        return $this->hasMany(BusinessGiveTake::class, 'giver_id');
    }

    public function businessesTaken()
    {
        return $this->hasMany(BusinessGiveTake::class, 'taker_id');
    }

    // ────────────────────────────────
    // 🔐 PASSWORD RESET SUPPORT
    // ────────────────────────────────

    /**
     * Get the email address where password reset links are sent.
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    /**
     * Send the password reset notification (customizable).
     */
    public function sendPasswordResetNotification($token)
    {
        $resetUrl = url(route('password.reset', ['token' => $token, 'email' => $this->email], false));

        $this->notify(new \App\Notifications\ResetPasswordNotification($resetUrl));
    }

    // ────────────────────────────────
    // ⚙️ ROLE HELPERS (optional but useful)
    // ────────────────────────────────

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isMember()
    {
        return $this->role === 'member';
    }

    public function isPartner()
    {
        return $this->role === 'partner';
    }






}
