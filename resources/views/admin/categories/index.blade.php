@extends('layouts.admin')

@section('title', 'Kategori')
@section('heading', 'Kategori Halte Perjalanan')

@section('content')
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="reveal rounded-3xl bg-white shadow-soft ring-1 ring-navy-900/5 p-6">
            <h2 class="font-display font-extrabold text-lg text-navy-900">Tambah Kategori</h2>
            <p class="mt-1 text-xs text-navy-900/50">Kategori = halte dalam perjalanan mading.</p>

            <form method="POST" action="{{ route('admin.categories.store') }}" class="mt-6 space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-bold text-navy-900">Nama Kategori</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="mt-2 w-full rounded-xl border-0 bg-ice-50 px-4 py-3 text-sm font-medium text-navy-900 ring-1 ring-navy-900/10 focus:outline-none focus:ring-2 focus:ring-royal-500">
                    @error('name')<p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-navy-900">Ikon</label>
                    <div class="mt-2 grid grid-cols-5 gap-2">
                        @php $icons = ['megaphone', 'trophy', 'calendar', 'palette', 'book']; @endphp
                        @foreach ($icons as $icon)
                            <label class="flex cursor-pointer flex-col items-center gap-1 rounded-xl bg-ice-50 py-3 ring-1 ring-navy-900/5 transition-all has-checked:bg-royal-600 has-checked:text-white has-checked:ring-royal-600">
                                <x-icon :name="$icon" class="size-5"/>
                                <input type="radio" name="icon" value="{{ $icon }}" class="sr-only" {{ old('icon') === $icon ? 'checked' : ($loop->first ? 'checked' : '') }}>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-bold text-navy-900">Deskripsi <span class="font-normal text-navy-900/40">(opsional)</span></label>
                    <textarea id="description" name="description" rows="3" maxlength="200"
                              class="mt-2 w-full rounded-xl border-0 bg-ice-50 px-4 py-3 text-sm font-medium text-navy-900 ring-1 ring-navy-900/10 placeholder:text-navy-900/35 focus:outline-none focus:ring-2 focus:ring-royal-500">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-br from-navy-800 to-royal-600 px-6 py-3.5 text-sm font-bold text-white shadow-glow hover:opacity-95 transition-opacity">
                    <x-icon name="plus" class="size-4"/>
                    Tambah Kategori
                </button>
            </form>
        </div>

        <div class="reveal lg:col-span-2 rounded-3xl bg-white shadow-soft ring-1 ring-navy-900/5 p-6" style="transition-delay:.05s">
            <h2 class="font-display font-extrabold text-lg text-navy-900">Daftar Kategori</h2>

            <div class="mt-5 divide-y divide-navy-900/5">
                @forelse ($categories as $category)
                    <div class="flex items-center gap-4 py-4">
                        <span class="grid place-items-center size-11 shrink-0 rounded-2xl bg-gradient-to-br from-navy-800 to-royal-600 text-white">
                            <x-icon :name="$category->icon" class="size-5"/>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-bold text-navy-900">{{ $category->name }}</p>
                            <p class="mt-0.5 text-xs text-navy-900/50 line-clamp-1">{{ $category->description ?: '—' }}</p>
                            <p class="mt-1 text-[11px] font-bold text-royal-600">{{ $category->posts_count }} cerita</p>
                        </div>

                        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="hidden sm:flex items-center gap-2">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $category->name }}" required
                                   class="w-32 rounded-lg border-0 bg-ice-50 px-3 py-2 text-xs font-medium text-navy-900 ring-1 ring-navy-900/10 focus:outline-none focus:ring-2 focus:ring-royal-500">
                            <input type="hidden" name="icon" value="{{ $category->icon }}">
                            <button type="submit" class="grid place-items-center size-8 shrink-0 rounded-lg bg-ice-100 text-navy-800 hover:bg-royal-600 hover:text-white transition-colors" title="Simpan nama">
                                <x-icon name="check" class="size-3.5"/>
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                              onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="grid place-items-center size-8 shrink-0 rounded-lg bg-ice-100 text-red-600 hover:bg-red-600 hover:text-white transition-colors" title="Hapus">
                                <x-icon name="trash" class="size-3.5"/>
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="py-10 text-center text-sm text-navy-900/50">Belum ada kategori.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
