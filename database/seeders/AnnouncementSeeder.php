<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@mading.sch.id')->value('id');

        $announcements = [
            [
                'title' => 'Pengumuman Libur Tengah Semester',
                'content' => 'Diberitahukan kepada seluruh siswa bahwa libur tengah semester berlangsung mulai tanggal 12 hingga 20 bulan ini. Kegiatan belajar mengajar kembali berjalan pada tanggal 22 bulan ini. Selamat beristirahat dan tetap jaga kesehatan!',
                'priority' => 'penting',
                'start_date' => now()->toDateString(),
                'end_date' => now()->addDays(14)->toDateString(),
                'is_pinned' => true,
                'status' => 'aktif',
                'created_by' => $admin,
            ],
            [
                'title' => 'Penyesuaian Jam Belajar Efektif',
                'content' => 'Mulai pekan depan, jam masuk sekolah bergeser 15 menit lebih awal sebagai penyesuaian jadwal. Mohon perhatikan jadwal terbaru dari wali kelas masing-masing.',
                'priority' => 'mendesak',
                'start_date' => now()->toDateString(),
                'end_date' => now()->addDays(30)->toDateString(),
                'is_pinned' => false,
                'status' => 'aktif',
                'created_by' => $admin,
            ],
            [
                'title' => 'Penyerahan Raport Tengah Semester',
                'content' => 'Penyerahan raport tengah semester dilaksanakan pada hari Sabtu mendatang di ruang kelas masing-masing. Orang tua/wali dipersilakan hadir untuk mengambil raport secara langsung.',
                'priority' => 'normal',
                'start_date' => now()->subDays(2)->toDateString(),
                'end_date' => now()->addDays(7)->toDateString(),
                'is_pinned' => false,
                'status' => 'aktif',
                'created_by' => $admin,
            ],
            [
                'title' => 'Sosialisasi Tertib Lalu Lintas Bagi Siswa',
                'content' => 'Sekolah bekerja sama dengan kepolisian akan mengadakan sosialisasi tertib lalu lintas bagi seluruh siswa. Kehadiran diharapkan penuh dan akan dicatat oleh wali kelas.',
                'priority' => 'normal',
                'start_date' => now()->toDateString(),
                'end_date' => now()->addDays(45)->toDateString(),
                'is_pinned' => false,
                'status' => 'aktif',
                'created_by' => $admin,
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::updateOrCreate(
                ['title' => $announcement['title']],
                $announcement
            );
        }
    }
}
