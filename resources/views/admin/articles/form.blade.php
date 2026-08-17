@extends('layouts.admin')

@php $article = $article ?? null; @endphp

@section('title', isset($article) ? 'Edit Artikel' : 'Tambah Artikel')
@section('heading', isset($article) ? 'Edit Artikel' : 'Tambah Artikel')

@section('content')
    <form method="POST" action="{{ isset($article) ? route('admin.artikel.update', $article) : route('admin.artikel.store') }}" enctype="multipart/form-data" class="max-w-4xl">
        @csrf
        @if (isset($article))
            @method('PUT')
        @endif

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <div class="reveal card border-2 p-6 sm:p-8">
                    <h2 class="font-display text-lg font-bold text-ink">Isi Artikel</h2>

                    <div class="mt-6">
                        <label for="title" class="label">Judul</label>
                        <p class="mt-1 text-[11px] text-ink-3">Judul artikel yang jelas dan ringkas.</p>
                        <input type="text" id="title" name="title" value="{{ old('title', $article->title ?? '') }}" required class="field mt-2">
                        @error('title')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
                    </div>

                    <div class="mt-5 grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="author" class="label">Penulis</label>
                            <p class="mt-1 text-[11px] text-ink-3">Nama penulis artikel.</p>
                            <input type="text" id="author" name="author" value="{{ old('author', $article->author ?? auth()->user()->name) }}" required class="field mt-2">
                            @error('author')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="class" class="label">Kelas <span class="font-normal normal-case text-ink-3">(opsional)</span></label>
                            <p class="mt-1 text-[11px] text-ink-3">Kelas penulis (cth: XI IPA 1).</p>
                            <input type="text" id="class" name="class" value="{{ old('class', $article->class ?? '') }}" placeholder="cth: XI IPA 1" class="field mt-2">
                        </div>
                    </div>

                    <div class="mt-5">
                        <label for="excerpt" class="label">Ringkasan <span class="font-normal normal-case text-ink-3">(opsional)</span></label>
                        <p class="mt-1 text-[11px] text-ink-3">Ringkasan singkat (maks 300 karakter) yang tampil di kartu artikel.</p>
                        <textarea id="excerpt" name="excerpt" rows="2" maxlength="300" class="field mt-2">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
                    </div>

                    <div class="mt-5">
                        <label for="body" class="label">Isi Artikel <span class="font-normal normal-case text-ink-3">— mendukung markdown</span></label>
                        <p class="mt-1 text-[11px] text-ink-3">Tulis isi artikel di sini. Mendukung format <strong>markdown</strong> untuk tebal, miring, daftar, dan kutipan.</p>
                        <textarea id="body" name="body" rows="14" required class="field mt-2 font-mono text-[13px] leading-relaxed">{{ old('body', $article->body ?? '') }}</textarea>
                        @error('body')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
                        <div class="mt-3 flex flex-wrap gap-2 text-[11px] font-semibold text-ink-2">
                            <span class="rounded-brutal border border-ink/20 bg-paper px-2.5 py-1">**tebal**</span>
                            <span class="rounded-brutal border border-ink/20 bg-paper px-2.5 py-1">- poin</span>
                            <span class="rounded-brutal border border-ink/20 bg-paper px-2.5 py-1">> kutipan</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="reveal card border-2 p-6" style="transition-delay:.05s">
                    <h2 class="font-display text-lg font-bold text-ink">Status & Kategori</h2>

                    <div class="mt-5">
                        <label for="status" class="label">Status</label>
                        <select id="status" name="status" required class="field mt-2">
                            @foreach ($statuses as $key => $label)
                                <option value="{{ $key }}" {{ old('status', $article->status ?? 'draft') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <p class="mt-1.5 text-xs font-semibold text-ink-3">Hanya status <strong>Published</strong> yang tampil di halaman publik.</p>
                    </div>

                    <div class="mt-5">
                        <label for="category_id" class="label">Kategori</label>
                        <select id="category_id" name="category_id" required class="field mt-2">
                            <option value="" disabled {{ ! old('category_id', $article->category_id ?? '') ? 'selected' : '' }}>Pilih kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $article->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
                    </div>

                    <div class="mt-5">
                        <label for="review_note" class="label">Catatan Reviewer <span class="font-normal normal-case text-ink-3">(opsional)</span></label>
                        <textarea id="review_note" name="review_note" rows="3" maxlength="1000" class="field mt-2" placeholder="Masukkan catatan untuk penulis, jika perlu revisi.">{{ old('review_note', $article->review_note ?? '') }}</textarea>
                    </div>

                    <button type="submit" class="btn-ink mt-6 w-full !py-3.5">
                        <x-icon name="check" class="size-4"/>
                        {{ isset($article) ? 'Simpan Perubahan' : 'Simpan Artikel' }}
                    </button>
                </div>

                <div class="reveal card border-2 p-6" style="transition-delay:.1s">
                    <h2 class="font-display text-lg font-bold text-ink">Sampul</h2>

                    <div class="mt-4">
                        @if (isset($article) && $article->image)
                            <div class="mb-4 overflow-hidden rounded-brutal border-2 border-ink bg-paper-deep">
                                <img src="{{ asset('storage/'.$article->image) }}" alt="Sampul saat ini" class="w-full max-h-48 object-contain">
                            </div>
                        @endif
                        <label class="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-brutal border-2 border-dashed border-ink/30 bg-paper px-4 py-8 text-center transition-colors hover:border-ink">
                            <x-icon name="image" class="size-7 text-ink-3"/>
                            <span class="text-xs font-bold text-ink-2">Pilih gambar sampul</span>
                            <span class="text-[11px] font-semibold text-ink-3">JPG, PNG · maks 4MB</span>
                            <input type="file" id="image" name="image" accept="image/*" class="hidden">
                        </label>
                        @error('image')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror

                        @if (isset($article) && $article->image)
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
