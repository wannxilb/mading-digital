<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_accessible(): void
    {
        $this->get('/admin/login')->assertOk();
    }

    public function test_failed_login_redirects_back_with_errors(): void
    {
        $this->from('/admin/login')
            ->post('/admin/login', ['email' => 'admin@example.com', 'password' => 'salah'])
            ->assertRedirect('/admin/login')
            ->assertSessionHasErrors('email');
    }

    public function test_admin_login_redirects_to_dashboard(): void
    {
        User::factory()->create(['email' => 'admin@mading.sch.id', 'role' => 'admin']);

        $this->post('/admin/login', ['email' => 'admin@mading.sch.id', 'password' => 'password'])
            ->assertRedirect('/admin');
    }

    public function test_student_login_redirects_to_dashboard(): void
    {
        User::factory()->create(['email' => 'siswa@example.com', 'role' => 'siswa']);

        $this->from('/admin/login')
            ->post('/admin/login', ['email' => 'siswa@example.com', 'password' => 'password'])
            ->assertRedirect('/siswa');

        $this->assertAuthenticated();
    }

    public function test_teacher_login_redirects_to_dashboard(): void
    {
        User::factory()->create(['email' => 'guru@example.com', 'role' => 'guru']);

        $this->from('/admin/login')
            ->post('/admin/login', ['email' => 'guru@example.com', 'password' => 'password'])
            ->assertRedirect('/guru');

        $this->assertAuthenticated();
    }

    public function test_guest_is_redirected_to_login_on_admin_routes(): void
    {
        foreach (['/admin', '/admin/berita', '/admin/berita/baru', '/admin/artikel', '/admin/pengumuman', '/admin/agenda', '/admin/prestasi', '/admin/kategori', '/admin/pengguna'] as $path) {
            $this->get($path)->assertRedirect('/admin/login');
        }
    }

    public function test_student_gets_forbidden_on_every_admin_route(): void
    {
        $student = User::factory()->create(['role' => 'siswa']);

        foreach (['/admin', '/admin/berita', '/admin/berita/baru', '/admin/artikel', '/admin/pengumuman', '/admin/agenda', '/admin/prestasi', '/admin/kategori', '/admin/pengguna'] as $path) {
            $this->actingAs($student)->get($path)->assertForbidden();
        }
    }

    public function test_admin_can_access_all_admin_pages(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        foreach (['/admin', '/admin/berita', '/admin/berita/baru', '/admin/artikel', '/admin/artikel/baru', '/admin/pengumuman', '/admin/pengumuman/baru', '/admin/agenda', '/admin/agenda/baru', '/admin/prestasi', '/admin/prestasi/baru', '/admin/kategori', '/admin/pengguna', '/admin/pengguna/baru'] as $path) {
            $this->actingAs($admin)->get($path)->assertOk();
        }
    }

    public function test_logout_redirects_to_home(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post('/admin/logout')
            ->assertRedirect('/');
    }

    public function test_non_admin_can_logout_from_public_route(): void
    {
        $student = User::factory()->create(['role' => 'siswa']);

        $this->actingAs($student)
            ->post('/logout')
            ->assertRedirect('/');

        $this->assertGuest();
    }
}
