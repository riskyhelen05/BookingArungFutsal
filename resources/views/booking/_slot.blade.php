@php
$statusMap = [
    'tersedia' => 'bg-brand-100 text-brand-700 border-brand-200 cursor-pointer hover:bg-brand-200',
    'penuh'    => 'bg-red-100 text-red-700 border-red-200 cursor-not-allowed opacity-60',
    'pending'  => 'bg-amber-100 text-amber-700 border-amber-200 cursor-not-allowed opacity-60',
    'blokir'   => 'bg-gray-100 text-gray-500 border-gray-200 cursor-not-allowed opacity-60',
];
$cls = $statusMap[$slot['status']] ?? $statusMap['blokir'];
@endphp
<div class="px-5 py-2.5 flex items-center gap-4 hover:bg-gray-50 transition-colors">
    <span class="font-mono text-xs text-gray-400 w-24 flex-shrink-0">{{ $slot['label'] }}</span>
    <button
        type="button"
        class="slot-btn flex-1 text-center py-2 px-3 rounded-xl border text-xs font-semibold {{ $cls }}"
        data-hour="{{ $slot['hour'] }}"
        data-status="{{ $slot['status'] }}"
        {{ $slot['status'] !== 'tersedia' ? 'disabled' : '' }}
    >
        {{ $slot['text'] }}
    </button>
</div>