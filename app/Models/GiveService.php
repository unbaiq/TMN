<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiveService extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'give_services';

    protected $fillable = [
        'giver_member_id',
        'receiver_member_id',
        'service_title',
        'description',
        'fee',
        'status',
    ];

    protected $casts = [
        'fee' => 'decimal:2',
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
     * Member who is giving the service.
     */
    public function giver()
    {
        return $this->belongsTo(User::class, 'giver_member_id');
    }

    /**
     * Member who accepts / receives the service.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_member_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes (filters)
    |--------------------------------------------------------------------------
    */

    /**
     * Only open services.
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Accepted services.
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Completed services.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Cancelled services.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Full search over giver/receiver names + service title.
     */
    public function scopeSearch($query, $keyword)
    {
        if (!$keyword) return $query;

        return $query->where(function ($q) use ($keyword) {
            $q->where('service_title', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%")
              ->orWhereHas('giver',  function ($giver) use ($keyword) {
                   $giver->where('name', 'like', "%{$keyword}%");
              })
              ->orWhereHas('receiver', function ($rec) use ($keyword) {
                   $rec->where('name', 'like', "%{$keyword}%");
              });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFeeFormattedAttribute()
    {
        return $this->fee ? number_format($this->fee, 2) : '0.00';
    }

    public function getIsOpenAttribute(): bool
    {
        return $this->status === 'open';
    }

    public function getIsAcceptedAttribute(): bool
    {
        return $this->status === 'accepted';
    }

    public function getIsCompletedAttribute(): bool
    {
        return $this->status === 'completed';
    }

    public function getIsCancelledAttribute(): bool
    {
        return $this->status === 'cancelled';
    }

    /*
    |--------------------------------------------------------------------------
    | Business Logic
    |--------------------------------------------------------------------------
    */

    /**
     * Assign a receiver (member accepts the service).
     */
    public function accept(int $receiverId)
    {
        $this->update([
            'receiver_member_id' => $receiverId,
            'status' => 'accepted',
        ]);
    }

    /**
     * Mark as completed.
     */
    public function complete()
    {
        $this->update(['status' => 'completed']);
    }

    /**
     * Cancel the service.
     */
    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
    }
}
