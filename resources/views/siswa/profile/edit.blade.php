@extends('layouts.siswa')

@section('title', 'Edit Profil')
@section('heading', 'Edit Profil')

@section('content')
    <form method="POST" action="{{ route('siswa.profil.update') }}" class="mx-auto max-w-2xl">
        @csrf
        @method('PUT')

        <div class="card border-2 p-6 sm:p-8">
            <h2 class="font-display text-lg font-bold text-ink">Informasi Akun</h2>

            <div class="mt-6">
                <label for="name" class="label">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="field mt-2">
                @error('name')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
            </div>

            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="label">NIS</label>
                    <input type="text" value="{{ $user->nis ?? '-' }}" disabled class="field mt-2 opacity-60 cursor-not-allowed">
                </div>
                <div>
                    <label class="label">Email</label>
                    <input type="email" value="{{ $user->email }}" disabled class="field mt-2 opacity-60 cursor-not-allowed">
                </div>
            </div>

            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="label">Kelas</label>
                    <input type="text" value="{{ $user->class ?? '-' }}" disabled class="field mt-2 opacity-60 cursor-not-allowed">
                </div>
                <div>
                    <label class="label">Jurusan</label>
                    <input type="text" value="{{ $user->jurusan_label ?? '-' }}" disabled class="field mt-2 opacity-60 cursor-not-allowed">
                </div>
            </div>

            <p class="mt-3 text-[11px] text-ink-3">NIS, email, kelas, dan jurusan tidak dapat diubah. Hubungi admin jika perlu perubahan.</p>
        </div>

        <div class="card mt-6 border-2 p-6 sm:p-8">
            <h2 class="font-display text-lg font-bold text-ink">Ganti Password</h2>
            <p class="mt-1 text-sm text-ink-3">Kosongkan jika tidak ingin mengganti password.</p>

            <div class="mt-5">
                <label for="current_password" class="label">Password Lama</label>
                <div class="relative mt-2">
                    <input type="password" id="current_password" name="current_password" class="field !pr-11" autocomplete="current-password">
                    <button type="button" class="toggle-password absolute right-2 top-1/2 -translate-y-1/2 grid size-8 place-items-center rounded-brutal text-ink-3 transition-colors hover:text-ink" aria-label="Tampilkan sandi">
                        <x-icon name="eye" class="size-[18px] eye-open"/>
                        <x-icon name="eye-off" class="size-[18px] eye-closed hidden"/>
                    </button>
                </div>
                @error('current_password')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
            </div>

            <div class="mt-5">
                <label for="password" class="label">Password Baru</label>
                <div class="relative mt-2">
                    <input type="password" id="password" name="password" class="field !pr-11" minlength="8" autocomplete="new-password">
                    <button type="button" class="toggle-password absolute right-2 top-1/2 -translate-y-1/2 grid size-8 place-items-center rounded-brutal text-ink-3 transition-colors hover:text-ink" aria-label="Tampilkan sandi">
                        <x-icon name="eye" class="size-[18px] eye-open"/>
                        <x-icon name="eye-off" class="size-[18px] eye-closed hidden"/>
                    </button>
                </div>
                @error('password')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
                <p class="mt-1 text-[11px] text-ink-3">Minimal 8 karakter.</p>
            </div>

            <div class="mt-5">
                <label for="password_confirmation" class="label">Konfirmasi Password Baru</label>
                <div class="relative mt-2">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="field !pr-11" minlength="8" autocomplete="new-password">
                    <button type="button" class="toggle-password absolute right-2 top-1/2 -translate-y-1/2 grid size-8 place-items-center rounded-brutal text-ink-3 transition-colors hover:text-ink" aria-label="Tampilkan sandi">
                        <x-icon name="eye" class="size-[18px] eye-open"/>
                        <x-icon name="eye-off" class="size-[18px] eye-closed hidden"/>
                    </button>
                </div>
            </div>
        </div>

        <button type="submit" class="btn-ink mt-6">
            <x-icon name="check" class="size-4"/>
            Simpan Perubahan
        </button>
    </form>
@endsection
