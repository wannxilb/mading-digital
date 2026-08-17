@extends('layouts.admin')

@section('title', 'Kelola Agenda')
@section('heading', 'Kelola Agenda')

@section('content')
    <div class="reveal card overflow-hidden border-2">
        <div class="flex flex-col gap-4 border-b-2 border-ink/10 p-5 sm:flex-row sm:items-center">
            <form method="GET" action="{{ route('admin.agenda.index') }}" class="relative max-w-sm flex-1">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari judul agenda…" class="field !border-2 !py-2.5 pl-10" aria-label="Cari agenda">
                <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-ink-3"/>
            </form>

            <div class="flex shrink-0 items-center gap-2">
                <form method="GET" action="{{ route('admin.agenda.index') }}" class="flex items-center gap-1.5">
                    <select name="period" onchange="this.form.submit()" class="field !w-auto !border-2 !py-2.5 text-xs">
                        <option value="" {{ ! request('period') ? 'selected' : '' }}>Semua</option>
                        <option value="mendatang" {{ request('period') === 'mendatang' ? 'selected' : '' }}>Akan Datang</option>
                        <option value="riwayat" {{ request('period') === 'riwayat' ? 'selected' : '' }}>Telah Lewat</option>
                    </select>
                </form>
                <a href="{{ route('admin.agenda.create') }}" class="btn-red">
                    <x-icon name="plus" class="size-4"/>
                    Tambah Agenda
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b-2 border-ink bg-paper">
                        <th class="table-th">Agenda</th>
                        <th class="table-th hidden sm:table-cell">Waktu</th>
                        <th class="table-th hidden lg:table-cell">Lokasi</th>
                        <th class="table-th hidden md:table-cell">Status</th>
                        <th class="table-th text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-ink/10">
                    @forelse ($events as $event)
                        <tr class="transition-colors hover:bg-paper/60">
                            <td class="px-5 py-4">
                                <p class="max-w-xs font-bold text-ink line-clamp-1">{{ $event->title }}</p>
                                <p class="mt-1 text-xs font-semibold text-ink-3 line-clamp-1">{{ $event->description }}</p>
                            </td>
                            <td class="px-5 py-4 hidden sm:table-cell">
                                <p class="font-bold text-ink">{{ $event->event_date->translatedFormat('d M Y') }}</p>
                                <p class="mt-0.5 text-xs font-semibold text-ink-3">
                                    @if ($event->start_time) {{ \Illuminate\Support\Carbon::parse($event->start_time)->format('H.i') }}@endif
                                    @if ($event->end_time) – {{ \Illuminate\Support\Carbon::parse($event->end_time)->format('H.i') }}@endif
                                    @if (!$event->start_time && !$event->end_time) <span class="text-ink-3">Sepanjang hari</span>@endif
                                </p>
                            </td>
                            <td class="px-5 py-4 hidden lg:table-cell">
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-ink-2">
                                    <x-icon name="location" class="size-3.5 text-accent"/>
                                    {{ $event->location ?: '—' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 hidden md:table-cell">
                                @if ($event->status_label === 'Akan Datang')
                                    <span class="tag-blue">Akan Datang</span>
                                @elseif ($event->status_label === 'Berlangsung')
                                    <span class="tag-green">Berlangsung</span>
                                @else
                                    <span class="tag-gray">Selesai</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.agenda.edit', $event) }}" class="grid size-8 place-items-center rounded-brutal border-2 border-ink bg-cream text-ink transition-colors hover:bg-acid" title="Edit">
                                        <x-icon name="edit" class="size-3.5"/>
                                    </a>
                                    <form method="POST" action="{{ route('admin.agenda.destroy', $event) }}" onsubmit="return confirm('Hapus agenda ini? Tindakan tidak bisa dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="grid size-8 place-items-center rounded-brutal border-2 border-accent bg-cream text-accent transition-colors hover:bg-accent hover:text-cream" title="Hapus">
                                            <x-icon name="trash" class="size-3.5"/>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16 text-center">
                                <x-icon name="calendar" class="mx-auto size-10 text-ink-3"/>
                                <p class="mt-3 font-display font-bold text-ink">Belum ada agenda</p>
                                <p class="mt-1 text-sm text-ink-2">Tambahkan agenda sekolah untuk kalender kegiatan.</p>
                                <a href="{{ route('admin.agenda.create') }}" class="btn-ink mt-5">Tambah Agenda</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t-2 border-ink/10 p-5">
            {{ $events->links() }}
        </div>
    </div>
@endsection
