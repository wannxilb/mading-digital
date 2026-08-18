<div class="card p-5">
    <div class="flex flex-wrap items-center gap-2">
        <span class="tag-blue">Pengumuman</span>
        <span class="tag-amber">Menunggu Review</span>
        <span class="{{ $item->priority === 'mendesak' ? 'tag-red' : ($item->priority === 'penting' ? 'tag-amber' : 'tag-gray') }}">{{ $item->priority_label }}</span>
        <span class="text-xs font-semibold text-ink-3">{{ $item->created_at->diffForHumans() }}</span>
    </div>
    <h3 class="mt-3 font-display text-lg font-bold text-ink">{{ $item->title }}</h3>
    @if ($item->creator)
        <p class="mt-1 text-xs font-semibold text-ink-3">Oleh: {{ $item->creator->name }}</p>
    @endif
    @if ($item->start_date || $item->end_date)
        <p class="mt-1 text-xs font-semibold text-ink-3">
            {{ $item->start_date?->translatedFormat('d M Y') }}@if ($item->end_date) — {{ $item->end_date->translatedFormat('d M Y') }}@endif
        </p>
    @endif
    <p class="mt-2 text-sm text-ink-2 line-clamp-3">{{ $item->content }}</p>
    @if ($item->review_note)
        <div class="mt-2 rounded-brutal border-2 border-amber-300 bg-amber-50 p-3 text-xs text-amber-800">
            <strong>Catatan:</strong> {{ $item->review_note }}
        </div>
    @endif
    <div class="mt-4 flex flex-wrap items-center gap-2">
        <form method="POST" action="{{ route('admin.persetujuan.approveAnnouncement', $item) }}">
            @csrf
            <button type="submit" class="btn-ink !bg-green-600 !border-green-600 hover:!bg-green-700 text-xs">
                <x-icon name="check" class="size-3.5"/>
                Setujui
            </button>
        </form>
        <button type="button" onclick="document.getElementById('reject-announcement-{{ $item->id }}').classList.toggle('hidden')" class="btn-outline !border-red-500 !text-red-500 hover:!bg-red-500 hover:!text-cream text-xs">
            <x-icon name="x" class="size-3.5"/>
            Tolak
        </button>
        <a href="{{ route('admin.pengumuman.edit', $item) }}" class="btn-ghost text-xs">Edit</a>
    </div>
    <div id="reject-announcement-{{ $item->id }}" class="hidden mt-3">
        <form method="POST" action="{{ route('admin.persetujuan.rejectAnnouncement', $item) }}">
            @csrf
            <textarea name="review_note" rows="2" class="field w-full" placeholder="Alasan penolakan…" required></textarea>
            <div class="mt-2 flex gap-2">
                <button type="submit" class="btn-outline !border-red-500 !text-red-500 hover:!bg-red-500 hover:!text-cream text-xs">Kirim Penolakan</button>
                <button type="button" onclick="document.getElementById('reject-announcement-{{ $item->id }}').classList.add('hidden')" class="btn-ghost text-xs">Batal</button>
            </div>
        </form>
    </div>
</div>
