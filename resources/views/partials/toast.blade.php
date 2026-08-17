@if (session('success') || session('error'))
    <div id="toast" role="status"
         class="fixed bottom-6 left-1/2 z-50 -translate-x-1/2 rounded-brutal border-2 border-ink px-5 py-3.5 text-sm font-bold text-cream shadow-brutal-sm {{ session('success') ? 'bg-ink' : 'bg-accent' }}">
        <span class="mr-2">{{ session('success') ? '✓' : '!' }}</span>
        {{ session('success') ?? session('error') }}
    </div>
@endif
