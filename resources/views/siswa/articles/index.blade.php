@extends('layouts.siswa')

@section('title', 'Karya Saya')
@section('heading', 'Karya Saya')

@section('content')
    <div class="flex items-center justify-between">
        <p class="text-sm font-semibold text-ink-2">Semua karya yang telah kamu tulis</p>
        <a href="{{ route('siswa.karya.create') }}" class="btn-red">
            <x-icon name="plus" class="size-4"/>
            Tulis Karya
        </a>
    </div>

    <div class="mt-6 card overflow-hidden border-2">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b-2 border-ink bg-paper">
                        <th class="table-th">Judul</th>
                        <th class="table-th hidden sm:table-cell">Status</th>
                        <th class="table-th hidden md:table-cell">Dibaca</th>
                        <th class="table-th text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-ink/10">
                    @forelse ($articles as $article)
                        <tr class="transition-colors hover:bg-paper/60">
                            <td class="px-5 py-4">
                                <p class="max-w-xs font-bold text-ink line-clamp-1">{{ $article->title }}</p>
                                <p class="mt-1 text-xs font-semibold text-ink-3">{{ $article->category?->name }} · {{ $article->display_date }}</p>
                                @if ($article->review_note)
                                    <p class="mt-1 text-xs text-accent line-clamp-1">Catatan: {{ $article->review_note }}</p>
                                @endif
                            </td>
                            <td class="px-5 py-4 hidden sm:table-cell">
                                @if ($article->status === 'published')
                                    <span class="tag-green">Published</span>
                                @elseif ($article->status === 'review')
                                    <span class="tag-amber">Review</span>
                                @elseif ($article->status === 'archived')
                                    <span class="tag-gray">Arsip</span>
                                @else
                                    <span class="tag-gray">Draft</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right text-xs font-semibold text-ink-2 hidden md:table-cell">{{ number_format($article->views) }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('siswa.karya.show', $article) }}" class="grid size-8 place-items-center rounded-brutal border-2 border-ink bg-cream text-ink transition-colors hover:bg-acid" title="Lihat">
                                        <x-icon name="eye" class="size-3.5"/>
                                    </a>
                                    @if (in_array($article->status, ['draft', 'review'], true))
                                        <a href="{{ route('siswa.karya.edit', $article) }}" class="grid size-8 place-items-center rounded-brutal border-2 border-ink bg-cream text-ink transition-colors hover:bg-acid" title="Edit">
                                            <x-icon name="edit" class="size-3.5"/>
                                        </a>
                                        <form method="POST" action="{{ route('siswa.karya.destroy', $article) }}" onsubmit="return confirm('Hapus karya ini? Tindakan tidak bisa dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="grid size-8 place-items-center rounded-brutal border-2 border-accent bg-cream text-accent transition-colors hover:bg-accent hover:text-cream" title="Hapus">
                                                <x-icon name="trash" class="size-3.5"/>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-16 text-center">
                                <x-icon name="pen" class="mx-auto size-10 text-ink-3"/>
                                <p class="mt-3 font-display font-bold text-ink">Belum ada karya</p>
                                <p class="mt-1 text-sm text-ink-2">Mulai tulis karya pertamamu untuk mading digital.</p>
                                <a href="{{ route('siswa.karya.create') }}" class="btn-ink mt-5">Tulis Karya</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t-2 border-ink/10 p-5">
            {{ $articles->links() }}
        </div>
    </div>
@endsection
