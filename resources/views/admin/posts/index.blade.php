@extends('layouts.admin')

@section('title', 'Kelola Konten')
@section('heading', 'Kelola Konten')

@section('content')
    <div class="reveal rounded-3xl bg-white shadow-soft ring-1 ring-navy-900/5 overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4 p-6 border-b border-navy-900/5">
            <form method="GET" action="{{ route('admin.posts.index') }}" class="relative flex-1 max-w-sm">
                <x-icon name="search" class="pointer-events-none absolute left-4 top-1/2 size-4 -translate-y-1/2 text-navy-900/35"/>
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari judul atau penulis..."
                       class="w-full rounded-xl border-0 bg-ice-50 pl-10 pr-4 py-2.5 text-sm font-medium text-navy-900 ring-1 ring-navy-900/10 placeholder:text-navy-900/35 focus:outline-none focus:ring-2 focus:ring-royal-500">
            </form>
            <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-br from-navy-800 to-royal-600 px-4 py-2.5 text-sm font-bold text-white shadow-glow hover:opacity-95 transition-opacity">
                <x-icon name="plus" class="size-4"/>
                Tulis Cerita
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-ice-50/60 text-xs font-bold uppercase tracking-wider text-navy-900/45">
                        <th class="px-6 py-4">Judul</th>
                        <th class="px-6 py-4 hidden md:table-cell">Kategori</th>
                        <th class="px-6 py-4 hidden sm:table-cell">Status</th>
                        <th class="px-6 py-4 text-right hidden lg:table-cell">Dibaca</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-900/5">
                    @forelse ($posts as $post)
                        <tr class="hover:bg-ice-50/40 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-navy-900 line-clamp-1 max-w-xs">{{ $post->title }}</p>
                                <p class="mt-1 text-xs text-navy-900/45">{{ $post->author }} · {{ $post->display_date }}</p>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-ice-100 px-3 py-1 text-xs font-bold text-navy-800">
                                    <x-icon :name="$post->category?->icon ?? 'sparkle'" class="size-3.5 text-royal-600"/>
                                    {{ $post->category?->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 hidden sm:table-cell">
                                @if ($post->is_published)
                                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-bold text-emerald-600 ring-1 ring-emerald-200">Tampil</span>
                                @else
                                    <span class="rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-bold text-amber-600 ring-1 ring-amber-200">Draft</span>
                                @endif
                                @if ($post->is_featured)
                                    <span class="ml-1.5 rounded-full bg-sky-50 px-2.5 py-1 text-[11px] font-bold text-sky-600 ring-1 ring-sky-200">Unggulan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-xs font-semibold text-navy-900/55 hidden lg:table-cell">{{ number_format($post->views) }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('post.show', $post) }}" target="_blank" class="grid place-items-center size-8 rounded-lg bg-ice-100 text-navy-800 hover:bg-sky-100 transition-colors" title="Lihat">
                                        <x-icon name="eye" class="size-3.5"/>
                                    </a>
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="grid place-items-center size-8 rounded-lg bg-ice-100 text-navy-800 hover:bg-royal-600 hover:text-white transition-colors" title="Edit">
                                        <x-icon name="edit" class="size-3.5"/>
                                    </a>
                                    <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Hapus konten ini? Tindakan tidak bisa dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="grid place-items-center size-8 rounded-lg bg-ice-100 text-red-600 hover:bg-red-600 hover:text-white transition-colors" title="Hapus">
                                            <x-icon name="trash" class="size-3.5"/>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <x-icon name="folder" class="mx-auto size-10 text-royal-500/40"/>
                                <p class="mt-3 font-bold text-navy-900">Belum ada konten</p>
                                <p class="mt-1 text-sm text-navy-900/50">Mulai tulis cerita pertama untuk papan mading.</p>
                                <a href="{{ route('admin.posts.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-navy-900 px-4 py-2.5 text-xs font-bold text-white hover:bg-navy-800">
                                    <x-icon name="plus" class="size-3.5"/>
                                    Tulis Cerita
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-navy-900/5">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
