<div class="fixed bottom-4 right-4 z-40" aria-live="polite" aria-atomic="true">
    <div
        x-show="toast.open"
        x-transition
        class="max-w-sm rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-lg"
    >
        <div class="font-semibold" :class="toast.type === 'success' ? 'text-emerald-700' : 'text-rose-700'" x-text="toast.type === 'success' ? 'Сагс' : 'Алдаа'"></div>
        <div class="mt-1 text-slate-700" x-text="toast.message"></div>
    </div>
</div>
