@extends('layouts.admin')

@section('title', 'Masuk')
@section('heading', 'Masuk Admin')

@section('content')
    <div class="min-h-[80vh] grid place-items-center px-4">
        <div class="w-full max-w-md">
            <div class="reveal text-center">
                <span class="inline-grid place-items-center size-16 rounded-3xl bg-gradient-to-br from-navy-800 to-royal-600 text-white shadow-glow">
                    <svg class="size-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 19a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2"/><path d="M5 17V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v12"/><path d="M9 8h6M9 12h4"/></svg>
                </span>
                <h1 class="mt-5 font-display text-2xl font-extrabold tracking-tight text-navy-900">Selamat datang kembali</h1>
                <p class="mt-2 text-sm text-navy-900/55">Masuk untuk mengelola majalah dinding sekolah.</p>
            </div>

            <form method="POST" action="{{ route('admin.login.attempt') }}" class="reveal mt-8 rounded-3xl bg-white p-6 sm:p-8 shadow-soft ring-1 ring-navy-900/5" style="transition-delay:.1s">
                @csrf

                @if ($errors->any())
                    <div class="mb-5 rounded-2xl bg-red-50 px-4 py-3 text-sm font-medium text-red-700 ring-1 ring-red-200">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div>
                    <label for="email" class="block text-sm font-bold text-navy-900">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                           class="mt-2 w-full rounded-xl border-0 bg-ice-50 px-4 py-3 text-sm font-medium text-navy-900 ring-1 ring-navy-900/10 placeholder:text-navy-900/35 focus:outline-none focus:ring-2 focus:ring-royal-500">
                </div>

                <div class="mt-5">
                    <label for="password" class="block text-sm font-bold text-navy-900">Kata Sandi</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password"
                           class="mt-2 w-full rounded-xl border-0 bg-ice-50 px-4 py-3 text-sm font-medium text-navy-900 ring-1 ring-navy-900/10 placeholder:text-navy-900/35 focus:outline-none focus:ring-2 focus:ring-royal-500">
                </div>

                <div class="mt-5 flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm font-medium text-navy-900/70">
                        <input type="checkbox" name="remember" class="size-4 rounded border-navy-900/20 text-royal-600 focus:ring-royal-500">
                        Ingat saya
                    </label>
                    <a href="{{ route('home') }}" class="text-sm font-bold text-royal-600 hover:text-navy-900">← Kembali</a>
                </div>

                <button type="submit" class="group mt-6 flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-br from-navy-800 to-royal-600 px-6 py-4 text-sm font-bold text-white shadow-glow transition-all duration-300 hover:-translate-y-0.5">
                    Masuk ke Panel
                    <x-icon name="arrow-right" class="size-4 transition-transform group-hover:translate-x-1"/>
                </button>
            </form>

            <div class="reveal mt-6 rounded-2xl bg-ice-100 px-5 py-4 text-center text-xs text-navy-900/60" style="transition-delay:.15s">
                <p class="font-semibold text-navy-900/70">Akun demo admin</p>
                <p class="mt-1">Email: <code class="font-bold text-royal-600">admin@mading.sch.id</code> · Sandi: <code class="font-bold text-royal-600">admin123</code></p>
            </div>
        </div>
    </div>
@endsection
