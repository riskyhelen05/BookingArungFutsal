@extends('layouts.user')

@section('title', 'Booking Lapangan')

@section('content')
<div class="min-h-screen bg-[#DFFBF5]">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-[240px_1fr] gap-6 p-5 lg:p-8">

        {{-- LEFT NAVBAR / SIDEBAR --}}
        <aside class="hidden lg:block">
            <div class="sticky top-6 bg-white rounded-3xl border border-emerald-100 shadow-sm p-5">
                <div class="mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-teal-500 flex items-center justify-center text-white font-black text-xl">
                        B
                    </div>
                    <h2 class="mt-3 text-lg font-extrabold text-gray-900">Booking</h2>
                    <p class="text-xs text-gray-400">Pilih jadwal futsal kamu</p>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center gap-3 bg-teal-50 text-teal-700 rounded-2xl px-4 py-3">
                        <div class="w-7 h-7 rounded-full bg-teal-500 text-white flex items-center justify-center text-xs font-bold">1</div>
                        <span class="text-sm font-bold">Pilih Lapangan</span>
                    </div>

                    <div class="flex items-center gap-3 text-gray-400 rounded-2xl px-4 py-3">
                        <div class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold">2</div>
                        <span class="text-sm font-semibold">Pembayaran</span>
                    </div>

                    <div class="flex items-center gap-3 text-gray-400 rounded-2xl px-4 py-3">
                        <div class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold">3</div>
                        <span class="text-sm font-semibold">Selesai</span>
                    </div>
                </div>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main>
            <div class="max-w-5xl mx-auto">
                <div class="grid grid-cols-1 xl:grid-cols-[1.2fr_.8fr] gap-5">

                    {{-- LEFT CARD --}}
                    <section class="space-y-5">

                        {{-- FILTER --}}
                        <div class="bg-white/80 rounded-3xl border border-emerald-200 p-5 shadow-sm">
                            <p class="text-sm font-bold text-gray-800 mb-4">
                                Pilih lapangan dan jadwal
                            </p>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">Pilih Tanggal</label>
                                    <input type="date" id="filter-date"
                                           value="{{ $selectedDate }}"
                                           min="{{ now()->format('Y-m-d') }}"
                                           class="w-full h-10 rounded-xl border border-gray-200 bg-white px-3 text-xs font-semibold text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-400">
                                </div>

                                <div>
                                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">Pilih Lapangan</label>
                                    <select id="filter-field"
                                            class="w-full h-10 rounded-xl border border-gray-200 bg-white px-3 text-xs font-semibold text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-400">
                                        @foreach($fields as $f)
                                        <option value="{{ $f->id }}"
                                            data-price="{{ $f->price_per_hour }}"
                                            data-name="{{ $f->name }}"
                                            {{ $f->id === optional($selectedField)->id ? 'selected' : '' }}>
                                            {{ $f->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[11px] font-semibold text-gray-500 mb-1">Pilih Durasi</label>
                                    <select id="filter-duration"
                                            class="w-full h-10 rounded-xl border border-gray-200 bg-white px-3 text-xs font-semibold text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-400">
                                        @for($d = 1; $d <= 4; $d++)
                                        <option value="{{ $d }}" {{ $d === $selectedDuration ? 'selected' : '' }}>
                                            {{ $d }} Jam
                                        </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- JADWAL --}}
                        <div class="bg-white/80 rounded-3xl border border-emerald-200 p-5 shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-sm font-extrabold text-gray-800" id="schedule-title">
                                    Jadwal {{ optional($selectedField)->name ?? '–' }}
                                </h2>
                                <span class="text-[11px] font-semibold text-gray-400" id="schedule-date">
                                    {{ \Carbon\Carbon::parse($selectedDate)->isoFormat('D MMMM YYYY') }}
                                </span>
                            </div>

                            <div class="space-y-2" id="schedule-grid">
                                @forelse($schedule as $slot)
                                    @include('booking._slot', ['slot' => $slot])
                                @empty
                                    <div class="py-8 text-center text-gray-400 text-sm">
                                        Pilih lapangan untuk melihat jadwal.
                                    </div>
                                @endforelse
                            </div>

                            <div id="schedule-loading" class="hidden py-8 text-center">
                                <div class="inline-flex items-center gap-2 text-teal-600 text-sm font-bold">
                                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                                    </svg>
                                    Memuat jadwal...
                                </div>
                            </div>
                        </div>

                    </section>

                    {{-- RIGHT SUMMARY --}}
                    <aside class="space-y-4">

                        <div class="bg-white/80 rounded-3xl border border-emerald-200 p-5 shadow-sm">
                            <h2 class="text-base font-extrabold text-gray-900 mb-5">
                                Ringkasan Booking
                            </h2>

                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between gap-4">
                                    <span class="text-gray-500 font-medium">Nama Pemesan</span>
                                    <span class="font-semibold text-gray-700 text-right">{{ Auth::user()->name }}</span>
                                </div>

                                <div class="flex justify-between gap-4">
                                    <span class="text-gray-500 font-medium">Tanggal</span>
                                    <span class="font-semibold text-gray-700 text-right" id="sum-date">–</span>
                                </div>

                                <div class="flex justify-between gap-4">
                                    <span class="text-gray-500 font-medium">Lapangan</span>
                                    <span class="font-semibold text-gray-700 text-right" id="sum-field">–</span>
                                </div>

                                <div class="flex justify-between gap-4">
                                    <span class="text-gray-500 font-medium">Jam</span>
                                    <span class="font-semibold text-gray-700 text-right" id="sum-time">–</span>
                                </div>

                                <div class="flex justify-between gap-4">
                                    <span class="text-gray-500 font-medium">Durasi</span>
                                    <span class="font-bold text-gray-800 text-right" id="sum-duration">–</span>
                                </div>

                                <div class="flex justify-between gap-4">
                                    <span class="text-gray-500 font-medium">Harga</span>
                                    <span class="font-semibold text-gray-700 text-right" id="sum-price">–</span>
                                </div>

                                <div class="border-t border-gray-200 pt-4 mt-4 flex justify-between items-center gap-4">
                                    <span class="font-bold text-gray-800">Total Pembayaran</span>
                                    <span class="font-extrabold text-teal-600 text-xl" id="sum-total">–</span>
                                </div>
                            </div>
                        </div>

                        <div id="hint-select" class="bg-white/70 border border-emerald-200 rounded-2xl px-4 py-3 text-sm text-teal-700 text-center font-semibold">
                            Klik jam <span class="font-black">Tersedia</span> di jadwal
                        </div>

                        <form action="{{ route('user.booking.store') }}" method="POST" id="booking-form" class="hidden">
                            @csrf
                            <input type="hidden" name="field_id" id="form-field-id">
                            <input type="hidden" name="date" id="form-date">
                            <input type="hidden" name="start_time" id="form-start-time">
                            <input type="hidden" name="end_time" id="form-end-time">
                            <input type="hidden" name="duration" id="form-duration">

                            <button type="submit"
                                    class="w-full h-14 rounded-full bg-teal-500 hover:bg-teal-600 active:scale-[.98] text-white font-extrabold shadow-lg shadow-teal-200 transition-all flex items-center justify-center gap-3">
                                Lanjut ke Pembayaran

                                <span class="w-8 h-8 rounded-full bg-white text-teal-500 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </button>
                        </form>

                        <p class="text-center text-xs text-gray-400" id="price-info">
                            @if($selectedField)
                                Rp {{ number_format($selectedField->price_per_hour, 0, ',', '.') }}/jam
                            @endif
                        </p>

                    </aside>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    const CSRF = document.querySelector('meta[name="csrf-token"]').content;
    const SLOTS_URL = '/user/booking/slots';

    const state = {
        date: @json($selectedDate),
        fieldId: @json(optional($selectedField)->id ?? ''),
        fieldName: @json(optional($selectedField)->name ?? ''),
        pricePerHour: {{ (int)(optional($selectedField)->price_per_hour ?? 0) }},
        duration: {{ (int)$selectedDuration }},
        startHour: null,
    };

    let currentSlots = [];

    const scheduleGrid = document.getElementById('schedule-grid');
    const scheduleLoading = document.getElementById('schedule-loading');
    const scheduleTitle = document.getElementById('schedule-title');
    const scheduleDateEl = document.getElementById('schedule-date');
    const bookingForm = document.getElementById('booking-form');
    const hintEl = document.getElementById('hint-select');
    const priceInfoEl = document.getElementById('price-info');

    const sumDate = document.getElementById('sum-date');
    const sumField = document.getElementById('sum-field');
    const sumTime = document.getElementById('sum-time');
    const sumDuration = document.getElementById('sum-duration');
    const sumPrice = document.getElementById('sum-price');
    const sumTotal = document.getElementById('sum-total');

    const formFieldId = document.getElementById('form-field-id');
    const formDate = document.getElementById('form-date');
    const formStartTime = document.getElementById('form-start-time');
    const formEndTime = document.getElementById('form-end-time');
    const formDuration = document.getElementById('form-duration');

    function pad(n) {
        return String(n).padStart(2, '0');
    }

    function fmt(n) {
        return Number(n).toLocaleString('id-ID');
    }

    const DAYS = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const MONTHS = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    const MON_S = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

    function fmtLong(d) {
        const x = new Date(d + 'T00:00:00');
        return DAYS[x.getDay()] + ', ' + x.getDate() + ' ' + MONTHS[x.getMonth()] + ' ' + x.getFullYear();
    }

    function fmtShort(d) {
        const x = new Date(d + 'T00:00:00');
        return x.getDate() + ' ' + MON_S[x.getMonth()] + ' ' + x.getFullYear();
    }

    document.getElementById('filter-date').addEventListener('change', function(e) {
        state.date = e.target.value;
        state.startHour = null;

        resetSummary();
        hideForm();
        loadSlots();
    });

    document.getElementById('filter-field').addEventListener('change', function(e) {
        const opt = e.target.options[e.target.selectedIndex];

        state.fieldId = e.target.value;
        state.fieldName = opt.dataset.name || opt.text;
        state.pricePerHour = parseInt(opt.dataset.price) || 0;
        state.startHour = null;

        priceInfoEl.textContent = 'Rp ' + fmt(state.pricePerHour) + '/jam';

        resetSummary();
        hideForm();
        loadSlots();
    });

    document.getElementById('filter-duration').addEventListener('change', function(e) {
        state.duration = parseInt(e.target.value);

        if (state.startHour) {
            if (!canSelectDuration(currentSlots, state.startHour)) {
                state.startHour = null;
                resetSummary();
                hideForm();
            } else {
                updateSummary();
            }
        }

        renderSlots(currentSlots);
    });

    async function loadSlots() {
        scheduleGrid.innerHTML = '';
        scheduleLoading.classList.remove('hidden');
        scheduleTitle.textContent = 'Jadwal ' + state.fieldName;
        scheduleDateEl.textContent = fmtLong(state.date);

        try {
            const url = SLOTS_URL + '?field_id=' + encodeURIComponent(state.fieldId) + '&date=' + encodeURIComponent(state.date);

            const res = await fetch(url, {
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                }
            });

            if (!res.ok) throw new Error('Error ' + res.status);

            const slots = await res.json();
            currentSlots = slots;

            scheduleLoading.classList.add('hidden');
            renderSlots(slots);

        } catch(err) {
            currentSlots = [];
            scheduleLoading.classList.add('hidden');
            scheduleGrid.innerHTML = '<div class="py-8 text-center text-red-400 text-sm">Gagal memuat jadwal. Coba lagi.</div>';
        }
    }

    const STATUS_MAP = {
        tersedia: 'bg-emerald-100 text-emerald-700 border-emerald-200 hover:bg-emerald-200 cursor-pointer',
        penuh: 'bg-rose-100 text-rose-600 border-rose-200 cursor-not-allowed',
        pending: 'bg-amber-100 text-amber-700 border-amber-200 cursor-not-allowed',
        blokir: 'bg-gray-100 text-gray-400 border-gray-200 cursor-not-allowed',
    };

    function isSlotSelected(slotHour) {
        if (state.startHour === null) return false;

        return Number(slotHour) >= Number(state.startHour) &&
               Number(slotHour) < Number(state.startHour) + Number(state.duration);
    }

    function canSelectDuration(slots, startHour) {
        for (let h = Number(startHour); h < Number(startHour) + Number(state.duration); h++) {
            const target = slots.find(function(s) {
                return Number(s.hour) === Number(h);
            });

            if (!target || target.status !== 'tersedia') {
                return false;
            }
        }

        return true;
    }

    function renderSlots(slots) {
        scheduleGrid.innerHTML = '';

        slots.forEach(function(slot) {
            const cls = STATUS_MAP[slot.status] || STATUS_MAP.blokir;
            const selectedRange = isSlotSelected(slot.hour);

            const row = document.createElement('div');
            row.className = 'grid grid-cols-[90px_1fr] items-center gap-3';

            row.innerHTML = `
                <span class="text-[11px] text-gray-500 font-medium">${slot.label}</span>

                <button type="button"
                    class="slot-btn h-7 rounded-lg border text-[11px] font-bold transition-all
                    ${cls}
                    ${selectedRange ? 'bg-teal-600 text-white border-teal-600 ring-2 ring-teal-300' : ''}"
                    data-hour="${slot.hour}"
                    data-status="${slot.status}"
                    ${slot.status !== 'tersedia' ? 'disabled' : ''}>
                    ${slot.text}${selectedRange ? ' ✓' : ''}
                </button>
            `;

            row.querySelector('.slot-btn')?.addEventListener('click', function() {
                if (slot.status !== 'tersedia') return;

                if (!canSelectDuration(slots, slot.hour)) {
                    alert('Durasi yang dipilih melewati slot yang tidak tersedia.');
                    return;
                }

                state.startHour = Number(slot.hour);

                renderSlots(slots);
                updateSummary();
                showForm();
            });

            scheduleGrid.appendChild(row);
        });
    }

    function resetSummary() {
        [sumDate, sumField, sumTime, sumDuration, sumPrice, sumTotal].forEach(function(el) {
            el.textContent = '–';
        });
    }

    function updateSummary() {
        if (state.startHour === null) {
            resetSummary();
            return;
        }

        const endH = Number(state.startHour) + Number(state.duration);

        sumDate.textContent = fmtShort(state.date);
        sumField.textContent = state.fieldName;
        sumTime.textContent = pad(state.startHour) + ':00 – ' + pad(endH) + ':00';
        sumDuration.textContent = state.duration + ' Jam';
        sumPrice.textContent = 'Rp ' + fmt(state.pricePerHour) + '/jam';
        sumTotal.textContent = 'Rp ' + fmt(state.pricePerHour * state.duration);

        formFieldId.value = state.fieldId;
        formDate.value = state.date;
        formStartTime.value = pad(state.startHour) + ':00';
        formEndTime.value = pad(endH) + ':00';
        formDuration.value = state.duration;
    }

    function showForm() {
        hintEl.classList.add('hidden');
        bookingForm.classList.remove('hidden');
    }

    function hideForm() {
        bookingForm.classList.add('hidden');
        hintEl.classList.remove('hidden');
    }

    if (state.pricePerHour > 0) {
        priceInfoEl.textContent = 'Rp ' + fmt(state.pricePerHour) + '/jam';
    }
    if (state.fieldId && state.date) {
    loadSlots();
}
})();
</script>
@endpush