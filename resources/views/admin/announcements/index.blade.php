@extends('layouts.admin')

@section('title', 'Kelola Pengumuman')
@section('heading', 'Kelola Pengumuman')

@section('content')
    <div class="reveal card overflow-hidden border-2">
        <div class="flex flex-col gap-4 border-b-2 border-ink/10 p-5 sm:flex-row sm:items-center">
            <form method="GET" action="{{ route('admin.pengumuman.index') }}" class="relative max-w-sm flex-1">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari judul pengumuman…" class="field !border-2 !py-2.5 pl-10" aria-label="Cari pengumuman">
                <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-ink-3"/>
            </form>
            <a href="{{ route('admin.pengumuman.create') }}" class="btn-red shrink-0">
                <x-icon name="plus" class="size-4"/>
                Buat Pengumuman
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b-2 border-ink bg-paper">
                        <th class="table-th">Judul</th>
                        <th class="table-th hidden md:table-cell">Prioritas</th>
                        <th class="table-th hidden sm:table-cell">Status</th>
                        <th class="table-th hidden text-right lg:table-cell">Masa Berlaku</th>
                        <th class="table-th text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-ink/10">
                    @forelse ($announcements as $announcement)
                        <tr class="transition-colors hover:bg-paper/60">
                            <td class="px-5 py-4">
                                <p class="max-w-xs font-bold text-ink line-clamp-1">
                                    @if ($announcement->is_pinned) <span class="tag-ink mr-1">PIN</span>@endif
                                    {{ $announcement->title }}
                                </p>
                                <p class="mt-1 text-xs font-semibold text-ink-3 line-clamp-1">{{ $announcement->content }}</p>
                            </td>
                            <td class="px-5 py-4 hidden md:table-cell">
                                <span class="{{ $announcement->priority === 'mendesak' ? 'tag-red' : ($announcement->priority === 'penting' ? 'tag-amber' : 'tag-gray') }}">{{ $announcement->priority_label }}</span>
                            </td>
                            <td class="px-5 py-4 hidden sm:table-cell">
                                @if ($announcement->status === 'aktif')
                                    <span class="tag-green">Aktif</span>
                                @elseif ($announcement->status === 'draft')
                                    <span class="tag-amber">Draft</span>
                                @else
                                    <span class="tag-gray">Arsip</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right hidden lg:table-cell">
                                <span class="text-xs font-semibold text-ink-2">
                                    @if ($announcement->start_date) {{ $announcement->start_date->translatedFormat('d M Y') }} @else — @endif
                                    @if ($announcement->end_date) s.d. {{ $announcement->end_date->translatedFormat('d M Y') }} @endif
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.pengumuman.edit', $announcement) }}" class="grid size-8 place-items-center rounded-brutal border-2 border-ink bg-cream text-ink transition-colors hover:bg-acid" title="Edit">
                                        <x-icon name="edit" class="size-3.5"/>
                                    </a>
                                    <form method="POST" action="{{ route('admin.pengumuman.destroy', $announcement) }}" onsubmit="return confirm('Hapus pengumuman ini? Tindakan tidak bisa dibatalkan.')">
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
                                <x-icon name="megaphone" class="mx-auto size-10 text-ink-3"/>
                                <p class="mt-3 font-display font-bold text-ink">Belum ada pengumuman</p>
                                <p class="mt-1 text-sm text-ink-2">Buat pengumuman pertama untuk papan info sekolah.</p>
                                <a href="{{ route('admin.pengumuman.create') }}" class="btn-ink mt-5">Buat Pengumuman</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t-2 border-ink/10 p-5">
            {{ $announcements->links() }}
        </div>
    </div>
@endsection
