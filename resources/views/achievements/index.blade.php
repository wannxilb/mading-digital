@extends('layouts.app')

@section('title', 'Prestasi')
@section('meta_description', 'Prestasi siswa dan sekolah di berbagai ajang perlombaan.')

@section('content')
    <section class="border-b-2 border-ink">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 pt-28 sm:pt-32 pb-10">
            <h1 class="font-display text-4xl font-bold tracking-tight text-ink sm:text-5xl">Prestasi</h1>
            <p class="mt-3 max-w-xl text-sm leading-relaxed text-ink-2 sm:text-base">Juara lomba dan penghargaan yang diraih siswa di berbagai ajang.</p>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 sm:px-6 py-12 sm:py-16">
        <div class="mb-8 flex flex-wrap gap-2">
            <a href="{{ route('prestasi.index') }}" class="chip {{ ! $activeLevel ? '!border-ink !bg-blue !text-cream' : '' }}">Semua</a>
            @foreach ($levels as $key => $label)
                <a href="{{ route('prestasi.index', ['level' => $key]) }}" class="chip {{ $activeLevel === $key ? '!border-ink !bg-blue !text-cream' : '' }}">{{ $label }}</a>
            @endforeach
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($achievements as $achievement)
                <x-achievement-card :achievement="$achievement" />
            @empty
                <div class="col-span-full card grid place-items-center py-20 text-center">
                    <x-icon name="award" class="size-12 text-ink-3"/>
                    <p class="mt-4 font-display text-lg font-bold text-ink">Belum ada prestasi</p>
                    <p class="mt-1 text-sm text-ink-2">Prestasi siswa akan tampil di sini.</p>
                </div>
            @endforelse
        </div>

        @if ($achievements->hasPages())
            <x-simple-pagination :paginator="$achievements" />
        @endif
    </section>
@endsection
