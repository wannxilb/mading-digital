@extends('layouts.app')

@section('title', 'Agenda Sekolah')
@section('meta_description', 'Kegiatan dan agenda yang akan berlangsung di sekolah.')

@section('content')
    <section class="border-b-2 border-ink">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 pt-28 sm:pt-32 pb-10">
            <h1 class="font-display text-4xl font-bold tracking-tight text-ink sm:text-5xl">Agenda Sekolah</h1>
            <p class="mt-3 max-w-xl text-sm leading-relaxed text-ink-2 sm:text-base">Kegiatan yang akan datang: upacara, lomba, rapat, ekstrakurikuler, dan lainnya.</p>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 sm:px-6 py-12 sm:py-16">
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($upcoming as $event)
                <x-event-card :event="$event" />
            @empty
                <div class="col-span-full card grid place-items-center py-20 text-center">
                    <x-icon name="calendar" class="size-12 text-ink-3"/>
                    <p class="mt-4 font-display text-lg font-bold text-ink">Belum ada agenda mendatang</p>
                    <p class="mt-1 max-w-sm text-sm text-ink-2">Agenda akan tampil di sini setelah ditambahkan.</p>
                </div>
            @endforelse
        </div>

        @if ($upcoming->hasPages())
            <x-simple-pagination :paginator="$upcoming" />
        @endif

        @if ($past->isNotEmpty())
            <div class="mt-16">
                <p class="kicker mb-5">Arsip Kegiatan</p>
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($past as $event)
                        <x-event-card :event="$event" />
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection
