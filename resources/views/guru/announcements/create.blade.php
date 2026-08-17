@extends('layouts.guru')

@section('title', 'Buat Pengumuman')
@section('heading', 'Buat Pengumuman')

@section('content')
    <form method="POST" action="{{ route('guru.pengumuman.store') }}" class="max-w-3xl">
        @csrf

        <div class="card border-2 p-6 sm:p-8">
            <h2 class="font-display text-lg font-bold text-ink">Pengumuman Baru</h2>
            <p class="mt-1 text-sm text-ink-2">Pengumuman akan langsung dipublikasikan dan tampil di halaman publik.</p>

            <div class="mt-6">
                <label for="title" class="label">Judul</label>
                <p class="mt-1 text-[11px] text-ink-3">Judul pengumuman yang jelas dan ringkas.</p>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required class="field mt-2" placeholder="Judul pengumuman">
                @error('title')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
            </div>

            <div class="mt-5">
                <label for="content" class="label">Isi Pengumuman <span class="font-normal normal-case text-ink-3">— mendukung markdown</span></label>
                <p class="mt-1 text-[11px] text-ink-3">Tulis isi pengumuman di sini. Mendukung format <strong>markdown</strong> untuk tebal, miring, daftar, dan kutipan.</p>
                <textarea id="content" name="content" rows="10" required class="field mt-2 font-mono text-[13px] leading-relaxed" placeholder="Tulis isi pengumuman...">{{ old('content') }}</textarea>
                @error('content')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
            </div>

            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="priority" class="label">Prioritas</label>
                    <p class="mt-1 text-[11px] text-ink-3">Tingkat prioritas pengumuman.</p>
                    <select id="priority" name="priority" required class="field mt-2">
                        @foreach ($priorities as $key => $label)
                            <option value="{{ $key }}" {{ old('priority', 'normal') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="start_date" class="label">Tanggal Mulai <span class="font-normal normal-case text-ink-3">(opsional)</span></label>
                    <p class="mt-1 text-[11px] text-ink-3">Tanggal pengumuman mulai berlaku.</p>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" class="field mt-2">
                </div>
            </div>

            <div class="mt-5">
                <label for="end_date" class="label">Tanggal Berakhir <span class="font-normal normal-case text-ink-3">(opsional)</span></label>
                <p class="mt-1 text-[11px] text-ink-3">Tanggal pengumuman berakhir. Kosongkan jika tidak ada batas waktu.</p>
                <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" class="field mt-2">
                @error('end_date')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn-ink mt-6 w-full !py-3.5" onclick="return confirm('Publikasikan pengumuman ini?')">
                <x-icon name="megaphone" class="size-4"/>
                Publikasikan Pengumuman
            </button>
        </div>
    </form>
@endsection
