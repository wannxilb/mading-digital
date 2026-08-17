<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    /** @use HasFactory<AchievementFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'student_name',
        'class',
        'competition_name',
        'competition_level',
        'rank',
        'description',
        'image',
        'achievement_date',
    ];

    public const LEVELS = [
        'sekolah' => 'Sekolah',
        'kecamatan' => 'Kecamatan',
        'kabupaten' => 'Kabupaten/Kota',
        'provinsi' => 'Provinsi',
        'nasional' => 'Nasional',
        'internasional' => 'Internasional',
    ];

    protected function casts(): array
    {
        return [
            'achievement_date' => 'date',
        ];
    }

    public function getLevelLabelAttribute(): string
    {
        return self::LEVELS[$this->competition_level] ?? $this->competition_level;
    }

    public function getDateLabelAttribute(): string
    {
        return $this->achievement_date
            ? $this->achievement_date->translatedFormat('d M Y')
            : $this->created_at->translatedFormat('d M Y');
    }
}
