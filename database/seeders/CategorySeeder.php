<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Pengumuman', 'slug' => 'pengumuman', 'icon' => 'megaphone', 'description' => 'Informasi penting dari sekolah untuk seluruh warga sekolah.'],
            ['name' => 'Prestasi', 'slug' => 'prestasi', 'icon' => 'trophy', 'description' => 'Kabar membanggakan dari siswa dan guru.'],
            ['name' => 'Kegiatan', 'slug' => 'kegiatan', 'icon' => 'calendar', 'description' => 'Agenda dan momen seru sepanjang perjalanan sekolah.'],
            ['name' => 'Karya & Kreativitas', 'slug' => 'karya', 'icon' => 'palette', 'description' => 'Ruang untuk menampilkan karya dan ide kreatif siswa.'],
            ['name' => 'Cerita Sekolah', 'slug' => 'cerita', 'icon' => 'book', 'description' => 'Kisah perjalanan, pengalaman, dan refleksi warga sekolah.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
