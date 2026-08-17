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
                <a href="{{ route('admin.pengguna.create') }}" class="btn-red">
                    <x-icon name="plus" class="size-4"/>
                    Tambah Pengguna
                </a>
            </div>
        </div>

        <div class="grid gap-4 p-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($users as $user)
                <div class="flex items-center gap-4 rounded-brutal border-2 border-ink bg-paper p-4">
                    <span class="grid size-12 shrink-0 place-items-center rounded-brutal border-2 border-ink {{ $user->isAdmin() ? 'bg-acid' : ($user->isGuru() ? 'bg-blue text-cream' : 'bg-green text-cream') }} font-display text-lg font-bold">
                        {{ collect(explode(' ', $user->name))->filter()->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->take(2)->implode('') }}
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-bold text-ink">{{ $user->name }}</p>
                        <p class="truncate text-xs font-semibold text-ink-3">{{ $user->email }}</p>
                        <div class="mt-1.5 flex flex-wrap items-center gap-1.5">
                            <span class="{{ $user->isAdmin() ? 'tag-amber' : ($user->isGuru() ? 'tag-blue' : 'tag-green') }} !text-[10px]">{{ $user->role_label }}</span>
                            @if ($user->class)
                                <span class="chip !px-2 !py-0.5 !text-[10px]">{{ $user->class }}</span>
                            @endif
                            @if ($user->is_active)
                                <span class="tag-green !text-[10px]">Aktif</span>
                            @else
                                <span class="tag-gray !text-[10px]">Nonaktif</span>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('admin.pengguna.edit', $user) }}" class="grid size-9 shrink-0 place-items-center rounded-brutal border-2 border-ink bg-cream text-ink transition-colors hover:bg-acid" title="Edit">
                        <x-icon name="edit" class="size-3.5"/>
                    </a>
                </div>
            @empty
                <div class="col-span-full px-5 py-16 text-center">
                    <x-icon name="users" class="mx-auto size-10 text-ink-3"/>
                    <p class="mt-3 font-display font-bold text-ink">Tidak ada pengguna</p>
                </div>
            @endforelse
        </div>

        <div class="border-t-2 border-ink/10 p-5">
            {{ $users->links() }}
        </div>
    </div>
@endsection
