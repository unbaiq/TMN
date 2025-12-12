<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberAward extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'member_awards';

    protected $fillable = [
        'member_id',
        'title',
        'category',
        'description',
        'award_event',
        'award_date',
        'certificate_file',
        'trophy_image',
        'given_by',
        'given_by_role',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'award_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Member who receives the award.
     */
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    /**
     * User (admin/chapter) who gave the award.
     */
    public function giver()
    {
        return $this->belongsTo(User::class, 'given_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes (Filters)
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
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
              ->orWhere('award_event', 'like', "%{$keyword}%")
              ->orWhereHas('member', function ($m) use ($keyword) {
                  $m->where('name', 'like', "%{$keyword}%");
              });
        });
    }

    public function scopeAwardedBetween($query, $from = null, $to = null)
    {
        if ($from) $query->where('award_date', '>=', $from);
        if ($to)   $query->where('award_date', '<=', $to);
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

    public function getTrophyUrlAttribute()
    {
        return $this->trophy_image
            ? asset('storage/' . $this->trophy_image)
            : null;
    }

    public function getGivenByLabelAttribute()
    {
        return ucfirst($this->given_by_role ?? 'Admin');
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

    public function archive()
    {
        $this->update(['status' => 'archived']);
        return $this;
    }
}
