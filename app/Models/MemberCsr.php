<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberCsr extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'chapter_id',
        'event_id',
        'csr_title',
        'csr_description',
        'csr_type',
        'amount_spent',
        'volunteer_hours',
        'beneficiary_name',
        'beneficiaries_count',
        'csr_date',
        'location',
        'proof_document',
        'proof_photo',
        'status',
        'approved_by',
        'approved_at',
        'created_by',
    ];

    protected $casts = [
        'amount_spent' => 'decimal:2',
        'csr_date' => 'date',
        'approved_at' => 'datetime',
    ];

    // 🔗 Relationships
    public function member() { return $this->belongsTo(User::class, 'member_id'); }
    public function chapter() { return $this->belongsTo(Chapter::class); }
    public function event() { return $this->belongsTo(Event::class); }
    public function approver() { return $this->belongsTo(User::class, 'approved_by'); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }

    // 🧮 Accessors
    public function getImpactSummaryAttribute()
    {
        $impact = [];
        if ($this->amount_spent) $impact[] = '₹' . number_format($this->amount_spent, 2);
        if ($this->volunteer_hours) $impact[] = $this->volunteer_hours . ' hrs';
        if ($this->beneficiaries_count) $impact[] = $this->beneficiaries_count . ' beneficiaries';
        return implode(' • ', $impact);
    }

    public function getProofUrlAttribute()
    {
        return $this->proof_document ? asset('storage/' . $this->proof_document) : null;
    }
}
