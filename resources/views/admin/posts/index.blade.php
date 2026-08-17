@extends('layouts.admin')

@section('title', 'Kelola Berita')
@section('heading', 'Kelola Berita')

@section('content')
    <div class="reveal card overflow-hidden border-2">
        <div class="flex flex-col gap-4 border-b-2 border-ink/10 p-5 sm:flex-row sm:items-center">
            <form method="GET" action="{{ route('admin.berita.index') }}" class="relative max-w-sm flex-1">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari judul atau penulis…" class="field !border-2 !py-2.5 pl-10" aria-label="Cari berita">
                <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-ink-3"/>
            </form>
            <a href="{{ route('admin.berita.create') }}" class="btn-red shrink-0">
                <x-icon name="plus" class="size-4"/>
                Tulis Berita
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b-2 border-ink bg-paper">
                        <th class="table-th">Judul</th>
                        <th class="table-th hidden md:table-cell">Kategori</th>
                        <th class="table-th hidden sm:table-cell">Status</th>
                        <th class="table-th hidden text-right lg:table-cell">Dibaca</th>
                        <th class="table-th text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-ink/10">
                    @forelse ($posts as $post)
                        <tr class="transition-colors hover:bg-paper/60">
                            <td class="px-5 py-4">
                                <p class="max-w-xs font-bold text-ink line-clamp-1">{{ $post->title }}</p>
                                <p class="mt-1 text-xs font-semibold text-ink-3">{{ $post->author }} · {{ $post->display_date }}</p>
                            </td>
                            <td class="px-5 py-4 hidden md:table-cell">
                                <span class="chip !border-ink/15">
                                    <x-icon :name="$post->category?->icon ?? 'sparkle'" class="size-3.5 text-accent"/>
                                    {{ $post->category?->name }}
                                </span>
                            </td>
                            <td class="px-5 py-4 hidden sm:table-cell">
                                @if ($post->is_published)
                                    <span class="tag-green">Tampil</span>
                                @else
                                    <span class="tag-amber">Draft</span>
                                @endif
                                @if ($post->is_featured)
                                    <span class="tag-ink ml-1">Unggulan</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right text-xs font-semibold text-ink-2 hidden lg:table-cell">{{ number_format($post->views) }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('berita.show', $post) }}" class="grid size-8 place-items-center rounded-brutal border-2 border-ink bg-cream text-ink transition-colors hover:bg-acid" title="Lihat">
                                        <x-icon name="eye" class="size-3.5"/>
                                    </a>
                                    <a href="{{ route('admin.berita.edit', $post) }}" class="grid size-8 place-items-center rounded-brutal border-2 border-ink bg-cream text-ink transition-colors hover:bg-acid" title="Edit">
                                        <x-icon name="edit" class="size-3.5"/>
                                    </a>
                                    <form method="POST" action="{{ route('admin.berita.destroy', $post) }}" onsubmit="return confirm('Hapus berita ini? Tindakan tidak bisa dibatalkan.')">
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
                                <x-icon name="book" class="mx-auto size-10 text-ink-3"/>
                                <p class="mt-3 font-display font-bold text-ink">Belum ada berita</p>
                                <p class="mt-1 text-sm text-ink-2">Mulai tulis berita pertama untuk papan mading.</p>
                                <a href="{{ route('admin.berita.create') }}" class="btn-ink mt-5">Tulis Berita</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t-2 border-ink/10 p-5">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
