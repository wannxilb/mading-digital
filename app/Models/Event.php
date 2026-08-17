<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'event_date',
        'start_time',
        'end_time',
        'organizer',
        'poster',
        'status',
        'created_by',
    ];

    public const STATUS_AKAN_DATANG = 'akan_datang';

    public const STATUS_BERLANGSUNG = 'berlangsung';

    public const STATUS_SELESAI = 'selesai';

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->whereDate('event_date', '>=', now()->toDateString());
    }

    public function scopePast(Builder $query): Builder
    {
        return $query->whereDate('event_date', '<', now()->toDateString());
    }

    public function getStatusLabelAttribute(): string
    {
        return match (true) {
            $this->event_date->isBefore(now()->toDateString()) => 'Selesai',
            $this->event_date->isToday() => 'Berlangsung',
            default => 'Akan Datang',
        };
    }

    public function getDateLabelAttribute(): string
    {
        return $this->event_date->translatedFormat('d M Y');
    }

    public function getTimeLabelAttribute(): string
    {
        if (! $this->start_time) {
            return '';
        }

        return $this->end_time
            ? $this->start_time->format('H.i').' — '.$this->end_time->format('H.i')
            : $this->start_time->format('H.i');
    }
}
