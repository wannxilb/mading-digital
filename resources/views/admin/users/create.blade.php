@extends('layouts.admin')

@section('title', 'Tambah Pengguna')
@section('heading', 'Tambah Pengguna')

@section('content')
    <form method="POST" action="{{ route('admin.pengguna.store') }}" class="mx-auto max-w-2xl">
        @csrf

        <div class="reveal card border-2 p-6 sm:p-8">
            <h2 class="font-display text-lg font-bold text-ink">Akun Baru</h2>

            <div class="mt-6">
                <label for="name" class="label">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="field mt-2">
                @error('name')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
            </div>

            <div class="mt-5">
                <label for="email" class="label">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="field mt-2">
                @error('email')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
            </div>

            <div class="mt-5">
                <label for="nis" class="label">NIS <span class="font-normal normal-case text-ink-3">(untuk siswa)</span></label>
                <input type="text" id="nis" name="nis" value="{{ old('nis') }}" placeholder="cth: 2026001" class="field mt-2">
                @error('nis')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
            </div>

            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="role" class="label">Peran</label>
                    <select id="role" name="role" required class="field mt-2">
                        @foreach ($roles as $key => $label)
                            <option value="{{ $key }}" {{ old('role', 'siswa') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('role')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="class" class="label">Kelas <span class="font-normal normal-case text-ink-3">(untuk siswa)</span></label>
                    <input type="text" id="class" name="class" value="{{ old('class') }}" placeholder="cth: 12 RPL 2" class="field mt-2">
                </div>
            </div>

            <div class="mt-5">
                <label for="jurusan" class="label">Jurusan <span class="font-normal normal-case text-ink-3">(untuk siswa)</span></label>
                <select id="jurusan" name="jurusan" class="field mt-2">
                    <option value="">Pilih jurusan</option>
                    @foreach (\App\Models\User::JURUSAN as $key => $label)
                        <option value="{{ $key }}" {{ old('jurusan') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-5">
                <label for="password" class="label">Password</label>
                <div class="relative mt-2">
                    <input type="password" id="password" name="password" required class="field !pr-11" minlength="8">
                    <button type="button" class="toggle-password absolute right-2 top-1/2 -translate-y-1/2 grid size-8 place-items-center rounded-brutal text-ink-3 transition-colors hover:text-ink" aria-label="Tampilkan sandi">
                        <x-icon name="eye" class="size-[18px] eye-open"/>
                        <x-icon name="eye-off" class="size-[18px] eye-closed hidden"/>
                    </button>
                </div>
                @error('password')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
                <p class="mt-1.5 text-xs font-semibold text-ink-3">Minimal 8 karakter.</p>
            </div>

            <label class="mt-6 flex cursor-pointer items-center justify-between gap-3 rounded-brutal border-2 border-ink/15 bg-paper px-4 py-3.5">
                <span class="text-sm font-bold text-ink">Akun aktif</span>
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" checked class="size-5 rounded-brutal border-2 border-ink accent-ink">
            </label>

            <button type="submit" class="btn-ink mt-7">
                <x-icon name="check" class="size-4"/>
                Tambah Pengguna
            </button>
        </div>
    </form>
@endsection
