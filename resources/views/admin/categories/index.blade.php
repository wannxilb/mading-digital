@extends('layouts.admin')

@section('title', 'Kelola Kategori')
@section('heading', 'Kelola Kategori')

@section('content')
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="reveal card border-2 p-6 lg:col-span-2">
            <h2 class="font-display text-lg font-bold text-ink">Daftar Kategori</h2>
            <p class="mt-1 text-xs font-semibold text-ink-3">Kategori yang dipakai untuk berita dan artikel.</p>

            <div class="mt-5 grid gap-4 sm:grid-cols-2">
                @forelse ($categories as $category)
                    <div class="flex items-center gap-4 rounded-brutal border-2 border-ink bg-paper p-4">
                        <span class="grid size-11 shrink-0 place-items-center rounded-brutal border-2 border-ink bg-acid text-ink">
                            <x-icon :name="$category->icon" class="size-5"/>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="font-bold text-ink">{{ $category->name }}</p>
                            <p class="mt-0.5 text-xs font-semibold text-ink-3">
                                {{ $category->posts_count }} berita · {{ $category->articles_count }} artikel
                            </p>
                        </div>
                        <button type="button" onclick="editCategory({{ $category->toJson() }})" class="grid size-8 shrink-0 place-items-center rounded-brutal border-2 border-ink bg-cream text-ink transition-colors hover:bg-acid" title="Edit">
                            <x-icon name="edit" class="size-3.5"/>
                        </button>
                    </div>
                @empty
                    <p class="col-span-full py-12 text-center text-sm text-ink-2">Belum ada kategori.</p>
                @endforelse
            </div>
        </div>

        <div class="space-y-6">
            <div class="reveal card border-2 p-6" style="transition-delay:.05s">
                <h2 class="font-display text-lg font-bold text-ink" id="form-title">Tambah Kategori</h2>

                <form method="POST" action="{{ route('admin.kategori.store') }}" id="category-form" class="mt-5">
                    @csrf

                    <div>
                        <label for="name" class="label">Nama Kategori</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" maxlength="60" required class="field mt-2">
                        @error('name')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
                    </div>

                    <div class="mt-5">
                        <label for="description" class="label">Deskripsi <span class="font-normal normal-case text-ink-3">(opsional)</span></label>
                        <textarea id="description" name="description" rows="2" maxlength="200" class="field mt-2">{{ old('description') }}</textarea>
                    </div>

                    <div class="mt-5">
                        <span class="label">Icon</span>
                        <div class="mt-2 grid grid-cols-5 gap-2" id="icon-picker">
                            @foreach (['megaphone', 'trophy', 'calendar', 'palette', 'book', 'sparkle', 'chart', 'users', 'pen', 'activity'] as $icon)
                                <label class="icon-option flex cursor-pointer flex-col items-center gap-1 rounded-brutal border-2 border-ink/20 bg-cream p-2.5 text-ink transition-colors hover:border-ink has-[:checked]:border-ink has-[:checked]:bg-acid">
                                    <input type="radio" name="icon" value="{{ $icon }}" class="peer sr-only">
                                    <x-icon :name="$icon" class="size-5"/>
                                </label>
                            @endforeach
                        </div>
                        @error('icon')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="btn-ink mt-6 w-full">
                        <x-icon name="check" class="size-4"/>
                        Simpan Kategori
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editCategory = (category) => {
                const form = document.getElementById('category-form');
                form.action = `/admin/kategori/${category.id}`;
                form.querySelector('input[name="_method"]')?.remove();
                form.insertAdjacentHTML('afterbegin', '<input type="hidden" name="_method" value="PUT">');
                form.querySelector('input[name="name"]').value = category.name;
                form.querySelector('textarea[name="description"]').value = category.description || '';
                form.querySelector('input[name="icon"][value="' + category.icon + '"]').checked = true;
                document.getElementById('form-title').textContent = 'Edit Kategori';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            };
            window.editCategory = editCategory;
        });
    </script>
@endpush
