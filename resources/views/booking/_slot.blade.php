@php
$statusMap = [
    'tersedia' => 'bg-emerald-100 text-emerald-700 border-emerald-200 hover:bg-emerald-200 cursor-pointer',
    'penuh'    => 'bg-rose-100 text-rose-600 border-rose-200 cursor-not-allowed',
    'pending'  => 'bg-amber-100 text-amber-700 border-amber-200 cursor-not-allowed',
    'blokir'   => 'bg-gray-100 text-gray-400 border-gray-200 cursor-not-allowed',
];

$cls = $statusMap[$slot['status']] ?? $statusMap['blokir'];
@endphp

<div class="grid grid-cols-[90px_1fr] items-center gap-3">
    <span class="text-[11px] text-gray-500 font-medium">
        {{ $slot['label'] }}
    </span>

    <button
        type="button"
        class="slot-btn h-7 rounded-lg border text-[11px] font-bold transition-all {{ $cls }}"
        data-hour="{{ $slot['hour'] }}"
        data-status="{{ $slot['status'] }}"
        {{ $slot['status'] !== 'tersedia' ? 'disabled' : '' }}
    >
        {{ $slot['text'] }}
    </button>
</div>