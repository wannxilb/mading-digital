@extends('layouts.admin')

@php $achievement = $achievement ?? null; @endphp

@section('title', isset($achievement) ? 'Edit Prestasi' : 'Tambah Prestasi')
@section('heading', isset($achievement) ? 'Edit Prestasi' : 'Tambah Prestasi')

@section('content')
    <form method="POST" action="{{ isset($achievement) ? route('admin.prestasi.update', $achievement) : route('admin.prestasi.store') }}" enctype="multipart/form-data" class="mx-auto max-w-3xl">
        @csrf
        @if (isset($achievement))
            @method('PUT')
        @endif

        <div class="reveal card border-2 p-6 sm:p-8">
            <h2 class="font-display text-lg font-bold text-ink">Detail Prestasi</h2>

            <div class="mt-6">
                <label for="title" class="label">Nama Prestasi</label>
                <p class="mt-1 text-[11px] text-ink-3">Judul prestasi yang jelas (cth: Juara 1 OSN Matematika).</p>
                <input type="text" id="title" name="title" value="{{ old('title', $achievement->title ?? '') }}" placeholder="cth: Juara 1 OSN Matematika" required class="field mt-2">
                @error('title')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
            </div>

            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="competition_name" class="label">Nama Lomba</label>
                    <p class="mt-1 text-[11px] text-ink-3">Nama kompetisi atau lomba.</p>
                    <input type="text" id="competition_name" name="competition_name" value="{{ old('competition_name', $achievement->competition_name ?? '') }}" placeholder="cth: OSN Tingkat Provinsi" class="field mt-2">
                </div>
                <div>
                    <label for="achievement_date" class="label">Tanggal Raih</label>
                    <p class="mt-1 text-[11px] text-ink-3">Tanggal prestasi diraih.</p>
                    <input type="date" id="achievement_date" name="achievement_date" value="{{ old('achievement_date', $achievement?->achievement_date?->format('Y-m-d') ?? '') }}" class="field mt-2">
                </div>
                <div>
                    <label for="student_name" class="label">Nama Penerima</label>
                    <p class="mt-1 text-[11px] text-ink-3">Nama siswa/siswi yang meraih prestasi.</p>
                    <input type="text" id="student_name" name="student_name" value="{{ old('student_name', $achievement->student_name ?? '') }}" placeholder="cth: Siti Rahma" class="field mt-2">
                </div>
                <div>
                    <label for="class" class="label">Kelas <span class="font-normal normal-case text-ink-3">(opsional)</span></label>
                    <p class="mt-1 text-[11px] text-ink-3">Kelas penerima prestasi.</p>
                    <input type="text" id="class" name="class" value="{{ old('class', $achievement->class ?? '') }}" placeholder="cth: XI IPA 1" class="field mt-2">
                </div>
                <div>
                    <label for="rank" class="label">Peringkat / Gelar</label>
                    <p class="mt-1 text-[11px] text-ink-3">Peringkat atau gelar yang diraih.</p>
                    <input type="text" id="rank" name="rank" value="{{ old('rank', $achievement->rank ?? '') }}" placeholder="cth: Juara 1" class="field mt-2">
                </div>
                <div>
                    <label for="competition_level" class="label">Tingkat Lomba</label>
                    <p class="mt-1 text-[11px] text-ink-3">Tingkatan kompetisi.</p>
                    <select id="competition_level" name="competition_level" required class="field mt-2">
                        @foreach ($levels as $key => $label)
                            <option value="{{ $key }}" {{ old('competition_level', $achievement->competition_level ?? 'sekolah') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('competition_level')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mt-5">
                <label for="description" class="label">Keterangan <span class="font-normal normal-case text-ink-3">(opsional)</span></label>
                <textarea id="description" name="description" rows="3" maxlength="1000" class="field mt-2">{{ old('description', $achievement->description ?? '') }}</textarea>
            </div>

            <div class="mt-6">
                <label class="label">Dokumentasi <span class="font-normal normal-case text-ink-3">(opsional)</span></label>
                @if (isset($achievement) && $achievement->image)
                    <div class="mt-2 mb-3 overflow-hidden rounded-brutal border-2 border-ink bg-paper-deep">
                        <img src="{{ asset('storage/'.$achievement->image) }}" alt="Dokumentasi saat ini" class="w-full max-h-48 object-contain">
                    </div>
                @endif
                <label class="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-brutal border-2 border-dashed border-ink/30 bg-paper px-4 py-7 text-center transition-colors hover:border-ink">
                    <x-icon name="image" class="size-6 text-ink-3"/>
                    <span class="text-xs font-bold text-ink-2">Pilih gambar dokumentasi</span>
                    <input type="file" id="image" name="image" accept="image/*" class="hidden">
                </label>
                @error('image')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror

                @if (isset($achievement) && $achievement->image)
                    <label class="mt-3 flex cursor-pointer items-center gap-2 text-xs font-bold text-accent">
                        <input type="checkbox" name="remove_image" value="1" class="size-4 rounded-brutal border-2 border-ink accent-accent">
                        Hapus dokumentasi saat ini
                    </label>
                @endif
            </div>

            <button type="submit" class="btn-ink mt-7">
                <x-icon name="check" class="size-4"/>
                {{ isset($achievement) ? 'Simpan Perubahan' : 'Tambah Prestasi' }}
            </button>
        </div>
    </form>
@endsection
