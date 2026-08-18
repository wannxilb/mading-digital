@extends('layouts.admin')

@php $event = $event ?? null; @endphp

@section('title', isset($event) ? 'Edit Agenda' : 'Tambah Agenda')
@section('heading', isset($event) ? 'Edit Agenda' : 'Tambah Agenda')

@section('content')
    <form method="POST" action="{{ isset($event) ? route('admin.agenda.update', $event) : route('admin.agenda.store') }}" enctype="multipart/form-data" class="mx-auto max-w-3xl">
        @csrf
        @if (isset($event))
            @method('PUT')
        @endif

        <div class="reveal card border-2 p-6 sm:p-8">
            <h2 class="font-display text-lg font-bold text-ink">Detail Agenda</h2>

            <div class="mt-6">
                <label for="title" class="label">Nama Kegiatan</label>
                <p class="mt-1 text-[11px] text-ink-3">Nama kegiatan yang jelas dan mudah dipahami.</p>
                <input type="text" id="title" name="title" value="{{ old('title', $event->title ?? '') }}" required class="field mt-2">
                @error('title')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
            </div>

            <div class="mt-5">
                <label for="description" class="label">Deskripsi <span class="font-normal normal-case text-ink-3">(opsional)</span></label>
                <p class="mt-1 text-[11px] text-ink-3">Deskripsi singkat tentang kegiatan (maks 500 karakter).</p>
                <textarea id="description" name="description" rows="3" maxlength="500" class="field mt-2">{{ old('description', $event->description ?? '') }}</textarea>
            </div>

            <div class="mt-6 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="event_date" class="label">Tanggal Kegiatan</label>
                    <p class="mt-1 text-[11px] text-ink-3">Tanggal pelaksanaan kegiatan.</p>
                    <input type="date" id="event_date" name="event_date" value="{{ old('event_date', $event?->event_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required class="field mt-2">
                    @error('event_date')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="location" class="label">Lokasi</label>
                    <p class="mt-1 text-[11px] text-ink-3">Tempat kegiatan dilaksanakan.</p>
                    <input type="text" id="location" name="location" value="{{ old('location', $event->location ?? '') }}" placeholder="cth: Aula Sekolah" class="field mt-2">
                </div>
                <div>
                    <label for="start_time" class="label">Mulai</label>
                    <p class="mt-1 text-[11px] text-ink-3">Jam mulai kegiatan.</p>
                    <input type="time" id="start_time" name="start_time" value="{{ old('start_time', $event->start_time ?? '') }}" class="field mt-2">
                </div>
                <div>
                    <label for="end_time" class="label">Selesai</label>
                    <p class="mt-1 text-[11px] text-ink-3">Jam selesai kegiatan.</p>
                    <input type="time" id="end_time" name="end_time" value="{{ old('end_time', $event->end_time ?? '') }}" class="field mt-2">
                </div>
            </div>

            <button type="submit" class="btn-ink mt-7">
                <x-icon name="check" class="size-4"/>
                {{ isset($event) ? 'Simpan Perubahan' : 'Tambah Agenda' }}
            </button>
        </div>

        @if (isset($event) && $event->poster)
            <div class="reveal card border-2 p-6" style="transition-delay:.05s">
                <h2 class="font-display text-lg font-bold text-ink">Poster</h2>
                <div class="mt-4 overflow-hidden rounded-brutal border-2 border-ink bg-paper-deep">
                    <img src="{{ asset('storage/'.$event->poster) }}" alt="Poster saat ini" class="w-full max-h-48 object-contain">
                </div>
                <label class="mt-3 flex cursor-pointer items-center gap-2 text-xs font-bold text-accent">
                    <input type="checkbox" name="remove_poster" value="1" class="size-4 rounded-brutal border-2 border-ink accent-accent">
                    Hapus poster saat ini
                </label>
            </div>
        @endif

        <div class="reveal card border-2 p-6" style="transition-delay:{{ isset($event) && $event->poster ? '.1s' : '.05s' }}">
            <h2 class="font-display text-lg font-bold text-ink">Poster Kegiatan</h2>
            <p class="mt-1 text-xs font-semibold text-ink-3">Opsional. Format: JPG, PNG. Maks 4MB.</p>

            <div class="mt-4">
                <label class="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-brutal border-2 border-dashed border-ink/30 bg-paper px-4 py-8 text-center transition-colors hover:border-ink">
                    <x-icon name="image" class="size-7 text-ink-3"/>
                    <span class="text-xs font-bold text-ink-2">{{ (isset($event) && $event->poster) ? 'Ganti poster' : 'Pilih poster' }}</span>
                    <span class="text-[11px] font-semibold text-ink-3">JPG, PNG · maks 4MB</span>
                    <input type="file" id="poster" name="poster" accept="image/*" class="hidden">
                </label>
                @error('poster')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
            </div>
        </div>
    </form>
@endsection
