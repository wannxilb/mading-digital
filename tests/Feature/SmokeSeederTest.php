<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmokeSeederTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_pages_render_with_seeded_data(): void
    {
        $pages = [
            '/',
            '/berita',
            '/artikel',
            '/pengumuman',
            '/agenda',
            '/prestasi',
            '/cari?q=robot',
            '/kategori/prestasi',
            '/berita/libur-tengah-semester',
            '/artikel/tips-belajar-efektif-uas',
        ];

        foreach ($pages as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_admin_pages_render_with_seeded_data(): void
    {
        $admin = User::where('email', 'admin@mading.sch.id')->firstOrFail();

        $pages = [
            '/admin',
            '/admin/berita',
            '/admin/artikel',
            '/admin/pengumuman',
            '/admin/agenda',
            '/admin/prestasi',
            '/admin/kategori',
            '/admin/pengguna',
        ];

        foreach ($pages as $path) {
            $this->actingAs($admin)->get($path)->assertOk();
        }
    }
}
