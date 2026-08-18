<footer class="mt-20 border-t-2 border-ink bg-ink text-paper">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 py-12">
        <div class="grid gap-10 md:grid-cols-12 md:gap-8">
            <div class="md:col-span-5">
                <div class="flex items-center gap-3">
                    @php $logo = \App\Models\Setting::get('logo_path'); @endphp
                    @if ($logo)
                        <img src="{{ asset('storage/'.$logo) }}" alt="Logo" class="size-10 shrink-0 rounded-brutal border-2 border-cream/80 object-contain bg-cream/10">
                    @else
                        <span class="grid size-10 shrink-0 place-items-center rounded-brutal border-2 border-cream/80 bg-accent font-display text-sm font-bold text-cream">
                            MD
                        </span>
                    @endif
                    <div>
                        <p class="font-display text-lg font-bold text-cream">{{ \App\Models\Setting::get('site_name', 'Mading Digital') }}</p>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-cream/50">{{ \App\Models\Setting::get('site_tagline', 'Majalah Dinding Sekolah') }}</p>
                    </div>
                </div>
                <p class="mt-4 max-w-sm text-sm leading-relaxed text-cream/60">
                    {{ \App\Models\Setting::get('site_description', 'Pengumuman, berita, karya siswa, agenda, dan prestasi — dalam satu tempat yang bisa diakses kapan saja.') }}
                </p>
            </div>

            <div class="grid grid-cols-2 gap-8 sm:grid-cols-4 md:col-span-7">
                <div>
                    <h3 class="text-[11px] font-bold uppercase tracking-[0.18em] text-cream/40">Link Cepat</h3>
                    <ul class="mt-3 space-y-2 text-sm font-semibold text-cream/70">
                        <li><a href="{{ route('berita.index') }}" class="hover:text-cream">Berita</a></li>
                        <li><a href="{{ route('artikel.index') }}" class="hover:text-cream">Artikel</a></li>
                        <li><a href="{{ route('pengumuman.index') }}" class="hover:text-cream">Pengumuman</a></li>
                        <li><a href="{{ route('prestasi.index') }}" class="hover:text-cream">Prestasi</a></li>
                        <li><a href="{{ route('agenda.index') }}" class="hover:text-cream">Agenda</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-[11px] font-bold uppercase tracking-[0.18em] text-cream/40">Informasi</h3>
                    <ul class="mt-3 space-y-2 text-sm font-semibold text-cream/70">
                        <li><a href="{{ route('agenda.index') }}" class="hover:text-cream">Agenda Sekolah</a></li>
                        <li><a href="{{ route('tentang') }}" class="hover:text-cream">Tentang Mading</a></li>
                        <li><a href="{{ route('cari.index') }}" class="hover:text-cream">Cari Konten</a></li>
                        <li><a href="{{ route('admin.login') }}" class="hover:text-cream">Masuk Admin</a></li>
                    </ul>
                </div>
                <div class="col-span-2 sm:col-span-2">
                    <h3 class="text-[11px] font-bold uppercase tracking-[0.18em] text-cream/40">Pengelola</h3>
                    <p class="mt-3 text-sm leading-relaxed text-cream/60">
                        Dikelola oleh tim redaksi mading sekolah. Punya karya atau berita? Hubungi guru pembina.
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-10 border-t border-cream/10 pt-6 text-xs text-cream/40">
            &copy; {{ date('Y') }} {{ \App\Models\Setting::get('site_name', config('app.name', 'Mading Digital')) }}.
        </div>
    </div>
</footer>
