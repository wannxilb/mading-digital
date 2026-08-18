<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserImportTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    public function test_import_page_is_accessible(): void
    {
        $this->actingAs($this->admin())->get('/admin/pengguna/import')->assertOk();
    }

    public function test_guest_cannot_access_import_page(): void
    {
        $this->get('/admin/pengguna/import')->assertRedirect('/admin/login');
    }

    public function test_import_creates_users_from_valid_csv(): void
    {
        $csv = "nis,nama,kelas,jurusan,password\n".
            "2026001,Andi Saputra,10 PPLG 1,rpl,andi12345\n".
            "2026002,Budi Santoso,12 RPL 2,rpl,budi12345\n";

        $file = UploadedFile::fake()->createWithContent('siswa.csv', $csv);

        $this->actingAs($this->admin())
            ->post('/admin/pengguna/import', ['csv_file' => $file])
            ->assertRedirect('/admin/pengguna');

        $this->assertDatabaseHas('users', ['nis' => '2026001', 'email' => '2026001@mading.sch.id', 'role' => 'siswa', 'jurusan' => 'rpl']);
        $this->assertDatabaseHas('users', ['nis' => '2026002', 'email' => '2026002@mading.sch.id', 'role' => 'siswa', 'jurusan' => 'rpl']);
    }

    public function test_import_skips_duplicate_nis(): void
    {
        User::factory()->create(['nis' => '2026001']);

        $csv = "nis,nama,kelas,jurusan,password\n".
            "2026001,Exist User,X 1,rpl,exist123\n".
            "2026002,New User,X 1,rpl,newuser123\n";

        $file = UploadedFile::fake()->createWithContent('siswa.csv', $csv);

        $this->actingAs($this->admin())
            ->post('/admin/pengguna/import', ['csv_file' => $file])
            ->assertRedirect();

        $this->assertDatabaseHas('users', ['nis' => '2026002', 'role' => 'siswa']);
    }

    public function test_import_rejects_empty_csv(): void
    {
        $csv = "nis,nama,kelas,jurusan,password\n";

        $file = UploadedFile::fake()->createWithContent('empty.csv', $csv);

        $this->actingAs($this->admin())
            ->post('/admin/pengguna/import', ['csv_file' => $file])
            ->assertSessionHasErrors('csv_file');
    }

    public function test_import_rejects_csv_with_missing_columns(): void
    {
        $csv = "nis,nama\n2026001,Andi\n";

        $file = UploadedFile::fake()->createWithContent('bad.csv', $csv);

        $this->actingAs($this->admin())
            ->post('/admin/pengguna/import', ['csv_file' => $file])
            ->assertSessionHasErrors('csv_file');
    }

    public function test_import_rejects_short_password(): void
    {
        $csv = "nis,nama,kelas,jurusan,password\n2026001,Short Pass,X 1,rpl,123\n";

        $file = UploadedFile::fake()->createWithContent('short.csv', $csv);

        $this->actingAs($this->admin())
            ->post('/admin/pengguna/import', ['csv_file' => $file])
            ->assertRedirect();

        $this->assertDatabaseMissing('users', ['nis' => '2026001']);
    }

    public function test_siswa_cannot_access_import_page(): void
    {
        $siswa = User::factory()->create(['role' => 'siswa']);

        $this->actingAs($siswa)->get('/admin/pengguna/import')->assertForbidden();
    }
}
