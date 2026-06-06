@extends('layouts.app')

@section('title', 'Booking Lapangan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">

    {{-- ═══ Page Header ═══ --}}
    <div class="mb-8 animate-fade-up">
        <div class="flex items-center gap-2 text-sm text-brand-600 font-medium mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Booking Lapangan Futsal
        </div>
        <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight">Pilih Lapangan & Jadwal</h1>
        <p class="mt-1 text-gray-500">Pilih tanggal, lapangan, dan jam yang kamu inginkan.</p>
    </div>

    {{-- ═══ Step Indicator ═══ --}}
    <div class="flex items-center gap-2 mb-10 animate-fade-up" style="animation-delay:.05s">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-brand-500 text-white flex items-center justify-center text-sm font-bold shadow-md">1</div>
            <span class="text-sm font-semibold text-brand-700 hidden sm:block">Pilih Jadwal</span>
        </div>
        <div class="step-line"></div>
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center text-sm font-bold">2</div>
            <span class="text-sm font-medium text-gray-400 hidden sm:block">Pembayaran</span>
        </div>
        <div class="step-line"></div>
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center text-sm font-bold">3</div>
            <span class="text-sm font-medium text-gray-400 hidden sm:block">Selesai</span>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        {{-- ═══ LEFT PANEL: Filter + Schedule ═══ --}}
        <div class="xl:col-span-2 space-y-6">

            {{-- Filter Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 animate-fade-up" style="animation-delay:.08s">
                <h2 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/></svg>
                    Filter Pencarian
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" id="filter-form">
                    {{-- Tanggal --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tanggal</label>
                        <input type="date" id="filter-date"
                               value="{{ $selectedDate }}"
                               min="{{ now()->format('Y-m-d') }}"
                               class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition-all" />
                    </div>

                    {{-- Lapangan --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Lapangan</label>
                        <select id="filter-field"
                                class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition-all bg-white">
                            @foreach($fields as $f)
                            <option value="{{ $f->id }}" {{ $f->id === optional($selectedField)->id ? 'selected' : '' }}>{{ $f->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Durasi --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Durasi</label>
                        <select id="filter-duration"
                                class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition-all bg-white">
                            @for($d = 1; $d <= 4; $d++)
                            <option value="{{ $d }}" {{ $d === $selectedDuration ? 'selected' : '' }}>{{ $d }} Jam</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

            {{-- Legend --}}
            <div class="flex flex-wrap gap-3 px-1 animate-fade-up" style="animation-delay:.12s">
                @foreach([
                    ['bg-brand-100 text-brand-700 border-brand-200', 'Tersedia'],
                    ['bg-red-100 text-red-700 border-red-200', 'Penuh'],
                    ['bg-amber-100 text-amber-700 border-amber-200', 'Pending'],
                    ['bg-gray-100 text-gray-500 border-gray-200', 'Terblokir'],
                ] as [$cls, $lbl])
                <div class="flex items-center gap-1.5 text-xs font-medium {{ $cls }} border px-2.5 py-1 rounded-lg">
                    <span class="w-2 h-2 rounded-sm {{ explode(' ', $cls)[0] }} border-0 bg-current opacity-70"></span>
                    {{ $lbl }}
                </div>
                @endforeach
            </div>

            {{-- Schedule Grid --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-fade-up" style="animation-delay:.15s">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="font-bold text-gray-800" id="schedule-title">
                        Jadwal {{ optional($selectedField)->name ?? '–' }}
                    </h2>
                    <span class="text-xs text-gray-400 font-mono" id="schedule-date">{{ \Carbon\Carbon::parse($selectedDate)->isoFormat('dddd, D MMMM YYYY') }}</span>
                </div>

                <div class="divide-y divide-gray-50" id="schedule-grid">
                    @forelse($schedule as $slot)
                    @include('booking._slot', ['slot' => $slot])
                    @empty
                    <div class="px-6 py-8 text-center text-gray-400 text-sm">Pilih lapangan untuk melihat jadwal.</div>
                    @endforelse
                </div>

                {{-- Loading overlay --}}
                <div id="schedule-loading" class="hidden px-6 py-8 text-center">
                    <div class="inline-flex items-center gap-2 text-brand-600 text-sm font-medium">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                        Memuat jadwal...
                    </div>
                </div>
            </div>

        </div>

        {{-- ═══ RIGHT PANEL: Ringkasan & Form ═══ --}}
        <div class="xl:col-span-1">
            <div class="sticky top-24 space-y-4">

                {{-- Ringkasan --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 animate-slide-in" style="animation-delay:.2s">
                    <h2 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Ringkasan Booking
                    </h2>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Nama Pemesan</span>
                            <span class="font-semibold text-gray-800">{{ Auth::check() ? Auth::user()->name : 'Yahya Zahid' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tanggal</span>
                            <span class="font-semibold text-gray-800" id="sum-date">–</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Lapangan</span>
                            <span class="font-semibold text-gray-800" id="sum-field">–</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Jam</span>
                            <span class="font-semibold text-gray-800" id="sum-time">–</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Durasi</span>
                            <span class="font-semibold text-gray-800" id="sum-duration">–</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Harga</span>
                            <span class="font-medium text-gray-600" id="sum-price">–</span>
                        </div>
                        <div class="border-t border-dashed border-gray-200 pt-3 flex justify-between">
                            <span class="font-bold text-gray-900">Total Pembayaran</span>
                            <span class="font-extrabold text-brand-600 text-base" id="sum-total">–</span>
                        </div>
                    </div>
                </div>

                {{-- Pilih jam hint --}}
                <div id="hint-select" class="bg-brand-50 border border-brand-100 rounded-xl px-4 py-3 text-sm text-brand-700 text-center animate-pop">
                    👆 Klik jam <span class="font-bold">Tersedia</span> di jadwal untuk memilih
                </div>

                {{-- Action form --}}
                <form action="{{ route('booking.store') }}" method="POST" id="booking-form" class="hidden animate-pop">
                    @csrf
                    <input type="hidden" name="field_id" id="form-field-id" />
                    <input type="hidden" name="date" id="form-date" />
                    <input type="hidden" name="start_time" id="form-start-time" />
                    <input type="hidden" name="end_time" id="form-end-time" />
                    <input type="hidden" name="duration" id="form-duration" />

                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-brand-500 hover:bg-brand-600 active:scale-95 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-brand-200 transition-all text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Lanjut ke Pembayaran
                    </button>
                </form>

                {{-- Harga per jam info --}}
                <p class="text-center text-xs text-gray-400" id="price-info">
                    {{ $selectedField ? 'Rp ' . number_format($selectedField->price_per_hour, 0, ',', '.') . '/jam' : '' }}
                </p>

            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

// ── State ──────────────────────────────────────────────
let state = {
    date:     '{{ $selectedDate }}',
    fieldId:  '{{ optional($selectedField)->id }}',
    fieldName:'{{ optional($selectedField)->name }}',
    pricePerHour: {{ optional($selectedField)->price_per_hour ?? 0 }},
    duration: {{ $selectedDuration }},
    startHour: null,
};

// ── DOM Refs ───────────────────────────────────────────
const scheduleGrid    = document.getElementById('schedule-grid');
const scheduleLoading = document.getElementById('schedule-loading');
const scheduleTitle   = document.getElementById('schedule-title');
const scheduleDate    = document.getElementById('schedule-date');
const bookingForm     = document.getElementById('booking-form');
const hintEl          = document.getElementById('hint-select');

// Summary refs
const sumDate     = document.getElementById('sum-date');
const sumField    = document.getElementById('sum-field');
const sumTime     = document.getElementById('sum-time');
const sumDuration = document.getElementById('sum-duration');
const sumPrice    = document.getElementById('sum-price');
const sumTotal    = document.getElementById('sum-total');
const priceInfo   = document.getElementById('price-info');

// Form hidden refs
const formFieldId   = document.getElementById('form-field-id');
const formDate      = document.getElementById('form-date');
const formStartTime = document.getElementById('form-start-time');
const formEndTime   = document.getElementById('form-end-time');
const formDuration  = document.getElementById('form-duration');

// ── Filter listeners ───────────────────────────────────
document.getElementById('filter-date').addEventListener('change', e => {
    state.date = e.target.value;
    state.startHour = null;
    loadSlots();
});

document.getElementById('filter-field').addEventListener('change', async e => {
    const opt = e.target.options[e.target.selectedIndex];
    state.fieldId   = e.target.value;
    state.fieldName = opt.text;
    state.startHour = null;
    await fetchFieldPrice(state.fieldId);
    loadSlots();
});

document.getElementById('filter-duration').addEventListener('change', e => {
    state.duration = parseInt(e.target.value);
    updateSummary();
});

// ── Fetch field price ──────────────────────────────────
async function fetchFieldPrice(fieldId) {
    // We'll rely on the already-rendered data; for full SPA you'd fetch from an API
    // For now just re-render summary
    updateSummary();
}

// ── Load slots via AJAX ────────────────────────────────
async function loadSlots() {
    scheduleGrid.innerHTML = '';
    scheduleLoading.classList.remove('hidden');
    scheduleTitle.textContent = 'Jadwal ' + state.fieldName;

    const dateObj = new Date(state.date + 'T00:00:00');
    const dayNames = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const monthNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    scheduleDate.textContent = dayNames[dateObj.getDay()] + ', ' + dateObj.getDate() + ' ' + monthNames[dateObj.getMonth()] + ' ' + dateObj.getFullYear();

    try {
        const res = await fetch(`/booking/slots?field_id=${state.fieldId}&date=${state.date}`, {
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const slots = await res.json();
        scheduleLoading.classList.add('hidden');
        renderSlots(slots);
    } catch(err) {
        scheduleLoading.classList.add('hidden');
        scheduleGrid.innerHTML = '<div class="px-6 py-8 text-center text-red-400 text-sm">Gagal memuat jadwal.</div>';
    }
}

// ── Render slots ───────────────────────────────────────
function renderSlots(slots) {
    scheduleGrid.innerHTML = '';
    slots.forEach(slot => {
        const row = document.createElement('div');
        row.className = 'px-6 py-3 flex items-center gap-4 hover:bg-gray-50 transition-colors cursor-default';

        const statusMap = {
            tersedia: { bg: 'bg-brand-100 text-brand-700 border-brand-200', cursor: 'cursor-pointer hover:bg-brand-200', icon: '✓' },
            penuh:    { bg: 'bg-red-100 text-red-700 border-red-200',       cursor: 'cursor-not-allowed opacity-60',     icon: '✕' },
            pending:  { bg: 'bg-amber-100 text-amber-700 border-amber-200', cursor: 'cursor-not-allowed opacity-60',     icon: '⏳' },
            blokir:   { bg: 'bg-gray-100 text-gray-500 border-gray-200',    cursor: 'cursor-not-allowed opacity-60',     icon: '🔒' },
        };
        const s = statusMap[slot.status] || statusMap.blokir;

        const isSelected = state.startHour === slot.hour;

        row.innerHTML = `
            <span class="font-mono text-xs text-gray-400 w-24 flex-shrink-0">${slot.label}</span>
            <button
                type="button"
                class="slot-btn flex-1 text-center py-2 px-4 rounded-xl border text-xs font-semibold transition-all ${s.bg} ${s.cursor} ${isSelected ? 'ring-2 ring-brand-500 ring-offset-1' : ''}"
                data-hour="${slot.hour}"
                data-status="${slot.status}"
                ${slot.status !== 'tersedia' ? 'disabled' : ''}
            >
                ${slot.text}${isSelected ? ' ✓' : ''}
            </button>
        `;

        row.querySelector('.slot-btn')?.addEventListener('click', () => {
            if (slot.status !== 'tersedia') return;
            state.startHour = slot.hour;
            renderSlots(slots); // re-render to update selection
            updateSummary();
            showForm();
        });

        scheduleGrid.appendChild(row);
    });
}

// ── Update summary panel ───────────────────────────────
function updateSummary() {
    if (!state.startHour) {
        [sumDate, sumField, sumTime, sumDuration, sumPrice, sumTotal].forEach(el => el.textContent = '–');
        return;
    }

    const dateObj = new Date(state.date + 'T00:00:00');
    const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    const endHour = state.startHour + state.duration;

    sumDate.textContent     = dateObj.getDate() + ' ' + months[dateObj.getMonth()] + ' ' + dateObj.getFullYear();
    sumField.textContent    = state.fieldName;
    sumTime.textContent     = pad(state.startHour) + ':00 - ' + pad(endHour) + ':00';
    sumDuration.textContent = state.duration + ' Jam';
    sumPrice.textContent    = 'Rp ' + fmt(state.pricePerHour) + '/jam';
    sumTotal.textContent    = 'Rp ' + fmt(state.pricePerHour * state.duration);

    // Fill hidden form
    formFieldId.value   = state.fieldId;
    formDate.value      = state.date;
    formStartTime.value = pad(state.startHour) + ':00';
    formEndTime.value   = pad(endHour) + ':00';
    formDuration.value  = state.duration;
}

function showForm() {
    hintEl.classList.add('hidden');
    bookingForm.classList.remove('hidden');
    bookingForm.classList.add('animate-pop');
}

function pad(n) { return String(n).padStart(2, '0'); }
function fmt(n) { return Number(n).toLocaleString('id-ID'); }

// ── Init ───────────────────────────────────────────────
// Update price info on field render
@if($selectedField)
state.pricePerHour = {{ $selectedField->price_per_hour }};
priceInfo.textContent = 'Rp {{ number_format($selectedField->price_per_hour, 0, ',', '.') }}/jam';
@endif
</script>
@endpush
