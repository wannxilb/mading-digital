<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Akademik', 'slug' => 'akademik', 'icon' => 'book', 'description' => 'Informasi seputar pembelajaran, ujian, dan kegiatan akademik.'],
            ['name' => 'Kegiatan Sekolah', 'slug' => 'kegiatan', 'icon' => 'calendar', 'description' => 'Agenda dan momen seru sepanjang perjalanan sekolah.'],
            ['name' => 'OSIS', 'slug' => 'osis', 'icon' => 'users', 'description' => 'Kabar dari organisasi siswa intra sekolah.'],
            ['name' => 'Ekstrakurikuler', 'slug' => 'ekstrakurikuler', 'icon' => 'activity', 'description' => 'Informasi kegiatan pengembangan minat dan bakat siswa.'],
            ['name' => 'Prestasi', 'slug' => 'prestasi', 'icon' => 'trophy', 'description' => 'Kabar membanggakan dari siswa dan guru.'],
            ['name' => 'Teknologi', 'slug' => 'teknologi', 'icon' => 'sparkle', 'description' => 'Kabar seputar teknologi, robotik, dan literasi digital.'],
            ['name' => 'Seni', 'slug' => 'seni', 'icon' => 'palette', 'description' => 'Ruang apresiasi seni, musik, dan kreativitas.'],
            ['name' => 'Olahraga', 'slug' => 'olahraga', 'icon' => 'chart', 'description' => 'Perkembangan cabang olahraga dan kompetisi siswa.'],
            ['name' => 'Pendidikan', 'slug' => 'pendidikan', 'icon' => 'megaphone', 'description' => 'Pengumuman penting dan informasi resmi sekolah.'],
            ['name' => 'Karya Siswa', 'slug' => 'karya', 'icon' => 'pen', 'description' => 'Ruang untuk menampilkan karya dan tulisan siswa.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
