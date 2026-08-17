<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            [
                'title' => 'Juara 1 OSN Matematika Tingkat Kabupaten',
                'student_name' => 'Dinda Prameswari',
                'class' => 'XI IPA 2',
                'competition_name' => 'Olimpiade Sains Nasional Bidang Matematika',
                'competition_level' => 'kabupaten',
                'rank' => 'Juara 1',
                'description' => 'Berhasil meraih medali emas dan melaju ke tahap provinsi.',
                'achievement_date' => now()->subDays(10)->toDateString(),
            ],
            [
                'title' => 'Juara 2 Kompetisi Robotik Pelajar Tingkat Provinsi',
                'student_name' => 'Tim Robotik (Andi, Bima, Citra)',
                'class' => 'XI IPA 1',
                'competition_name' => 'Kompetisi Robotik Pelajar',
                'competition_level' => 'provinsi',
                'rank' => 'Juara 2',
                'description' => 'Raihan perak pada kategori Robot Penolong setelah bersaing dengan 12 tim lain.',
                'achievement_date' => now()->subDays(20)->toDateString(),
            ],
            [
                'title' => 'Juara 1 Lomba Pidato Bahasa Inggris Tingkat Kecamatan',
                'student_name' => 'Farhan Ramadhan',
                'class' => 'X 1',
                'competition_name' => 'Lomba Pidato Bahasa Inggris',
                'competition_level' => 'kecamatan',
                'rank' => 'Juara 1',
                'description' => 'Membawakan pidato berjudul "The Power of Young Ideas" dengan sangat memukau.',
                'achievement_date' => now()->subDays(35)->toDateString(),
            ],
            [
                'title' => 'Juara 3 Kompetisi Debat Pelajar Tingkat Provinsi',
                'student_name' => 'Rahma & Salsa',
                'class' => 'XI IPA 1 / XI IPS 2',
                'competition_name' => 'Kompetisi Debat Pelajar',
                'competition_level' => 'provinsi',
                'rank' => 'Juara 3',
                'description' => 'Pasangan debater berhasil melaju hingga semifinal dan meraih juara ketiga.',
                'achievement_date' => now()->subDays(45)->toDateString(),
            ],
            [
                'title' => 'Pemenang Lomba Mading Digital Nasional',
                'student_name' => 'Redaksi Mading Sekolah',
                'class' => 'Lintas Kelas',
                'competition_name' => 'Lomba Mading Digital Pelajar',
                'competition_level' => 'nasional',
                'rank' => 'Juara Harapan 1',
                'description' => 'Mading digital sekolah dinobatkan sebagai juara harapan pertama pada tingkat nasional.',
                'achievement_date' => now()->subDays(60)->toDateString(),
            ],
            [
                'title' => 'Juara 1 Lomba Cepat Tepat Sains Tingkat Sekolah',
                'student_name' => 'Tim Sains (Bima, Citra, Nadia)',
                'class' => 'XI IPA 2',
                'competition_name' => 'Lomba Cepat Tepat Sains',
                'competition_level' => 'sekolah',
                'rank' => 'Juara 1',
                'description' => 'Mengalahkan 14 tim lain dalam babak penyisihan hingga final.',
                'achievement_date' => now()->subDays(75)->toDateString(),
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::updateOrCreate(
                ['title' => $achievement['title']],
                $achievement
            );
        }
    }
}
