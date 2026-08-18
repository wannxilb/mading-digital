<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SiswaProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_siswa_can_access_profile_edit_page(): void
    {
        $siswa = User::factory()->create(['role' => 'siswa']);

        $this->actingAs($siswa)->get('/siswa/profil')->assertOk();
    }

    public function test_guest_cannot_access_profile_page(): void
    {
        $this->get('/siswa/profil')->assertRedirect('/admin/login');
    }

    public function test_siswa_can_update_name(): void
    {
        $siswa = User::factory()->create(['role' => 'siswa', 'name' => 'Nama Lama']);

        $this->actingAs($siswa)->put('/siswa/profil', [
            'name' => 'Nama Baru',
        ])->assertRedirect();

        $this->assertDatabaseHas('users', ['id' => $siswa->id, 'name' => 'Nama Baru']);
    }

    public function test_siswa_can_change_password(): void
    {
        $siswa = User::factory()->create(['role' => 'siswa']);

        $this->actingAs($siswa)->put('/siswa/profil', [
            'name' => $siswa->name,
            'current_password' => 'password',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ])->assertRedirect();

        $siswa->refresh();
        $this->assertTrue(Hash::check('newpassword123', $siswa->password));
    }

    public function test_siswa_cannot_change_password_with_wrong_current_password(): void
    {
        $siswa = User::factory()->create(['role' => 'siswa']);

        $this->actingAs($siswa)->put('/siswa/profil', [
            'name' => $siswa->name,
            'current_password' => 'wrongpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ])->assertSessionHasErrors('current_password');
    }

    public function test_admin_cannot_access_siswa_profile_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get('/siswa/profil')->assertForbidden();
    }
}
