@extends('layouts.siswa')

@section('title', 'Edit Karya')
@section('heading', 'Edit Karya')

@section('content')
    <form method="POST" action="{{ route('siswa.karya.update', $article) }}" enctype="multipart/form-data" class="mx-auto max-w-4xl">
        @csrf
        @method('PUT')

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <div class="card border-2 p-6 sm:p-8">
                    <h2 class="font-display text-lg font-bold text-ink">Isi Karya</h2>

                    <div class="mt-6">
                        <label for="title" class="label">Judul</label>
                        <p class="mt-1 text-[11px] text-ink-3">Buat judul yang menarik dan sesuai isi karya kamu.</p>
                        <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}" required class="field mt-2">
                        @error('title')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
                    </div>

                    <div class="mt-5">
                        <label for="excerpt" class="label">Ringkasan <span class="font-normal normal-case text-ink-3">(opsional)</span></label>
                        <p class="mt-1 text-[11px] text-ink-3">Ringkasan singkat (maks 300 karakter) yang tampil di preview kartu karya.</p>
                        <textarea id="excerpt" name="excerpt" rows="2" maxlength="300" class="field mt-2">{{ old('excerpt', $article->excerpt) }}</textarea>
                    </div>

                    <div class="mt-5">
                        <label for="body" class="label">Isi Karya <span class="font-normal normal-case text-ink-3">— mendukung markdown</span></label>
                        <p class="mt-1 text-[11px] text-ink-3">Tulis karya kamu di sini. Kamu bisa pakai format <strong>markdown</strong> untuk tebal, miring, daftar, dan kutipan.</p>
                        <textarea id="body" name="body" rows="14" required class="field mt-2 font-mono text-[13px] leading-relaxed">{{ old('body', $article->body) }}</textarea>
                        @error('body')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="card border-2 p-6">
                    <h2 class="font-display text-lg font-bold text-ink">Kategori & Sampul</h2>

                    <div class="mt-5">
                        <label for="category_id" class="label">Kategori</label>
                        <p class="mt-1 text-[11px] text-ink-3">Pilih kategori yang paling sesuai dengan isi karya kamu.</p>
                        <select id="category_id" name="category_id" required class="field mt-2">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
                    </div>

                    <div class="mt-5">
                        <label class="label">Sampul</label>
                        <p class="mt-1 text-[11px] text-ink-3">Gambar sampul untuk menarik perhatian pembaca. Format JPG/PNG, maks 4MB.</p>
                        @if ($article->image)
                            <div class="mb-4 overflow-hidden rounded-brutal border-2 border-ink bg-paper-deep">
                                <img src="{{ asset('storage/'.$article->image) }}" alt="Sampul saat ini" class="w-full max-h-48 object-contain">
                            </div>
                        @endif
                        <label class="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-brutal border-2 border-dashed border-ink/30 bg-paper px-4 py-8 text-center transition-colors hover:border-ink">
                            <x-icon name="image" class="size-7 text-ink-3"/>
                            <span class="text-xs font-bold text-ink-2">{{ $article->image ? 'Ganti gambar sampul' : 'Pilih gambar sampul' }}</span>
                            <span class="text-[11px] font-semibold text-ink-3">JPG, PNG · maks 4MB</span>
                            <input type="file" id="image" name="image" accept="image/*" class="hidden">
                        </label>
                        @error('image')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror

                        @if ($article->image)
                            <label class="mt-3 flex cursor-pointer items-center gap-2 text-xs font-bold text-accent">
                                <input type="checkbox" name="remove_image" value="1" class="size-4 rounded-brutal border-2 border-ink accent-accent">
                                Hapus sampul saat ini
                            </label>
                        @endif
                    </div>

                    <div class="mt-6 space-y-3">
                        <button type="submit" name="as_draft" value="0" class="btn-ink w-full !py-3.5">
                            <x-icon name="send" class="size-4"/>
                            Kirim untuk Review
                        </button>
                        <button type="submit" name="as_draft" value="1" class="btn-outline w-full !py-3.5">
                            <x-icon name="save" class="size-4"/>
                            Simpan Draft
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
