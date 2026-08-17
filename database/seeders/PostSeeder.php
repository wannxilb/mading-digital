<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $cat = fn (string $slug) => Category::where('slug', $slug)->firstOrFail()->id;

        $posts = [
            [
                'category_id' => $cat('pendidikan'),
                'title' => 'Libur Tengah Semester: Mari Isi dengan Hal yang Bermakna',
                'slug' => 'libur-tengah-semester',
                'author' => 'Waka Kesiswaan',
                'excerpt' => 'Mulai tanggal 12 hingga 20 bulan ini, seluruh siswa menikmati libur tengah semester. Jangan lupa rehat, isi energi, dan siapkan diri untuk perjalanan belajar berikutnya.',
                'body' => "Sahabat mading, setelah satu semester penuh berjalan, tiba waktunya untuk berhenti sejenak dan menarik napas.\n\nLibur tengah semester dimulai pada **12 s.d. 20 bulan ini**. Selama libur, seluruh kegiatan pembelajaran tatap muka ditiadakan.\n\nKami mengajak kalian untuk mengisi waktu libur dengan hal-hal yang menyehatkan tubuh dan pikiran:\n\n- Kembalikan jam tidur, tubuh juga butuh istirahat.\n\n- Sempatkan berolahraga dan berkumpul bersama keluarga.\n\n- Baca satu buku yang sudah lama kalian nanti-nanti.\n\n- Jangan lupa tetap menjaga protokol kesehatan di keramaian.\n\nKegiatan belajar mengajar kembali berjalan seperti biasa pada hari Senin, 22 bulan ini. Sampai jumpa di halte berikutnya dari perjalanan kita!",
                'is_featured' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'category_id' => $cat('prestasi'),
                'title' => 'Selamat! Tim Robotik Raih Juara 2 Tingkat Provinsi',
                'slug' => 'tim-robotik-juara-2-provinsi',
                'author' => 'Redaksi Mading',
                'excerpt' => 'Tim robotik sekolah berhasil membawa pulang medali perak dari kompetisi tingkat provinsi. Ini buah dari kerja keras latihan berbulan-bulan.',
                'body' => "Perjalanan panjang tim robotik akhirnya berbuah manis. Dalam ajang **Kompetisi Robotik Pelajar tingkat Provinsi** yang digelar akhir pekan lalu, tim kita berhasil meraih **Juara 2** pada kategori Robot Penolong.\n\nTim yang beranggotakan Andi, Bima, dan Citra ini menghabiskan waktu hampir tiga bulan menyiapkan strategi dan menyempurnakan desain robot mereka. Di final, mereka bersaing ketat dengan 12 tim lain dari berbagai sekolah.\n\n\"Kami sempat gugup, tapi ingat semua jam latihan kita. Itu yang menenangkan,\" ujar Andi, kapten tim.\n\nPembina tim, Pak Dedi, menyebut kemenangan ini adalah bukti bahwa konsistensi kecil setiap hari akhirnya melahirkan hasil besar. Mari beri apresiasi untuk mereka!",
                'is_featured' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'category_id' => $cat('kegiatan'),
                'title' => 'Pekan Seni dan Kreativitas: Berani Tampil di Panggung',
                'slug' => 'pekan-seni-dan-kreativitas',
                'author' => 'OSIS',
                'excerpt' => 'Pekan Seni dan Kreativitas tahun ini mengusung tema "Kecil Berani, Besar Melangkah". Ajak temanmu untuk ikut tampil!',
                'body' => "Satu minggu penuh, halaman sekolah akan berubah menjadi panggung seni. **Pekan Seni dan Kreativitas** tahun ini mengangkat tema **\"Kecil Berani, Besar Melangkah\"**.\n\nKegiatan ini terbuka untuk semua siswa dari kelas X hingga XII. Ada banyak kategori yang bisa diikuti:\n\n- Musik & band pelajar\n- Tari kreasi\n- Puisi dan cerpen\n- Melukis & desain poster\n- Mading kelas\n\nSetiap kelas diharapkan mengirimkan minimal satu perwakilan. Pendaftaran ditutup pada akhir pekan ini melalui ketua kelas masing-masing.\n\nBagi kalian yang ragu untuk tampil, ingat: setiap perjalanan besar dimulai dari langkah pertama yang berani.",
                'is_featured' => false,
                'published_at' => now()->subDays(8),
            ],
            [
                'category_id' => $cat('karya'),
                'title' => 'Pojok Literasi: Resensi "Laskar Pelangi"',
                'slug' => 'resensi-laskar-pelangi',
                'author' => 'Salsabila (XI IPA 1)',
                'excerpt' => 'Salah satu karya siswa yang mengajak kita merenungi arti semangat belajar melalui kisah anak-anak Belitung.',
                'body' => "Perjalanan sekolah tidak selalu tentang nilai, tetapi tentang semangat yang tidak pernah padam. Buku *Laskar Pelangi* karya Andrea Hirata adalah bukti nyata hal itu.\n\nKisah ini berlatar di Belitung, mengikuti sepuluh anak dari keluarga sederhana yang bersekolah di SD Muhammadiyah yang nyaris ditutup. Ibu Mus, sang guru, menjadi pelita yang menjaga semangat mereka tetap menyala.\n\nYang membuat buku ini istimewa adalah caranya merayakan hal-hal kecil: kegembiraan menemukan kelereng, perjuangan menghafal angka, dan tekad untuk tidak pernah berhenti bermimpi.\n\nUntuk teman-teman yang sedang merasa lelah dalam perjalanan belajarnya, saya merekomendasikan buku ini. Terkadang kita butuh diingatkan bahwa apa pun titik awal kita, semangat dan usaha tetap menjadi kunci.\n\n> \"Hidup adalah untuk menghadapi kesukaran-kesukaran... dan untuk belajar darinya.\"",
                'is_featured' => true,
                'published_at' => now()->subDays(11),
            ],
            [
                'category_id' => $cat('osis'),
                'title' => 'Dari Canggung ke Kompak: Cerita Hari Pertama OSIS',
                'slug' => 'cerita-hari-pertama-osis',
                'author' => 'Rian (XII IPS 2)',
                'excerpt' => 'Pernah merasa semua orang terlihat asing? Itulah yang kami rasakan saat pertama kali berkumpul sebagai pengurus OSIS yang baru.',
                'body' => "Saya masih ingat hari pertama rapat pengurus OSIS. Duduk berjauhan, saling diam, dan tidak ada yang berani memulai obrolan. Canggung sekali.\n\nTapi perubahan tidak butuh waktu lama. Dimulai dari tugas kecil membagi kelompok kerja, kemudian tertawa bersama saat latihan acara, hingga akhirnya saling mengandalkan ketika acara besar datang.\n\nPerjalanan kami mengajarkan bahwa kekompakan bukan sesuatu yang tiba-tiba ada. Ia dibangun dari banyak pertemuan kecil, saling mendengarkan, dan berani meminta maaf ketika salah.\n\nJika kalian sedang berada di titik awal sebuah perjalanan — entah organisasi, kelas baru, atau lingkaran pertemanan baru — jangan takut dengan rasa canggung di hari pertama. Itu hanya penanda bahwa kalian baru saja mulai.",
                'is_featured' => false,
                'published_at' => now()->subDays(14),
            ],
            [
                'category_id' => $cat('ekstrakurikuler'),
                'title' => 'Pendaftaran Kegiatan Ekstrakurikuler Semester Baru',
                'slug' => 'pendaftaran-ekstrakurikuler',
                'author' => 'Pembina OSIS',
                'excerpt' => 'Pilih perjalananmu! Pendaftaran ekstrakurikuler dibuka mulai pekan depan. Tersedia 15 pilihan kegiatan.',
                'body' => "Ekstrakurikuler adalah tempat terbaik untuk menemukan minat dan bakat selama di sekolah. Untuk semester ini, **pendaftaran dibuka mulai Senin pekan depan** hingga Jumat.\n\nTersedia 15 pilihan kegiatan yang bisa kalian ikuti:\n\n- Pramuka, Paskibra, PMR\n- Futsal, Basket, Badminton\n- Robotik, KIR, Jurnalistik\n- Paduan suara, Teater, Tari\n- Fotografi, Desain grafis, Mading digital\n\nSetiap siswa diperbolehkan memilih maksimal dua kegiatan. Formulir dapat diambil di ruang OSIS atau diunduh melalui tautan yang dibagikan wali kelas.\n\nKegiatan yang dipilih dengan hati akan terasa seperti petualangan, bukan beban. Pilihlah yang benar-benar membuat kalian penasaran.",
                'is_featured' => false,
                'published_at' => now()->subDays(18),
            ],
            [
                'category_id' => $cat('prestasi'),
                'title' => 'Raih Medali Emas OSN Matematika Tingkat Kabupaten',
                'slug' => 'medali-emas-osn-matematika',
                'author' => 'Redaksi Mading',
                'excerpt' => 'Kembali menorehkan prestasi! Siswa kelas XI berhasil meraih medali emas pada Olimpiade Sains Nasional bidang Matematika.',
                'body' => "Kabar membanggakan datang dari ajang **Olimpiade Sains Nasional bidang Matematika tingkat Kabupaten**. Perwakilan sekolah kita, **Dinda Prameswari (XI IPA 2)**, berhasil meraih **medali emas**.\n\nPencapaian ini diraih setelah melalui seleksi berjenjang dan pembinaan intensif selama satu semester. Dinda mengaku persiapan terbesarnya adalah membiasakan diri mengerjakan soal-soal non-rutin.\n\n\"Matematika bukan tentang menghafal rumus, tapi tentang berani mencoba berbagai cara,\" pesannya untuk adik kelas.\n\nDengan hasil ini, Dinda berhak melaju ke tahap provinsi. Doakan dan dukung terus teman kita ini!",
                'is_featured' => false,
                'published_at' => now()->subDays(21),
            ],
            [
                'category_id' => $cat('kegiatan'),
                'title' => 'Bakti Sosial ke Panti Asuhan: Berbagi Itu Menyenangkan',
                'slug' => 'bakti-sosial-panti-asuhan',
                'author' => 'Redaksi Mading',
                'excerpt' => 'Sekumpulan siswa mengunjungi panti asuhan untuk berbagi kebutuhan pokok, buku, dan semangat. Inilah ceritanya.',
                'body' => "Sabtu lalu, 40 siswa bersama guru pendamping menggelar kegiatan bakti sosial di Panti Asuhan Harapan Kita. Donasi berupa sembako, buku bacaan, dan perlengkapan sekolah diserahkan secara langsung.\n\nNamun, yang paling berkesan bukan barangnya, melainkan waktu yang kami habiskan bersama: bermain, bernyanyi, dan mendengar cerita mereka.\n\nSalah satu siswa, Nadia, mengaku pulang dengan perasaan yang sulit dijelaskan. \"Kami datang ingin memberi, tapi ternyata kami yang banyak menerima pelajaran hidup.\"\n\nKegiatan ini diharapkan menjadi agenda rutin. Berbagi tidak selalu membutuhkan banyak hal — kadang kehadiran dan perhatian saja sudah sangat berarti.",
                'is_featured' => false,
                'published_at' => now()->subDays(25),
            ],
            [
                'category_id' => $cat('karya'),
                'title' => 'Puisi: Langkah Pertama',
                'slug' => 'puisi-langkah-pertama',
                'author' => 'Farhan (X 1)',
                'excerpt' => 'Sebuah puisi karya siswa kelas X tentang keberanian memulai sesuatu yang baru.',
                'body' => "Ada sunyi di ujung gerbang\nsaat langkah pertama belum berani\nnama-nama asing masih berbisik\ndan hari-hari terasa seperti teka-teki.\n\nNamun di sini, di lorong-lorong itu\naku belajar mengeja keberanian\nsatu langkah, satu senyum\nsatu hal baru setiap harinya.\n\nPerjalanan ini panjang, kata orang\npenuh tanjakan dan tikungan\ntapi aku membawa serta\ndoa, teman, dan mimpi di pundak.\n\nMaka biarkan aku berjalan\nperlahan, tapi tidak berhenti\nkarena langkah pertama hari ini\nadalah kisah yang kelak kuceritakan.",
                'is_featured' => false,
                'published_at' => now()->subDays(28),
            ],
            [
                'category_id' => $cat('pendidikan'),
                'title' => 'Pelajaran dari Kantin: Kisah Sederhana yang Berharga',
                'slug' => 'pelajaran-dari-kantin',
                'author' => 'Bu Yuli',
                'excerpt' => 'Sebagai guru, terkadang pelajaran terbaik justru datang dari hal-hal sederhana, seperti antrean di kantin.',
                'body' => "Setiap kali jam istirahat tiba, saya suka mengamati kantin sekolah dari kejauhan. Ada sesuatu yang jujur dari cara anak-anak antre membeli makanan.\n\nBeberapa bersabar menunggu giliran, beberapa sesekali berteriak memanggil ibu kantin, dan tidak sedikit yang rela berbagi sisa uang jajannya untuk membelikan temannya.\n\nSuatu hari, saya melihat seorang siswa membayar dua porsi tetapi menghabiskan satu porsi bersama temannya yang tidak punya uang. Ia melakukannya tanpa menarik perhatian siapa pun.\n\nDari kantin, saya belajar bahwa karakter tidak selalu tampil di panggung besar. Ia lebih sering bersinar di hal-hal kecil yang tidak ada yang memuji. Semoga anak-anak kita terus menyimpan kebaikan sederhana seperti itu.",
                'is_featured' => false,
                'published_at' => now()->subDays(31),
            ],
        ];

        foreach ($posts as $post) {
            $post['views'] = fake()->numberBetween(20, 320);
            Post::updateOrCreate(['slug' => $post['slug']], $post);
        }
    }
}
