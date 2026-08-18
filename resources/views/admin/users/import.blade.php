@extends('layouts.admin')

@section('title', 'Import Siswa dari CSV')
@section('heading', 'Import Siswa dari CSV')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="card border-2 p-6 sm:p-8">
            <h2 class="font-display text-lg font-bold text-ink">Upload CSV</h2>
            <p class="mt-2 text-sm text-ink-3">
                Format CSV harus memiliki header: <code class="rounded-brutal bg-ink/5 px-1.5 py-0.5 text-xs font-bold">nis, nama, kelas, jurusan, password</code>.
                Email akan di-generate otomatis: <code class="rounded-brutal bg-ink/5 px-1.5 py-0.5 text-xs font-bold">nis@domain-sekolah</code>.
                Semua siswa yang diimport akan otomatis aktif dengan peran siswa.
            </p>

            <div class="mt-5 rounded-brutal border-2 border-ink/15 bg-paper p-4">
                <p class="text-xs font-bold text-ink-2">Contoh isi CSV:</p>
                <pre class="mt-2 font-mono text-[11px] leading-relaxed text-ink-3">nis,nama,kelas,jurusan,password
2026001,Andi Saputra,10 PPLG 1,rpl,andi12345
2026002,Budi Santoso,12 RPL 2,rpl,budi12345
2026003,Citra Dewi,11 AKL 1,akl,citra12345</pre>
            </div>

            <div class="mt-4 rounded-brutal border-2 border-ink/15 bg-paper p-4">
                <p class="text-xs font-bold text-ink-2">Daftar Jurusan:</p>
                <div class="mt-2 grid grid-cols-2 gap-1 text-[11px] font-semibold text-ink-3">
                    <span>mplb = Manajemen Perkantoran</span>
                    <span>rpl = Rekayasa Perangkat Lunak</span>
                    <span>akl = Akuntansi</span>
                    <span>bd = Bisnis Digital</span>
                    <span>dkv = Desain Komunikasi Visual</span>
                    <span>pf = Perfilman</span>
                    <span>dpb = Desain dan Produksi Busana</span>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.pengguna.import.process') }}" enctype="multipart/form-data" class="mt-6">
                @csrf

                <label class="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-brutal border-2 border-dashed border-ink/30 bg-paper px-4 py-10 text-center transition-colors hover:border-ink">
                    <x-icon name="image" class="size-8 text-ink-3"/>
                    <span class="text-sm font-bold text-ink-2">Pilih file CSV</span>
                    <span class="text-[11px] font-semibold text-ink-3">CSV, TXT · maks 2MB</span>
                    <input type="file" id="csv_file" name="csv_file" accept=".csv,.txt" required class="hidden">
                </label>
                @error('csv_file')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror

                <button type="submit" class="btn-ink mt-6">
                    <x-icon name="check" class="size-4"/>
                    Import Sekarang
                </button>
            </form>
        </div>
    </div>
@endsection
