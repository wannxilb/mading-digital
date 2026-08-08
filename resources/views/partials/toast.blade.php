@if (session('success') || session('error'))
    <div id="toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 px-5 py-3.5 rounded-2xl shadow-lift text-sm font-semibold text-white text-center {{ session('success') ? 'bg-navy-900' : 'bg-red-600' }}"
         role="status">
        {{ session('success') ?? session('error') }}
    </div>
@endif
