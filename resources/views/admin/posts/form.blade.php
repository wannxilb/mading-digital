@extends('layouts.admin')

@php $post = $post ?? null; @endphp

@section('title', isset($post) ? 'Edit Berita' : 'Tulis Berita')
@section('heading', isset($post) ? 'Edit Berita' : 'Tulis Berita')

@section('content')
    <form method="POST" action="{{ isset($post) ? route('admin.berita.update', $post) : route('admin.berita.store') }}" enctype="multipart/form-data" class="max-w-4xl">
        @csrf
        @if (isset($post))
            @method('PUT')
        @endif

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <div class="reveal card border-2 p-6 sm:p-8">
                    <h2 class="font-display text-lg font-bold text-ink">Isi Berita</h2>

                    <div class="mt-6">
                        <label for="title" class="label">Judul</label>
                        <p class="mt-1 text-[11px] text-ink-3">Judul berita yang jelas dan ringkas.</p>
                        <input type="text" id="title" name="title" value="{{ old('title', $post->title ?? '') }}" required class="field mt-2">
                        @error('title')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
                    </div>

                    <div class="mt-5">
                        <label for="author" class="label">Penulis</label>
                        <p class="mt-1 text-[11px] text-ink-3">Nama penulis berita. Default: nama admin yang login.</p>
                        <input type="text" id="author" name="author" value="{{ old('author', $post->author ?? auth()->user()->name) }}" required class="field mt-2">
                        @error('author')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
                    </div>

                    <div class="mt-5">
                        <label for="excerpt" class="label">Ringkasan <span class="font-normal normal-case text-ink-3">(opsional)</span></label>
                        <p class="mt-1 text-[11px] text-ink-3">Ringkasan singkat (maks 300 karakter) yang tampil di kartu berita.</p>
                        <textarea id="excerpt" name="excerpt" rows="2" maxlength="300" class="field mt-2">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                    </div>

                    <div class="mt-5">
                        <label for="body" class="label">Isi Berita <span class="font-normal normal-case text-ink-3">— mendukung markdown</span></label>
                        <p class="mt-1 text-[11px] text-ink-3">Tulis isi berita di sini. Mendukung format <strong>markdown</strong> untuk tebal, miring, daftar, dan kutipan.</p>
                        <textarea id="body" name="body" rows="14" required class="field mt-2 font-mono text-[13px] leading-relaxed">{{ old('body', $post->body ?? '') }}</textarea>
                        @error('body')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
                        <div class="mt-3 flex flex-wrap gap-2 text-[11px] font-semibold text-ink-2">
                            <span class="rounded-brutal border border-ink/20 bg-paper px-2.5 py-1">**tebal**</span>
                            <span class="rounded-brutal border border-ink/20 bg-paper px-2.5 py-1">- poin</span>
                            <span class="rounded-brutal border border-ink/20 bg-paper px-2.5 py-1">> kutipan</span>
                            <span class="rounded-brutal border border-ink/20 bg-paper px-2.5 py-1">![](url-gambar)</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="reveal card border-2 p-6" style="transition-delay:.05s">
                    <h2 class="font-display text-lg font-bold text-ink">Atur & Terbitkan</h2>

                    <div class="mt-5">
                        <label for="category_id" class="label">Kategori</label>
                        <select id="category_id" name="category_id" required class="field mt-2">
                            <option value="" disabled {{ ! old('category_id', $post->category_id ?? '') ? 'selected' : '' }}>Pilih kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
                    </div>

                    <div class="mt-5 space-y-3.5">
                        <label class="flex cursor-pointer items-center justify-between gap-3 rounded-brutal border-2 border-ink/15 bg-paper px-4 py-3.5">
                            <span>
                                <span class="block text-sm font-bold text-ink">Tampilkan</span>
                                <span class="text-xs font-semibold text-ink-3">Berita muncul di papan publik</span>
                            </span>
                            <input type="hidden" name="is_published" value="0">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $post->is_published ?? true) ? 'checked' : '' }} class="size-5 rounded-brutal border-2 border-ink accent-ink">
                        </label>

                        <label class="flex cursor-pointer items-center justify-between gap-3 rounded-brutal border-2 border-ink/15 bg-paper px-4 py-3.5">
                            <span>
                                <span class="block text-sm font-bold text-ink">Jadikan unggulan</span>
                                <span class="text-xs font-semibold text-ink-3">Tampil sebagai "Berita Utama" di beranda</span>
                            </span>
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $post->is_featured ?? false) ? 'checked' : '' }} class="size-5 rounded-brutal border-2 border-ink accent-ink">
                        </label>
                    </div>

                    <button type="submit" class="btn-ink mt-6 w-full !py-3.5">
                        <x-icon name="check" class="size-4"/>
                        {{ isset($post) ? 'Simpan Perubahan' : 'Terbitkan Berita' }}
                    </button>
                </div>

                <div class="reveal card border-2 p-6" style="transition-delay:.1s">
                    <h2 class="font-display text-lg font-bold text-ink">Sampul</h2>
                    <p class="mt-1 text-xs font-semibold text-ink-3">Opsional. Tanpa sampul, kartu memakai pola kategori.</p>

                    <div class="mt-4">
                        @if (isset($post) && $post->image)
                            <div class="mb-4 overflow-hidden rounded-brutal border-2 border-ink bg-paper-deep">
                                <img src="{{ asset('storage/'.$post->image) }}" alt="Sampul saat ini" class="w-full max-h-48 object-contain">
                            </div>
                        @endif
                        <label class="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-brutal border-2 border-dashed border-ink/30 bg-paper px-4 py-8 text-center transition-colors hover:border-ink">
                            <x-icon name="image" class="size-7 text-ink-3"/>
                            <span class="text-xs font-bold text-ink-2">Pilih gambar sampul</span>
                            <span class="text-[11px] font-semibold text-ink-3">JPG, PNG · maks 4MB</span>
                            <input type="file" id="image" name="image" accept="image/*" class="hidden">
                        </label>
                        @error('image')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror

                        @if (isset($post) && $post->image)
                            <label class="mt-3 flex cursor-pointer items-center gap-2 text-xs font-bold text-accent">
                                <input type="checkbox" name="remove_image" value="1" class="size-4 rounded-brutal border-2 border-ink accent-accent">
                                Hapus sampul saat ini
                            </label>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
