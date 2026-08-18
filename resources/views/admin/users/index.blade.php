@extends('layouts.admin')

@section('title', 'Kelola Pengguna')
@section('heading', 'Kelola Pengguna')

@section('content')
    <div class="reveal card overflow-hidden border-2">
        <div class="flex flex-col gap-4 border-b-2 border-ink/10 p-5 sm:flex-row sm:items-center">
            <form method="GET" action="{{ route('admin.pengguna.index') }}" class="relative max-w-sm flex-1">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email…" class="field !border-2 !py-2.5 pl-10" aria-label="Cari pengguna">
                <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-ink-3"/>
            </form>

            <div class="flex shrink-0 items-center gap-2">
                <form method="GET" action="{{ route('admin.pengguna.index') }}" class="flex items-center gap-1.5">
                    <select name="role" onchange="this.form.submit()" class="field !w-auto !border-2 !py-2.5 text-xs">
                        <option value="">Semua Peran</option>
                        @foreach ($roles as $key => $label)
                            <option value="{{ $key }}" {{ $activeRole === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </form>
                <a href="{{ route('admin.pengguna.import') }}" class="btn-outline">
                    <x-icon name="image" class="size-4"/>
                    Import CSV
                </a>
                <a href="{{ route('admin.pengguna.create') }}" class="btn-red">
                    <x-icon name="plus" class="size-4"/>
                    Tambah Pengguna
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b-2 border-ink bg-paper">
                        <th class="table-th">Pengguna</th>
                        <th class="table-th hidden md:table-cell">Peran</th>
                        <th class="table-th hidden sm:table-cell">Kelas / Jurusan</th>
                        <th class="table-th hidden sm:table-cell">Status</th>
                        <th class="table-th text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-ink/10">
                    @forelse ($users as $user)
                        <tr class="transition-colors hover:bg-paper/60">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="grid size-10 shrink-0 place-items-center rounded-brutal border-2 border-ink {{ $user->isAdmin() ? 'bg-acid' : 'bg-green text-cream' }} font-display text-sm font-bold">
                                        {{ collect(explode(' ', $user->name))->filter()->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->take(2)->implode('') }}
                                    </span>
                                    <div class="min-w-0">
                                        <p class="font-bold text-ink leading-snug">{{ $user->name }}</p>
                                        <p class="text-xs font-semibold text-ink-3 truncate">{{ $user->email }}</p>
                                        {{-- Khusus tampilan mobile / layar kecil --}}
                                        <div class="mt-1.5 flex flex-wrap items-center gap-1 sm:hidden">
                                            <span class="{{ $user->isAdmin() ? 'tag-amber' : 'tag-green' }} !text-[10px]">{{ $user->role_label }}</span>
                                            @if ($user->class)
                                                <span class="chip !px-1.5 !py-0.2 !text-[10px]">{{ $user->class }}</span>
                                            @endif
                                            @if ($user->jurusan)
                                                <span class="chip !px-1.5 !py-0.2 !text-[10px]">{{ strtoupper($user->jurusan) }}</span>
                                            @endif
                                            @if ($user->is_active)
                                                <span class="tag-green !text-[10px]">Aktif</span>
                                            @else
                                                <span class="tag-gray !text-[10px]">Nonaktif</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 hidden md:table-cell">
                                <span class="{{ $user->isAdmin() ? 'tag-amber' : 'tag-green' }}">{{ $user->role_label }}</span>
                            </td>
                            <td class="px-5 py-4 hidden sm:table-cell">
                                @if ($user->class || $user->jurusan)
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        @if ($user->class)
                                            <span class="chip !px-2 !py-0.5 !text-xs font-bold">{{ $user->class }}</span>
                                        @endif
                                        @if ($user->jurusan)
                                            <span class="chip !px-2 !py-0.5 !text-xs font-bold">{{ strtoupper($user->jurusan) }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs font-semibold text-ink-3">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 hidden sm:table-cell">
                                @if ($user->is_active)
                                    <span class="tag-green">Aktif</span>
                                @else
                                    <span class="tag-gray">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.pengguna.edit', $user) }}" class="grid size-8 place-items-center rounded-brutal border-2 border-ink bg-cream text-ink transition-colors hover:bg-acid" title="Edit">
                                        <x-icon name="edit" class="size-3.5"/>
                                    </a>
                                    @unless ($user->is(auth()->user()) || ($user->isAdmin() && $user->email === 'admin@mading.sch.id'))
                                        <form method="POST" action="{{ route('admin.pengguna.destroy', $user) }}" onsubmit="return confirm('Hapus akun {{ $user->name }}? Semua karya siswa juga akan terhapus.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="grid size-8 place-items-center rounded-brutal border-2 border-ink bg-cream text-ink transition-colors hover:bg-accent hover:text-white" title="Hapus">
                                                <x-icon name="trash" class="size-3.5"/>
                                            </button>
                                        </form>
                                    @endunless
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16 text-center">
                                <x-icon name="users" class="mx-auto size-10 text-ink-3"/>
                                <p class="mt-3 font-display font-bold text-ink">Tidak ada pengguna</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t-2 border-ink/10 p-5">
            {{ $users->links() }}
        </div>
    </div>
@endsection
