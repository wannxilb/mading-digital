<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'author',
        'excerpt',
        'body',
        'image',
        'is_published',
        'is_featured',
        'views',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function getDisplayDateAttribute(): string
    {
        return $this->published_at
            ? $this->published_at->translatedFormat('d M Y')
            : $this->created_at->translatedFormat('d M Y');
    }

    public function getHtmlAttribute(): string
    {
        return Cache::remember(
            'post_html_'.$this->id.'_'.$this->updated_at?->timestamp,
            now()->addDays(7),
            fn () => Str::markdown($this->body),
        );
    }
}
