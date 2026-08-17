@extends('layouts.admin')

@section('title', 'Kelola Prestasi')
@section('heading', 'Kelola Prestasi')

@section('content')
    <div class="reveal card overflow-hidden border-2">
        <div class="flex flex-col gap-4 border-b-2 border-ink/10 p-5 sm:flex-row sm:items-center">
            <form method="GET" action="{{ route('admin.prestasi.index') }}" class="relative max-w-sm flex-1">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama atau lomba…" class="field !border-2 !py-2.5 pl-10" aria-label="Cari prestasi">
                <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-ink-3"/>
            </form>
            <a href="{{ route('admin.prestasi.create') }}" class="btn-red shrink-0">
                <x-icon name="plus" class="size-4"/>
                Tambah Prestasi
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b-2 border-ink bg-paper">
                        <th class="table-th">Prestasi</th>
                        <th class="table-th hidden md:table-cell">Penerima</th>
                        <th class="table-th hidden sm:table-cell">Peringkat</th>
                        <th class="table-th hidden lg:table-cell">Tingkat</th>
                        <th class="table-th hidden text-right lg:table-cell">Tanggal</th>
                        <th class="table-th text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-ink/10">
                    @forelse ($achievements as $achievement)
                        <tr class="transition-colors hover:bg-paper/60">
                            <td class="px-5 py-4">
                                <p class="max-w-xs font-bold text-ink line-clamp-1">{{ $achievement->title }}</p>
                                <p class="mt-1 text-xs font-semibold text-ink-3 line-clamp-1">{{ $achievement->competition_name }}</p>
                            </td>
                            <td class="px-5 py-4 hidden md:table-cell">
                                <span class="text-sm font-semibold text-ink-2">{{ $achievement->student_name ?: '—' }}@if ($achievement->class) <span class="text-xs text-ink-3">({{ $achievement->class }})</span>@endif</span>
                            </td>
                            <td class="px-5 py-4 hidden sm:table-cell">
                                <span class="tag-ink">{{ $achievement->rank ?: '—' }}</span>
                            </td>
                            <td class="px-5 py-4 hidden lg:table-cell">
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-ink-2">
                                    <x-icon name="globe" class="size-3.5 text-accent"/>
                                    {{ $achievement->level_label }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right hidden lg:table-cell">
                                <span class="text-xs font-semibold text-ink-2">{{ $achievement->date_label }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.prestasi.edit', $achievement) }}" class="grid size-8 place-items-center rounded-brutal border-2 border-ink bg-cream text-ink transition-colors hover:bg-acid" title="Edit">
                                        <x-icon name="edit" class="size-3.5"/>
                                    </a>
                                    <form method="POST" action="{{ route('admin.prestasi.destroy', $achievement) }}" onsubmit="return confirm('Hapus prestasi ini? Tindakan tidak bisa dibatalkan.')">
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
                            <td colspan="6" class="px-5 py-16 text-center">
                                <x-icon name="award" class="mx-auto size-10 text-ink-3"/>
                                <p class="mt-3 font-display font-bold text-ink">Belum ada prestasi</p>
                                <p class="mt-1 text-sm text-ink-2">Catat pencapaian siswa dan sekolah di sini.</p>
                                <a href="{{ route('admin.prestasi.create') }}" class="btn-ink mt-5">Tambah Prestasi</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t-2 border-ink/10 p-5">
            {{ $achievements->links() }}
        </div>
    </div>
@endsection
