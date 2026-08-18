@extends('layouts.admin')

@section('title', 'Pengaturan Situs')
@section('heading', 'Pengaturan Situs')

@section('content')
    <form method="POST" action="{{ route('admin.pengaturan.update') }}" enctype="multipart/form-data" class="mx-auto max-w-3xl space-y-8">
        @csrf
        @method('PUT')

        {{-- General --}}
        <div class="card p-6">
            <h2 class="font-display text-lg font-bold text-ink">Informasi Umum</h2>
            <p class="mt-1 text-sm text-ink-3">Nama situs, deskripsi, dan identitas sekolah.</p>

            <div class="mt-6 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="site_name" class="label">Nama Situs</label>
                    <input type="text" name="site_name" id="site_name" value="{{ old('site_name', $settings['site_name']) }}" class="field mt-1.5" required maxlength="60">
                </div>
                <div>
                    <label for="site_tagline" class="label">Tagline</label>
                    <input type="text" name="site_tagline" id="site_tagline" value="{{ old('site_tagline', $settings['site_tagline']) }}" class="field mt-1.5" maxlength="100" placeholder="Majalah Dinding Sekolah">
                </div>
            </div>

            <div class="mt-5">
                <label for="site_description" class="label">Deskripsi Situs</label>
                <textarea name="site_description" id="site_description" rows="2" class="field mt-1.5" maxlength="255" placeholder="Deskripsi singkat tentang situs ini">{{ old('site_description', $settings['site_description']) }}</textarea>
            </div>
        </div>

        {{-- Branding --}}
        <div class="card p-6">
            <h2 class="font-display text-lg font-bold text-ink">Branding</h2>
            <p class="mt-1 text-sm text-ink-3">Logo, favicon, dan gambar hero untuk situs.</p>

            <div class="mt-6 grid gap-6 sm:grid-cols-3">
                {{-- Favicon --}}
                <div>
                    <label class="label">Favicon</label>
                    <p class="mt-1 text-[11px] text-ink-3">Format: ICO, PNG, atau SVG. Ukuran maks 2MB.</p>
                    <div class="mt-3 flex flex-col items-center gap-3">
                        @if ($settings['favicon_path'])
                            <div class="relative size-16 overflow-hidden rounded-brutal border-2 border-ink bg-cream">
                                <img src="{{ asset('storage/'.$settings['favicon_path']) }}" alt="Favicon" class="size-full object-contain p-1">
                            </div>
                        @else
                            <div class="grid size-16 place-items-center rounded-brutal border-2 border-dashed border-ink/30 bg-paper text-ink-3">
                                <x-icon name="image" class="size-6"/>
                            </div>
                        @endif
                        <div class="flex items-center gap-2">
                            <label for="favicon" class="btn-outline cursor-pointer !px-4 !py-2 text-xs">
                                <x-icon name="image" class="size-3.5"/>
                                Pilih File
                            </label>
                            @if ($settings['favicon_path'])
                                <form method="POST" action="{{ route('admin.pengaturan.destroyImage', 'favicon_path') }}" onsubmit="return confirm('Hapus favicon?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-outline !border-red-500 !text-red-500 hover:!bg-red-500 hover:!text-cream !px-4 !py-2 text-xs">
                                        <x-icon name="trash" class="size-3.5"/>
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                        <input type="file" name="favicon" id="favicon" class="hidden" accept=".ico,.png,.svg,image/x-icon,image/png,image/svg+xml">
                    </div>
                </div>

                {{-- Logo --}}
                <div>
                    <label class="label">Logo</label>
                    <p class="mt-1 text-[11px] text-ink-3">Format: PNG, SVG, JPG. Ukuran maks 2MB.</p>
                    <div class="mt-3 flex flex-col items-center gap-3">
                        @if ($settings['logo_path'])
                            <div class="relative h-16 w-32 overflow-hidden rounded-brutal border-2 border-ink bg-cream">
                                <img src="{{ asset('storage/'.$settings['logo_path']) }}" alt="Logo" class="size-full object-contain p-1">
                            </div>
                        @else
                            <div class="grid h-16 w-32 place-items-center rounded-brutal border-2 border-dashed border-ink/30 bg-paper text-ink-3">
                                <x-icon name="image" class="size-6"/>
                            </div>
                        @endif
                        <div class="flex items-center gap-2">
                            <label for="logo" class="btn-outline cursor-pointer !px-4 !py-2 text-xs">
                                <x-icon name="image" class="size-3.5"/>
                                Pilih File
                            </label>
                            @if ($settings['logo_path'])
                                <form method="POST" action="{{ route('admin.pengaturan.destroyImage', 'logo_path') }}" onsubmit="return confirm('Hapus logo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-outline !border-red-500 !text-red-500 hover:!bg-red-500 hover:!text-cream !px-4 !py-2 text-xs">
                                        <x-icon name="trash" class="size-3.5"/>
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                        <input type="file" name="logo" id="logo" class="hidden" accept=".png,.svg,.jpg,.jpeg,image/png,image/svg+xml,image/jpeg">
                    </div>
                </div>

                {{-- Hero Image --}}
                <div>
                    <label class="label">Gambar Hero</label>
                    <p class="mt-1 text-[11px] text-ink-3">Gambar latar hero. Format: PNG, JPG, WebP. Maks 4MB.</p>
                    <div class="mt-3 flex flex-col items-center gap-3">
                        @if ($settings['hero_image_path'])
                            <div class="relative aspect-video w-full overflow-hidden rounded-brutal border-2 border-ink bg-cream">
                                <img src="{{ asset('storage/'.$settings['hero_image_path']) }}" alt="Hero" class="size-full object-cover">
                            </div>
                        @else
                            <div class="grid aspect-video w-full place-items-center rounded-brutal border-2 border-dashed border-ink/30 bg-paper text-ink-3">
                                <x-icon name="image" class="size-6"/>
                            </div>
                        @endif
                        <div class="flex items-center gap-2">
                            <label for="hero_image" class="btn-outline cursor-pointer !px-4 !py-2 text-xs">
                                <x-icon name="image" class="size-3.5"/>
                                Pilih File
                            </label>
                            @if ($settings['hero_image_path'])
                                <form method="POST" action="{{ route('admin.pengaturan.destroyImage', 'hero_image_path') }}" onsubmit="return confirm('Hapus gambar hero?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-outline !border-red-500 !text-red-500 hover:!bg-red-500 hover:!text-cream !px-4 !py-2 text-xs">
                                        <x-icon name="trash" class="size-3.5"/>
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                        <input type="file" name="hero_image" id="hero_image" class="hidden" accept=".png,.jpg,.jpeg,.webp,image/png,image/jpeg,image/webp">
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact --}}
        <div class="card p-6">
            <h2 class="font-display text-lg font-bold text-ink">Kontak</h2>
            <p class="mt-1 text-sm text-ink-3">Informasi kontak yang ditampilkan di situs.</p>

            <div class="mt-6 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="contact_email" class="label">Email</label>
                    <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}" class="field mt-1.5" maxlength="100" placeholder="sekolah@example.com">
                </div>
                <div>
                    <label for="contact_whatsapp" class="label">WhatsApp</label>
                    <input type="text" name="contact_whatsapp" id="contact_whatsapp" value="{{ old('contact_whatsapp', $settings['contact_whatsapp']) }}" class="field mt-1.5" maxlength="20" placeholder="081234567890">
                </div>
            </div>

            <div class="mt-5">
                <label for="contact_address" class="label">Alamat</label>
                <textarea name="contact_address" id="contact_address" rows="2" class="field mt-1.5" maxlength="255" placeholder="Jl. Contoh No. 123, Kota">{{ old('contact_address', $settings['contact_address']) }}</textarea>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex items-center gap-3">
            <button type="submit" class="btn-ink">
                <x-icon name="check" class="size-4"/>
                Simpan Pengaturan
            </button>
        </div>
    </form>
@endsection
