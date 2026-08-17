@extends('layouts.admin')

@section('title', 'Masuk')
@section('heading', 'Masuk Panel')

@section('content')
    <div class="grid min-h-[80vh] place-items-center px-4">
        <div class="w-full max-w-md">
            <div class="reveal text-center">
                <span class="inline-grid size-16 place-items-center rounded-brutal border-2 border-ink bg-ink font-display text-2xl font-bold text-acid shadow-brutal">MD</span>
                <h1 class="mt-5 font-display text-2xl font-bold tracking-tight text-ink">Masuk ke akun</h1>
                <p class="mt-2 text-sm text-ink-2">Admin masuk ke panel pengelola, guru dan siswa masuk sebagai pengguna situs.</p>
            </div>

            <form method="POST" action="{{ route('admin.login.attempt') }}" class="reveal card mt-8 border-2 border-ink p-6 shadow-brutal-sm sm:p-8" style="transition-delay:.1s">
                @csrf

                @if ($errors->any())
                    <div class="mb-5 rounded-brutal border-2 border-accent bg-accent/10 px-4 py-3 text-sm font-bold text-accent">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div>
                    <label for="email" class="label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="field mt-2">
                </div>

                <div class="mt-5">
                    <label for="password" class="label">Kata Sandi</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password" class="field mt-2">
                </div>

                <div class="mt-5 flex items-center justify-between">
                    <label class="flex cursor-pointer items-center gap-2 text-sm font-semibold text-ink-2">
                        <input type="checkbox" name="remember" class="size-4 rounded-brutal border-2 border-ink accent-acid">
                        Ingat saya
                    </label>
                    <a href="{{ route('home') }}" class="btn-ghost text-xs">← Kembali</a>
                </div>

                <button type="submit" class="btn-ink mt-6 w-full !py-3.5">
                    Masuk
                    <x-icon name="arrow-right" class="size-4"/>
                </button>
            </form>

            <div class="reveal mt-6 rounded-brutal border-2 border-ink bg-acid/20 px-5 py-4 text-center text-xs font-semibold text-ink-2" style="transition-delay:.15s">
                <p class="font-bold text-ink">Akun demo admin</p>
                <p class="mt-1">Email: <code class="font-bold text-ink">admin@mading.sch.id</code> · Sandi: <code class="font-bold text-ink">admin123</code></p>
            </div>
        </div>
    </div>
@endsection
