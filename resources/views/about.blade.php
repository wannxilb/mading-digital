@extends('layouts.app')

@section('title', 'Tentang Mading')
@section('meta_description', 'Mengenal lebih dekat majalah dinding digital sekolah.')

@section('content')
    <section class="border-b-2 border-ink">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 pt-28 sm:pt-32 pb-12 text-center">
            <h1 class="font-display text-4xl font-bold tracking-tight text-ink sm:text-5xl">
                Tentang Mading Digital
            </h1>
            <p class="mt-3 text-sm leading-relaxed text-ink-2 sm:text-base">Majalah dinding versi digital untuk sekolah kita.</p>
        </div>
    </section>

    <section class="mx-auto max-w-3xl px-4 sm:px-6 py-14 sm:py-20">
        <div class="prose-wrap">
            <h2>Apa itu Mading Digital?</h2>
            <p>
                <strong>Mading Sekolah Digital</strong> adalah majalah dinding digital yang menjadi pusat informasi dan publikasi sekolah.
                Berbeda dengan mading konvensional yang ditempel di papan, seluruh konten di sini dikelola lewat sistem sehingga bisa
                diperbarui kapan saja, dicari dengan mudah, dan terarsip secara otomatis.
            </p>

            <h2>Apa saja yang bisa ditemukan?</h2>
            <ul>
                <li><strong>Pengumuman</strong> — jadwal ujian, libur, pembagian rapor, dan informasi penting lainnya.</li>
                <li><strong>Berita sekolah</strong> — kabar dan dokumentasi kegiatan.</li>
                <li><strong>Artikel & karya siswa</strong> — cerpen, puisi, opini, ulasan buku, dan karya kreatif.</li>
                <li><strong>Agenda</strong> — kegiatan yang akan datang: upacara, lomba, rapat OSIS, dan lainnya.</li>
                <li><strong>Prestasi</strong> — juara lomba dan penghargaan dari siswa sekolah.</li>
            </ul>

            <h2>Kenapa digital?</h2>
            <p>
                Informasi jadi lebih mudah diakses dari mana saja, pembaruan tidak perlu mencetak ulang, pencarian cepat,
                dan dokumentasi setiap edisi tersimpan rapi. Dengan begitu, sekolah dan siswa memiliki satu papan yang
                tidak pernah kehabisan tempat.
            </p>
        </div>

        <div class="mt-12 rounded-brutal border-2 border-ink bg-ink p-8 text-center text-cream">
            <p class="font-display text-xl font-bold sm:text-2xl">Punya tulisan atau karya untuk dipajang?</p>
            <p class="mx-auto mt-2 max-w-md text-sm text-cream/70">Sampaikan kepada guru pembina atau pengurus mading. Karya yang disetujui akan tampil di papan digital sekolah.</p>
        </div>
    </section>
@endsection
