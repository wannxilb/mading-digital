@extends('layouts.admin')

@section('title', isset($post) ? 'Edit Cerita' : 'Tulis Cerita')
@section('heading', isset($post) ? 'Edit Cerita' : 'Tulis Cerita')

@section('content')
    <form method="POST" action="{{ isset($post) ? route('admin.posts.update', $post) : route('admin.posts.store') }}" enctype="multipart/form-data"
          class="max-w-4xl">
        @csrf
        @if (isset($post))
            @method('PUT')
        @endif

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-6">
                <div class="reveal rounded-3xl bg-white shadow-soft ring-1 ring-navy-900/5 p-6 sm:p-8">
                    <h2 class="font-display font-extrabold text-lg text-navy-900">Isi Cerita</h2>

                    <div class="mt-6">
                        <label for="title" class="block text-sm font-bold text-navy-900">Judul</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $post->title ?? '') }}" required
                               class="mt-2 w-full rounded-xl border-0 bg-ice-50 px-4 py-3 text-sm font-medium text-navy-900 ring-1 ring-navy-900/10 placeholder:text-navy-900/35 focus:outline-none focus:ring-2 focus:ring-royal-500">
                        @error('title')<p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="mt-5">
                        <label for="author" class="block text-sm font-bold text-navy-900">Penulis</label>
                        <input type="text" id="author" name="author" value="{{ old('author', $post->author ?? auth()->user()->name) }}" required
                               class="mt-2 w-full rounded-xl border-0 bg-ice-50 px-4 py-3 text-sm font-medium text-navy-900 ring-1 ring-navy-900/10 placeholder:text-navy-900/35 focus:outline-none focus:ring-2 focus:ring-royal-500">
                        @error('author')<p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="mt-5">
                        <label for="excerpt" class="block text-sm font-bold text-navy-900">Ringkasan <span class="font-normal text-navy-900/40">(opsional)</span></label>
                        <textarea id="excerpt" name="excerpt" rows="2" maxlength="300"
                                  class="mt-2 w-full rounded-xl border-0 bg-ice-50 px-4 py-3 text-sm font-medium text-navy-900 ring-1 ring-navy-900/10 placeholder:text-navy-900/35 focus:outline-none focus:ring-2 focus:ring-royal-500">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                        <p class="mt-1.5 text-xs text-navy-900/40">Ringkasan singkat yang tampil di kartu cerita.</p>
                    </div>

                    <div class="mt-5">
                        <label for="body" class="block text-sm font-bold text-navy-900">Isi Cerita <span class="font-normal text-navy-900/40">— mendukung teks biasa dan format markdown</span></label>
                        <textarea id="body" name="body" rows="14" required
                                  class="mt-2 w-full rounded-xl border-0 bg-ice-50 px-4 py-3 text-sm font-medium leading-relaxed text-navy-900 ring-1 ring-navy-900/10 placeholder:text-navy-900/35 focus:outline-none focus:ring-2 focus:ring-royal-500">{{ old('body', $post->body ?? '') }}</textarea>
                        @error('body')<p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                        <div class="mt-3 flex flex-wrap gap-2 text-[11px] font-semibold text-navy-900/45">
                            <span class="rounded-lg bg-ice-100 px-2.5 py-1">**tebal**</span>
                            <span class="rounded-lg bg-ice-100 px-2.5 py-1">- poin</span>
                            <span class="rounded-lg bg-ice-100 px-2.5 py-1">> kutipan</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="reveal rounded-3xl bg-white shadow-soft ring-1 ring-navy-900/5 p-6" style="transition-delay:.05s">
                    <h2 class="font-display font-extrabold text-lg text-navy-900">Atur & Terbitkan</h2>

                    <div class="mt-5">
                        <label for="category_id" class="block text-sm font-bold text-navy-900">Kategori</label>
                        <select id="category_id" name="category_id" required
                                class="mt-2 w-full rounded-xl border-0 bg-ice-50 px-4 py-3 text-sm font-medium text-navy-900 ring-1 ring-navy-900/10 focus:outline-none focus:ring-2 focus:ring-royal-500">
                            <option value="" disabled {{ ! old('category_id', $post->category_id ?? '') ? 'selected' : '' }}>Pilih kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="mt-5 space-y-3.5">
                        <label class="flex cursor-pointer items-center justify-between gap-3 rounded-2xl bg-ice-50 px-4 py-3.5 ring-1 ring-navy-900/5">
                            <span>
                                <span class="block text-sm font-bold text-navy-900">Tampilkan</span>
                                <span class="text-xs text-navy-900/50">Cerita ini muncul di papan publik</span>
                            </span>
                            <input type="hidden" name="is_published" value="0">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $post->is_published ?? true) ? 'checked' : '' }}
                                   class="size-5 rounded accent-royal-600">
                        </label>

                        <label class="flex cursor-pointer items-center justify-between gap-3 rounded-2xl bg-ice-50 px-4 py-3.5 ring-1 ring-navy-900/5">
                            <span>
                                <span class="block text-sm font-bold text-navy-900">Jadikan unggulan</span>
                                <span class="text-xs text-navy-900/50">Tampil di "Cerita Unggulan" beranda</span>
                            </span>
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $post->is_featured ?? false) ? 'checked' : '' }}
                                   class="size-5 rounded accent-royal-600">
                        </label>
                    </div>

                    <button type="submit"
                            class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-br from-navy-800 to-royal-600 px-6 py-4 text-sm font-bold text-white shadow-glow transition-all duration-300 hover:-translate-y-0.5">
                        <x-icon name="check" class="size-4"/>
                        {{ isset($post) ? 'Simpan Perubahan' : 'Terbitkan Cerita' }}
                    </button>
                </div>

                <div class="reveal rounded-3xl bg-white shadow-soft ring-1 ring-navy-900/5 p-6" style="transition-delay:.1s">
                    <h2 class="font-display font-extrabold text-lg text-navy-900">Sampul</h2>
                    <p class="mt-1 text-xs text-navy-900/50">Opsional. Tanpa sampul, kartu memakai warna kategori.</p>

                    <div class="mt-4">
                        @if (isset($post) && $post->image)
                            <img src="{{ asset('storage/'.$post->image) }}" alt="Sampul saat ini" class="mb-4 h-40 w-full rounded-2xl object-cover ring-1 ring-navy-900/10">
                        @endif
                        <label class="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-2xl border-2 border-dashed border-navy-900/15 bg-ice-50 px-4 py-8 text-center hover:border-royal-500/50 transition-colors">
                            <x-icon name="image" class="size-7 text-navy-900/30"/>
                            <span class="text-xs font-bold text-navy-900/60">Pilih gambar sampul</span>
                            <span class="text-[11px] text-navy-900/40">JPG, PNG · maks 4MB</span>
                            <input type="file" id="image" name="image" accept="image/*" class="hidden">
                        </label>
                        @error('image')<p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>@enderror

                        @if (isset($post) && $post->image)
                            <label class="mt-3 flex cursor-pointer items-center gap-2 text-xs font-bold text-red-600">
                                <input type="checkbox" name="remove_image" value="1" class="size-4 rounded accent-red-600">
                                Hapus sampul saat ini
                            </label>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
