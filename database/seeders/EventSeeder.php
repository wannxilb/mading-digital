<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@mading.sch.id')->value('id');

        $events = [
            [
                'title' => 'Upacara Bendera 17 Agustus',
                'description' => 'Upacara memperingati Hari Kemerdekaan RI di lapangan sekolah. Seluruh siswa diwajibkan mengenakan seragam putih-putih.',
                'location' => 'Lapangan Sekolah',
                'event_date' => now()->addDays(3)->toDateString(),
                'start_time' => '07:00',
                'end_time' => '09:00',
                'organizer' => 'OSIS',
                'created_by' => $admin,
            ],
            [
                'title' => 'Pekan Seni dan Kreativitas',
                'description' => 'Perayaan seni siswa: musik, tari, puisi, dan pameran karya. Terbuka untuk seluruh siswa dari kelas X hingga XII.',
                'location' => 'Aula & Halaman Sekolah',
                'event_date' => now()->addDays(8)->toDateString(),
                'start_time' => '08:00',
                'end_time' => '15:00',
                'organizer' => 'OSIS & Ekskul Seni',
                'created_by' => $admin,
            ],
            [
                'title' => 'Ujian Tengah Semester Genap',
                'description' => 'Pelaksanaan ujian tengah semester untuk seluruh tingkatan. Silakan persiapkan diri dan patuhi jadwal yang dibagikan.',
                'location' => 'Ruang Kelas',
                'event_date' => now()->addDays(16)->toDateString(),
                'start_time' => '07:30',
                'end_time' => null,
                'organizer' => 'Bidang Akademik',
                'created_by' => $admin,
            ],
            [
                'title' => 'Jalan Sehat & Bazar Sekolah',
                'description' => 'Kegiatan jalan sehat dilanjutkan bazar kuliner hasil karya siswa. Ajak orang tua untuk hadir!',
                'location' => 'Rute Seputar Sekolah',
                'event_date' => now()->addDays(24)->toDateString(),
                'start_time' => '06:00',
                'end_time' => '12:00',
                'organizer' => 'Panitia HUT Sekolah',
                'created_by' => $admin,
            ],
            [
                'title' => 'Pertandingan Futsal Antar Kelas',
                'description' => 'Kompetisi futsal antar kelas untuk memperebutkan piala bergilir kepala sekolah.',
                'location' => 'Lapangan Futsal',
                'event_date' => now()->subDays(5)->toDateString(),
                'start_time' => '13:00',
                'end_time' => '17:00',
                'organizer' => 'Ekskul Futsal',
                'created_by' => $admin,
            ],
            [
                'title' => 'Kegiatan Bakti Sosial ke Panti Asuhan',
                'description' => 'Penggalangan dan penyerahan donasi untuk panti asuhan. Terbuka untuk partisipasi seluruh warga sekolah.',
                'location' => 'Panti Asuhan Harapan Kita',
                'event_date' => now()->subDays(12)->toDateString(),
                'start_time' => '08:00',
                'end_time' => '14:00',
                'organizer' => 'OSIS',
                'created_by' => $admin,
            ],
        ];

        foreach ($events as $event) {
            Event::updateOrCreate(['title' => $event['title']], $event);
        }
    }
}
