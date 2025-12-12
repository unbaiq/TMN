<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MemberCsr
 *
 * Represents CSR projects created by members or admins.
 *
 * @property int $id
 * @property int|null $member_id
 * @property int|null $created_by
 * @property string $creator_role
 * @property string $title
 * @property string|null $slug
 * @property string|null $category
 * @property string|null $description
 * @property float $amount
 * @property string $currency
 * @property int|null $chapter_id
 * @property \Illuminate\Support\Carbon|null $date
 * @property array|null $documents
 * @property array|null $report_files
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
class MemberCsr extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'member_csrs';

    protected $fillable = [
        'member_id',
        'created_by',
        'creator_role',
        'title',
        'slug',
        'category',
        'description',
        'amount',
        'currency',
        'chapter_id',
        'date',
        'documents',
        'report_files',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'date'         => 'date',
        'documents'    => 'array',
        'report_files' => 'array',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
        'deleted_at'   => 'datetime',
    ];

    /**
     * Boot: ensure slug when saving if not provided.
     */
    protected static function booted()
    {
        static::saving(function (MemberCsr $model) {
            if (empty($model->slug) && ! empty($model->title)) {
                $model->slug = static::generateSlug($model->title);
            }
        });
    }

    /**
     * Generate a URL-friendly unique slug (basic).
     */
    public static function generateSlug(string $title): string
    {
        $base = \Str::slug(substr($title, 0, 200));
        $slug = $base;
        $i = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Member who offers the CSR (nullable).
     */
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    /**
     * User who created the CSR record (admin/member/partner).
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Chapter the CSR belongs to (nullable).
     */
    public function chapter()
    {
        return $this->belongsTo(AdminChapter::class, 'chapter_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Search by title, description, category, or member name/email.
     */
    public function scopeSearch($query, ?string $keyword)
    {
        if (! $keyword) return $query;

        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%")
              ->orWhere('category', 'like', "%{$keyword}%")
              ->orWhereHas('member', function ($m) use ($keyword) {
                  $m->where('name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
              });
        });
    }

    /**
     * Filter by category.
     */
    public function scopeCategory($query, ?string $category)
    {
        if (! $category) return $query;
        return $query->where('category', $category);
    }

    /**
     * CSR created by a specific creator role (admin, member, partner).
     */
    public function scopeCreatorRole($query, ?string $role)
    {
        if (! $role) return $query;
        return $query->where('creator_role', $role);
    }

    /**
     * For a specific chapter.
     */
    public function scopeForChapter($query, ?int $chapterId)
    {
        if (! $chapterId) return $query;
        return $query->where('chapter_id', $chapterId);
    }

    /**
     * For a specific member.
     */
    public function scopeForMember($query, ?int $memberId)
    {
        if (! $memberId) return $query;
        return $query->where('member_id', $memberId);
    }

    /**
     * CSR within a date range.
     */
    public function scopeBetweenDates($query, $from = null, $to = null)
    {
        if ($from) $query->where('date', '>=', $from);
        if ($to)   $query->where('date', '<=', $to);
        return $query;
    }

    /**
     * Order by newest first (by date then created_at).
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('date', 'desc')->orderBy('created_at', 'desc');
    }

    /*
    |--------------------------------------------------------------------------
    | Mutators / Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Normalize amount on set (ensure numeric).
     */
    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = $value === null ? 0 : number_format((float)$value, 2, '.', '');
    }

    /**
     * Documents array accessor helper (safe array).
     */
    public function getDocumentsArrayAttribute(): array
    {
        return is_array($this->documents) ? $this->documents : ([] === $this->documents ? [] : (array) $this->documents);
    }

    /**
     * Report files array accessor helper.
     */
    public function getReportFilesArrayAttribute(): array
    {
        return is_array($this->report_files) ? $this->report_files : ([] === $this->report_files ? [] : (array) $this->report_files);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers / Business Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Attach a document path to the documents JSON column.
     * $path should be the storage path returned by ->store()
     */
    public function attachDocument(string $path): self
    {
        $docs = $this->documents ?: [];
        if (! is_array($docs)) $docs = (array) $docs;
        $docs[] = $path;
        $this->documents = array_values($docs);
        $this->save();

        return $this;
    }

    /**
     * Attach a report file path to the report_files JSON column.
     */
    public function attachReportFile(string $path): self
    {
        $files = $this->report_files ?: [];
        if (! is_array($files)) $files = (array) $files;
        $files[] = $path;
        $this->report_files = array_values($files);
        $this->save();

        return $this;
    }

    /**
     * Convenience readable amount with currency.
     */
    public function getAmountWithCurrencyAttribute(): string
    {
        $currency = $this->currency ?? 'INR';
        $amount = $this->amount ? number_format((float)$this->amount, 2) : '0.00';
        return "{$currency} {$amount}";
    }
}
