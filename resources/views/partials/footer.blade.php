<footer class="mt-20 border-t border-navy-900/10 bg-white">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 py-12">
        <div class="flex flex-col md:flex-row md:items-start gap-8 md:justify-between">
            <div class="max-w-sm">
                <div class="flex items-center gap-3">
                    <span class="grid place-items-center size-10 rounded-xl bg-gradient-to-br from-navy-800 to-royal-600 text-white">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 19a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2"/>
                            <path d="M5 17V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v12"/>
                            <path d="M9 8h6M9 12h4"/>
                        </svg>
                    </span>
                    <span class="font-display font-extrabold text-lg text-navy-900">Mading Digital</span>
                </div>
                <p class="mt-4 text-sm leading-relaxed text-navy-900/60">
                    Majalah dinding digital sekolah. Tempat berbagi pengumuman, prestasi, dan cerita dari perjalanan kita bersama di sekolah.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-10 sm:gap-16">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-navy-900/50">Jelajahi</h3>
                    <ul class="mt-4 space-y-2.5 text-sm font-medium text-navy-800">
                        <li><a href="{{ route('home') }}#pengumuman" class="hover:text-royal-600 transition-colors">Papan Info</a></li>
                        <li><a href="{{ route('home') }}#prestasi" class="hover:text-royal-600 transition-colors">Prestasi</a></li>
                        <li><a href="{{ route('home') }}#kegiatan" class="hover:text-royal-600 transition-colors">Kegiatan</a></li>
                        <li><a href="{{ route('home') }}#karya" class="hover:text-royal-600 transition-colors">Karya &amp; Kreativitas</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-navy-900/50">Lainnya</h3>
                    <ul class="mt-4 space-y-2.5 text-sm font-medium text-navy-800">
                        <li><a href="{{ route('admin.login') }}" class="hover:text-royal-600 transition-colors">Masuk Admin</a></li>
                        <li><a href="{{ route('home') }}#semua" class="hover:text-royal-600 transition-colors">Semua Konten</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="mt-10 pt-6 border-t border-navy-900/10 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-navy-900/50">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Mading Digital') }}. Dibuat dengan semangat di sekolah kita.</p>
            <p class="inline-flex items-center gap-1.5">
                Setiap perjalanan dimulai dengan langkah pertama.
            </p>
        </div>
    </div>
</footer>
