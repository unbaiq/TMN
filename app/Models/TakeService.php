<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TakeService
 *
 * @property int $id
 * @property int $taker_member_id
 * @property string|null $giver_name
 * @property int|null $giver_member_id
 * @property string $service_name
 * @property string|null $phone
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $service_date
 * @property string|null $description
 * @property string|null $attachment
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class TakeService extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'take_services';

    protected $fillable = [
        'taker_member_id',
        'giver_name',
        'giver_member_id',
        'service_name',
        'phone',
        'email',
        'service_date',
        'description',
        'attachment',
        'status',
    ];

    protected $casts = [
        'service_date' => 'date',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
        'deleted_at'   => 'datetime',
    ];

    /**
     * Relationships
     */

    /**
     * Member who requested the service (taker).
     */
    public function taker()
    {
        return $this->belongsTo(User::class, 'taker_member_id');
    }

    /**
     * Optional linked giver as a user (when present).
     */
    public function giverMember()
    {
        return $this->belongsTo(User::class, 'giver_member_id');
    }

    /**
     * Scopes
     */

    /**
     * Filter by status (Requested, Received, Cancelled).
     */
    public function scopeStatus($query, ?string $status)
    {
        if (!$status) {
            return $query;
        }
        return $query->where('status', $status);
    }

    /**
     * Recent first
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * For a specific taker (member)
     */
    public function scopeForTaker($query, $memberId)
    {
        return $query->where('taker_member_id', $memberId);
    }

    /**
     * For a specific giver (member id)
     */
    public function scopeForGiver($query, $giverId)
    {
        return $query->where('giver_member_id', $giverId);
    }

    /*
     |--------------------------------------------------------------------------
     | Accessors & Mutators
     |--------------------------------------------------------------------------
     */

    /**
     * Return full URL for attachment (or null).
     */
    public function getAttachmentUrlAttribute()
    {
        if (empty($this->attachment)) {
            return null;
        }

        // assumes files are stored on the 'public' disk (storage/app/public)
        return asset('storage/' . $this->attachment);
    }

    /**
     * Normalize phone when set (strip non-digit characters).
     */
    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = $value ? preg_replace('/\D+/', '', $value) : null;
    }

    /*
     |--------------------------------------------------------------------------
     | Business helpers
     |--------------------------------------------------------------------------
     */

    /**
     * Mark as Received.
     *
     * @return $this
     */
    public function markReceived()
    {
        $this->status = 'Received';
        $this->save();

        return $this;
    }

    /**
     * Cancel the request.
     *
     * @return $this
     */
    public function cancel()
    {
        $this->status = 'Cancelled';
        $this->save();

        return $this;
    }

    /**
     * Assign a giver by user id and switch giver_name accordingly.
     *
     * @param  int|null  $giverMemberId
     * @return $this
     */
    public function assignGiverById(?int $giverMemberId)
    {
        if ($giverMemberId) {
            $user = User::find($giverMemberId);
            $this->giver_member_id = $giverMemberId;
            $this->giver_name = $user ? $user->name : $this->giver_name;
        } else {
            $this->giver_member_id = null;
        }
        $this->save();

        return $this;
    }

    /**
     * Assign giver by free-text name (useful if frontend sends a name).
     *
     * @param string $name
     * @return $this
     */
    public function assignGiverByName(string $name)
    {
        $this->giver_name = $name;
        $this->save();

        return $this;
    }
}
