<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberRecognition extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'member_recognitions';

    protected $fillable = [
        'member_id',
        'title',
        'category',
        'description',
        'certificate_file',
        'badge_image',
        'given_by',
        'given_by_role',
        'recognized_at',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'recognized_at' => 'date',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
        'deleted_at'    => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Member who received the recognition.
     */
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    /**
     * Admin/chapter user who awarded this recognition.
     */
    public function giver()
    {
        return $this->belongsTo(User::class, 'given_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes (Admin Filtering)
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeCategory($query, ?string $category)
    {
        if (!$category) return $query;

        return $query->where('category', $category);
    }

    public function scopeSearch($query, ?string $keyword)
    {
        if (!$keyword) return $query;

        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('category', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%")
              ->orWhereHas('member', function ($m) use ($keyword) {
                  $m->where('name', 'like', "%{$keyword}%");
              });
        });
    }

    public function scopeRecognizedBetween($query, $from = null, $to = null)
    {
        if ($from) $query->where('recognized_at', '>=', $from);
        if ($to)   $query->where('recognized_at', '<=', $to);

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getCertificateUrlAttribute()
    {
        return $this->certificate_file
            ? asset('storage/' . $this->certificate_file)
            : null;
    }

    public function getBadgeUrlAttribute()
    {
        return $this->badge_image
            ? asset('storage/' . $this->badge_image)
            : null;
    }

    /*
    |--------------------------------------------------------------------------
    | Status Helpers
    |--------------------------------------------------------------------------
    */

    public function activate()
    {
        $this->update(['status' => 'active']);
        return $this;
    }

    public function deactivate()
    {
        $this->update(['status' => 'inactive']);
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Role Helpers
    |--------------------------------------------------------------------------
    */

    public function getGivenByLabelAttribute()
    {
        return ucfirst($this->given_by_role ?? 'Admin');
    }
}
