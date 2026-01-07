<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactQuery extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'source',
        'ip_address',
        'status',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /* ========= STATUS HELPERS ========= */

    public function markInProgress()
    {
        $this->update(['status' => 'in_progress']);
    }

    public function markResolved()
    {
        $this->update(['status' => 'resolved']);
    }
}
