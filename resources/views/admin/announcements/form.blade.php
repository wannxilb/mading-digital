@extends('layouts.admin')

@php $announcement = $announcement ?? null; @endphp

@section('title', isset($announcement) ? 'Edit Pengumuman' : 'Buat Pengumuman')
@section('heading', isset($announcement) ? 'Edit Pengumuman' : 'Buat Pengumuman')

@section('content')
    <form method="POST" action="{{ isset($announcement) ? route('admin.pengumuman.update', $announcement) : route('admin.pengumuman.store') }}" class="max-w-3xl">
        @csrf
        @if (isset($announcement))
            @method('PUT')
        @endif

        <div class="reveal card border-2 p-6 sm:p-8">
            <h2 class="font-display text-lg font-bold text-ink">Isi Pengumuman</h2>

            <div class="mt-6">
                <label for="title" class="label">Judul</label>
                <input type="text" id="title" name="title" value="{{ old('title', $announcement->title ?? '') }}" required class="field mt-2">
                @error('title')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
            </div>

            <div class="mt-5">
                <label for="content" class="label">Isi Pengumuman</label>
                <textarea id="content" name="content" rows="6" required class="field mt-2">{{ old('content', $announcement->content ?? '') }}</textarea>
                @error('content')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
            </div>

            <div class="mt-6 grid gap-5 sm:grid-cols-3">
                <div>
                    <label for="priority" class="label">Prioritas</label>
                    <select id="priority" name="priority" required class="field mt-2">
                        @foreach ($priorities as $key => $label)
                            <option value="{{ $key }}" {{ old('priority', $announcement->priority ?? 'normal') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status" class="label">Status</label>
                    <select id="status" name="status" required class="field mt-2">
                        @foreach ($statuses as $key => $label)
                            <option value="{{ $key }}" {{ old('status', $announcement->status ?? 'aktif') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <label class="flex w-full cursor-pointer items-center justify-between gap-3 rounded-brutal border-2 border-ink/15 bg-paper px-4 py-2.5">
                        <span class="text-sm font-bold text-ink">Sematkan (pin)</span>
                        <input type="hidden" name="is_pinned" value="0">
                        <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned', $announcement->is_pinned ?? false) ? 'checked' : '' }} class="size-5 rounded-brutal border-2 border-ink accent-ink">
                    </label>
                </div>
            </div>

            <div class="mt-6 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="start_date" class="label">Tanggal Mulai <span class="font-normal normal-case text-ink-3">(opsional)</span></label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $announcement?->start_date?->format('Y-m-d') ?? '') }}" class="field mt-2">
                </div>
                <div>
                    <label for="end_date" class="label">Tanggal Berakhir <span class="font-normal normal-case text-ink-3">(opsional)</span></label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $announcement?->end_date?->format('Y-m-d') ?? '') }}" class="field mt-2">
                </div>
            </div>
            <p class="mt-2 text-xs font-semibold text-ink-3">Pengumuman otomatis tidak tampil setelah melewati tanggal berakhir (BR-09).</p>
            @error('end_date')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror

            <button type="submit" class="btn-ink mt-7">
                <x-icon name="check" class="size-4"/>
                {{ isset($announcement) ? 'Simpan Perubahan' : 'Terbitkan Pengumuman' }}
            </button>
        </div>
    </form>
@endsection
