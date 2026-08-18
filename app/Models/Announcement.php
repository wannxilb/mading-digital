<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    /** @use HasFactory<AnnouncementFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'priority',
        'start_date',
        'end_date',
        'is_pinned',
        'status',
        'review_note',
        'created_by',
    ];

    public const PRIORITY_NORMAL = 'normal';

    public const PRIORITY_PENTING = 'penting';

    public const PRIORITY_MENDESAK = 'mendesak';

    public const PRIORITIES = [
        self::PRIORITY_NORMAL => 'Normal',
        self::PRIORITY_PENTING => 'Penting',
        self::PRIORITY_MENDESAK => 'Mendesak',
    ];

    public const STATUS_AKTIF = 'aktif';

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PENDING = 'pending';

    public const STATUS_ARSIP = 'arsip';

    public const STATUSES = [
        self::STATUS_AKTIF => 'Aktif',
        self::STATUS_DRAFT => 'Draft',
        self::STATUS_PENDING => 'Menunggu Review',
        self::STATUS_ARSIP => 'Arsip',
    ];

    protected function casts(): array
    {
        return [
            'is_pinned' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_AKTIF);
    }

    public function scopePendingReview(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeWithinDateWindow(Builder $query): Builder
    {
        return $query
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhereDate('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhereDate('end_date', '>=', now());
            });
    }

    public function getPriorityLabelAttribute(): string
    {
        return self::PRIORITIES[$this->priority] ?? $this->priority;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->end_date?->isBefore(now()) ?? false;
    }
}
