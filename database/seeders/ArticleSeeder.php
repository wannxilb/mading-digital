<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $cat = fn (string $slug) => Category::where('slug', $slug)->firstOrFail()->id;
        $user = fn (string $email) => User::where('email', $email)->value('id');

        $articles = [
            [
                'category_id' => $cat('akademik'),
                'user_id' => $user('siswa.rahma@mading.sch.id'),
                'title' => 'Tips Belajar Efektif Menghadapi Ujian Akhir Semester',
                'slug' => 'tips-belajar-efektif-uas',
                'author' => 'Rahma (XI IPA 1)',
                'class' => 'XI IPA 1',
                'excerpt' => 'Catatan praktis dari siswa kelas XI tentang cara mengatur strategi belajar tanpa harus begadang semalaman.',
                'body' => "Menghadapi ujian akhir semester sering terasa menegangkan. Namun dengan strategi yang tepat, kalian bisa belajar lebih efektif tanpa mengorbankan waktu tidur.\n\nBerikut beberapa tips yang saya terapkan:\n\n- **Bagi materi kecil-kecil.** Pelajari satu topik per hari, jangan menumpuk semuanya di malam terakhir.\n\n- **Gunakan teknik pomodoro.** Belajar 25 menit, istirahat 5 menit. Ulangi beberapa kali.\n\n- **Aktif menjawab soal latihan.** Mengerjakan soal jauh lebih efektif daripada sekadar membaca ulang catatan.\n\n- **Jaga pola tidur.** Otak justru bekerja lebih baik setelah istirahat yang cukup.\n\nSemoga membantu dan selamat berjuang, teman-teman!",
                'status' => Article::STATUS_PUBLISHED,
                'views' => 145,
                'published_at' => now()->subDays(6),
            ],
            [
                'category_id' => $cat('teknologi'),
                'user_id' => $user('guru.dedi@mading.sch.id'),
                'title' => 'Mengenal Dasar Robotik untuk Pemula',
                'slug' => 'mengenal-dasar-robotik',
                'author' => 'Pak Dedi',
                'class' => null,
                'excerpt' => 'Pengantar sederhana tentang dunia robotik dari pembina tim robotik sekolah.',
                'body' => "Robotik terdengar rumit, tetapi sebenarnya berawal dari hal sederhana: menyusun logika agar mesin bergerak sesuai keinginan.\n\nAda tiga pilar utama yang perlu dipahami:\n\n- **Mekanik**, bagian fisik yang membuat robot berdiri dan bergerak.\n- **Elektronik**, rangkaian yang menghubungkan sensor dan motor ke otak robot.\n- **Pemrograman**, logika yang memerintahkan robot bertindak.\n\nBagi kalian yang baru mulai, jangan ragu untuk mempelajari sensor dasar seperti ultrasonik atau mengikuti ekstrakurikuler robotik di sekolah. Konsistensi jauh lebih penting daripada bakat bawaan.",
                'status' => Article::STATUS_PUBLISHED,
                'views' => 98,
                'published_at' => now()->subDays(12),
            ],
            [
                'category_id' => $cat('seni'),
                'user_id' => $user('siswa.rian@mading.sch.id'),
                'title' => 'Belajar Menggambar Karakter untuk Pemula',
                'slug' => 'menggambar-karakter-pemula',
                'author' => 'Rian (X 3)',
                'class' => 'X 3',
                'excerpt' => 'Tutorial sederhana menggambar karakter anime dan kartun dari anggota ekskul seni.',
                'body' => "Menggambar karakter tidak harus sempurna dari awal. Semua seniman hebat berangkat dari sketsa garis sederhana.\n\nLangkah yang bisa kalian ikuti:\n\n1. Mulailah dari bentuk dasar: lingkaran untuk kepala, garis silang untuk arah wajah.\n2. Tambahkan bentuk tubuh dengan garis ringan, lalu pertegas detail.\n3. Jangan takut salah — gunakan pensil 2B agar mudah dihapus.\n4. Latih ekspresi wajah agar karakter terasa hidup.\n\nBergabunglah dengan ekstrakurikuler seni rupa dan mari berlatih bersama-sama!",
                'status' => Article::STATUS_PUBLISHED,
                'views' => 212,
                'published_at' => now()->subDays(18),
            ],
            [
                'category_id' => $cat('olahraga'),
                'user_id' => $user('guru.budi@mading.sch.id'),
                'title' => 'Manfaat Futsal bagi Kesehatan dan Kerja Sama Tim',
                'slug' => 'manfaat-futsal',
                'author' => 'Pak Budi',
                'class' => null,
                'excerpt' => 'Mengapa futsal layak jadi pilihan ekstrakurikuler untuk menjaga kebugaran dan melatih kekompakan.',
                'body' => "Futsal adalah olahraga yang melatih kelincahan, kecepatan berpikir, dan tentu saja kesehatan jantung.\n\nSelain kebugaran, futsal mengajarkan nilai penting kerja sama:\n\n- Membaca pergerakan rekan satu tim\n- Berkomunikasi secara cepat dan efektif\n- Menerima kekalahan dan tetap sportif\n\nLatihan rutin dua kali seminggu sudah cukup untuk merasakan manfaatnya. Tunggu apa lagi? Mari jaga kesehatan sambil bersenang-senang!",
                'status' => Article::STATUS_PUBLISHED,
                'views' => 76,
                'published_at' => now()->subDays(24),
            ],
            [
                'category_id' => $cat('karya'),
                'user_id' => $user('siswa.salsa@mading.sch.id'),
                'title' => 'Cerpen: Jendela Kelas Paling Belakang',
                'slug' => 'cerpen-jendela-kelas-paling-belakang',
                'author' => 'Salsa (XI IPS 2)',
                'class' => 'XI IPS 2',
                'excerpt' => 'Sebuah cerita pendek tentang pertemanan yang tumbuh dari tempat duduk yang paling sunyi.',
                'body' => "Bagi Rina, jendela kelas paling belakang adalah rumah keduanya. Di sana ia bisa melihat halaman sekolah yang sepi sambil menghitung burung yang lewat.\n\nSuatu hari, seorang siswa baru bernama Bima duduk di sebelahnya. Awalnya mereka hanya bertukar senyum. Lambat laun, mereka saling meminjam buku, berbagi bekal, dan bercerita tentang mimpi masing-masing.\n\nJendela itu tidak lagi sunyi. Ia menjadi saksi tumbuhnya persahabatan yang sederhana namun tulus.\n\nMungkin setiap orang punya jendela kelas paling belakangnya sendiri — tempat di mana pelajaran terpenting justru tidak tercatat di papan tulis.",
                'status' => Article::STATUS_PUBLISHED,
                'views' => 168,
                'published_at' => now()->subDays(30),
            ],
            [
                'category_id' => $cat('osis'),
                'user_id' => $user('siswa.rian@mading.sch.id'),
                'title' => 'Rekap Serunya Jalan Sehat HUT Sekolah',
                'slug' => 'rekap-jalan-sehat-hut-sekolah',
                'author' => 'Redaksi OSIS',
                'class' => null,
                'excerpt' => 'Laporan singkat rangkaian jalan sehat dalam rangka Hari Ulang Tahun sekolah.',
                'body' => "Minggu pagi yang cerah menjadi saksi meriahnya jalan sehat dalam rangka HUT sekolah ke-25.\n\nRibuan peserta mulai dari siswa, guru, hingga orang tua berjalan bersama dari gerbang sekolah menuju lapangan kota. Di akhir rute, panitia menyediakan berbagai doorprize menarik.\n\nKemeriahan semakin terasa dengan penampilan marching band dan flashmob dari OSIS. Kegiatan berjalan lancar berkat kerja sama panitia, wali kelas, dan semua pihak.\n\nTerima kasih untuk partisipasi seluruh warga sekolah. Sampai jumpa di acara berikutnya!",
                'status' => Article::STATUS_PUBLISHED,
                'views' => 243,
                'published_at' => now()->subDays(35),
            ],
        ];

        foreach ($articles as $article) {
            Article::updateOrCreate(['slug' => $article['slug']], $article);
        }
    }
}
