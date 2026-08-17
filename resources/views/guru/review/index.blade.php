@extends('layouts.guru')

@section('title', 'Review Artikel')
@section('heading', 'Review Artikel')

@section('content')
    <div class="reveal card overflow-hidden border-2">
        <div class="flex flex-col gap-4 border-b-2 border-ink/10 p-5 sm:flex-row sm:items-center">
            <form method="GET" action="{{ route('guru.review.index') }}" class="flex items-center gap-1.5">
                <select name="status" onchange="this.form.submit()" class="field !w-auto !border-2 !py-2.5 text-xs">
                    <option value="">Semua Status</option>
                    @foreach ($statuses as $key => $label)
                        <option value="{{ $key }}" {{ $activeStatus === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b-2 border-ink bg-paper">
                        <th class="table-th">Judul</th>
                        <th class="table-th hidden md:table-cell">Penulis</th>
                        <th class="table-th hidden sm:table-cell">Status</th>
                        <th class="table-th text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-ink/10">
                    @forelse ($articles as $article)
                        <tr class="transition-colors hover:bg-paper/60">
                            <td class="px-5 py-4">
                                <p class="max-w-xs font-bold text-ink line-clamp-1">{{ $article->title }}</p>
                                <p class="mt-1 text-xs font-semibold text-ink-3">{{ $article->category?->name }} · {{ $article->display_date }}</p>
                            </td>
                            <td class="px-5 py-4 hidden md:table-cell">
                                <span class="text-sm font-semibold text-ink-2">{{ $article->author }}@if ($article->class) <span class="text-xs text-ink-3">({{ $article->class }})</span>@endif</span>
                                @if ($article->user)
                                    <p class="text-xs text-ink-3">{{ $article->user->email }}</p>
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
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('guru.review.show', $article) }}" class="grid size-8 place-items-center rounded-brutal border-2 border-ink bg-cream text-ink transition-colors hover:bg-acid" title="Review">
                                        <x-icon name="eye" class="size-3.5"/>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-16 text-center">
                                <x-icon name="pen" class="mx-auto size-10 text-ink-3"/>
                                <p class="mt-3 font-display font-bold text-ink">Tidak ada artikel</p>
                                <p class="mt-1 text-sm text-ink-2">Tidak ada artikel yang sesuai dengan filter.</p>
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
