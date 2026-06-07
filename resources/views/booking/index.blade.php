@extends('layouts.user')

@section('title', 'Booking Lapangan')

@section('content')
<div class="p-6 lg:p-8 max-w-7xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-6 animate-fade-up">
        <div class="flex items-center gap-2 text-xs text-brand-600 font-semibold mb-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Booking Lapangan Futsal
        </div>
        <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Pilih Lapangan & Jadwal</h1>
        <p class="text-sm text-gray-500 mt-0.5">Pilih tanggal, lapangan, dan jam yang kamu inginkan.</p>
    </div>

    {{-- Step Indicator --}}
    <div class="flex items-center gap-2 mb-8 animate-fade-up" style="animation-delay:.05s">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-full bg-brand-500 text-white flex items-center justify-center text-xs font-bold shadow">1</div>
            <span class="text-xs font-semibold text-brand-700 hidden sm:block">Pilih Jadwal</span>
        </div>
        <div class="step-line"></div>
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center text-xs font-bold">2</div>
            <span class="text-xs text-gray-400 hidden sm:block">Pembayaran</span>
        </div>
        <div class="step-line"></div>
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center text-xs font-bold">3</div>
            <span class="text-xs text-gray-400 hidden sm:block">Selesai</span>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- LEFT: Filter + Schedule --}}
        <div class="xl:col-span-2 space-y-5">

            {{-- Filter Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 animate-fade-up" style="animation-delay:.08s">
                <h2 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/></svg>
                    Filter Pencarian
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Tanggal</label>
                        <input type="date" id="filter-date"
                               value="{{ $selectedDate }}"
                               min="{{ now()->format('Y-m-d') }}"
                               class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition-all" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Lapangan</label>
                        <select id="filter-field"
                                class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition-all bg-white">
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
                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Durasi</label>
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
            <div class="flex flex-wrap gap-2 px-1 animate-fade-up" style="animation-delay:.1s">
                @foreach([
                    ['bg-brand-100 text-brand-700 border-brand-200', 'Tersedia'],
                    ['bg-red-100 text-red-700 border-red-200', 'Penuh'],
                    ['bg-amber-100 text-amber-700 border-amber-200', 'Pending'],
                    ['bg-gray-100 text-gray-500 border-gray-200', 'Terblokir'],
                ] as [$cls, $lbl])
                <div class="flex items-center gap-1.5 text-xs font-medium {{ $cls }} border px-2.5 py-1 rounded-lg">
                    <span class="w-2 h-2 rounded-sm inline-block bg-current opacity-60"></span>
                    {{ $lbl }}
                </div>
                @endforeach
            </div>

            {{-- Schedule Grid --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-fade-up" style="animation-delay:.13s">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="font-bold text-gray-800 text-sm" id="schedule-title">
                        Jadwal {{ optional($selectedField)->name ?? '–' }}
                    </h2>
                    <span class="text-xs text-gray-400 font-mono" id="schedule-date">
                        {{ \Carbon\Carbon::parse($selectedDate)->isoFormat('dddd, D MMMM YYYY') }}
                    </span>
                </div>

                <div class="divide-y divide-gray-50" id="schedule-grid">
                    @forelse($schedule as $slot)
                        @include('booking._slot', ['slot' => $slot])
                    @empty
                        <div class="px-5 py-8 text-center text-gray-400 text-sm">Pilih lapangan untuk melihat jadwal.</div>
                    @endforelse
                </div>

                <div id="schedule-loading" class="hidden px-5 py-8 text-center">
                    <div class="inline-flex items-center gap-2 text-brand-600 text-sm font-medium">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                        Memuat jadwal...
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Ringkasan --}}
        <div class="xl:col-span-1">
            <div class="sticky top-6 space-y-4">

                {{-- Ringkasan card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 animate-slide-in" style="animation-delay:.18s">
                    <h2 class="font-bold text-gray-800 mb-4 flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Ringkasan Booking
                    </h2>
                    <div class="space-y-2.5 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Nama Pemesan</span>
                            <span class="font-semibold text-gray-800 text-right">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Tanggal</span>
                            <span class="font-semibold text-gray-800" id="sum-date">–</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Lapangan</span>
                            <span class="font-semibold text-gray-800" id="sum-field">–</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Jam</span>
                            <span class="font-semibold text-gray-800" id="sum-time">–</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Durasi</span>
                            <span class="font-semibold text-gray-800" id="sum-duration">–</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Harga</span>
                            <span class="text-gray-600" id="sum-price">–</span>
                        </div>
                        <div class="border-t border-dashed border-gray-100 pt-2.5 flex justify-between">
                            <span class="font-bold text-gray-900">Total</span>
                            <span class="font-extrabold text-brand-600" id="sum-total">–</span>
                        </div>
                    </div>
                </div>

                {{-- Hint --}}
                <div id="hint-select" class="bg-brand-50 border border-brand-100 rounded-xl px-4 py-3 text-sm text-brand-700 text-center">
                    👆 Klik jam <span class="font-bold">Tersedia</span> di jadwal
                </div>

                {{-- Form --}}
                <form action="{{ route('user.booking.store') }}" method="POST" id="booking-form" class="hidden">
                    @csrf
                    <input type="hidden" name="field_id"   id="form-field-id" />
                    <input type="hidden" name="date"        id="form-date" />
                    <input type="hidden" name="start_time"  id="form-start-time" />
                    <input type="hidden" name="end_time"    id="form-end-time" />
                    <input type="hidden" name="duration"    id="form-duration" />
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-brand-500 hover:bg-brand-600 active:scale-95 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-brand-200/50 transition-all text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Lanjut ke Pembayaran
                    </button>
                </form>

                <p class="text-center text-xs text-gray-400" id="price-info">
                    @if($selectedField)
                    Rp {{ number_format($selectedField->price_per_hour, 0, ',', '.') }}/jam
                    @endif
                </p>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    const CSRF      = document.querySelector('meta[name="csrf-token"]').content;
    const SLOTS_URL = '/user/booking/slots';

    const state = {
        date:         @json($selectedDate),
        fieldId:      @json(optional($selectedField)->id ?? ''),
        fieldName:    @json(optional($selectedField)->name ?? ''),
        pricePerHour: {{ (int)(optional($selectedField)->price_per_hour ?? 0) }},
        duration:     {{ (int)$selectedDuration }},
        startHour:    null,
    };

    // DOM
    const scheduleGrid    = document.getElementById('schedule-grid');
    const scheduleLoading = document.getElementById('schedule-loading');
    const scheduleTitle   = document.getElementById('schedule-title');
    const scheduleDateEl  = document.getElementById('schedule-date');
    const bookingForm     = document.getElementById('booking-form');
    const hintEl          = document.getElementById('hint-select');
    const priceInfoEl     = document.getElementById('price-info');

    const sumDate     = document.getElementById('sum-date');
    const sumField    = document.getElementById('sum-field');
    const sumTime     = document.getElementById('sum-time');
    const sumDuration = document.getElementById('sum-duration');
    const sumPrice    = document.getElementById('sum-price');
    const sumTotal    = document.getElementById('sum-total');

    const formFieldId   = document.getElementById('form-field-id');
    const formDate      = document.getElementById('form-date');
    const formStartTime = document.getElementById('form-start-time');
    const formEndTime   = document.getElementById('form-end-time');
    const formDuration  = document.getElementById('form-duration');

    function pad(n) { return String(n).padStart(2, '0'); }
    function fmt(n) { return Number(n).toLocaleString('id-ID'); }

    const DAYS   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const MONTHS = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    const MON_S  = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

    function fmtLong(d)  { const x = new Date(d+'T00:00:00'); return DAYS[x.getDay()]+', '+x.getDate()+' '+MONTHS[x.getMonth()]+' '+x.getFullYear(); }
    function fmtShort(d) { const x = new Date(d+'T00:00:00'); return x.getDate()+' '+MON_S[x.getMonth()]+' '+x.getFullYear(); }

    // Listeners
    document.getElementById('filter-date').addEventListener('change', function(e) {
        state.date = e.target.value; state.startHour = null;
        resetSummary(); hideForm(); loadSlots();
    });

    document.getElementById('filter-field').addEventListener('change', function(e) {
        const opt = e.target.options[e.target.selectedIndex];
        state.fieldId      = e.target.value;
        state.fieldName    = opt.dataset.name || opt.text;
        state.pricePerHour = parseInt(opt.dataset.price) || 0;
        state.startHour    = null;
        priceInfoEl.textContent = 'Rp ' + fmt(state.pricePerHour) + '/jam';
        resetSummary(); hideForm(); loadSlots();
    });

    document.getElementById('filter-duration').addEventListener('change', function(e) {
        state.duration = parseInt(e.target.value);
        if (state.startHour) updateSummary();
    });

    async function loadSlots() {
        scheduleGrid.innerHTML = '';
        scheduleLoading.classList.remove('hidden');
        scheduleTitle.textContent  = 'Jadwal ' + state.fieldName;
        scheduleDateEl.textContent = fmtLong(state.date);

        try {
            const url = SLOTS_URL + '?field_id=' + encodeURIComponent(state.fieldId) + '&date=' + encodeURIComponent(state.date);
            const res = await fetch(url, { headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' } });
            if (!res.ok) throw new Error('Error ' + res.status);
            const slots = await res.json();
            scheduleLoading.classList.add('hidden');
            renderSlots(slots);
        } catch(err) {
            scheduleLoading.classList.add('hidden');
            scheduleGrid.innerHTML = '<div class="px-5 py-8 text-center text-red-400 text-sm">Gagal memuat jadwal. Coba lagi.</div>';
        }
    }

    const STATUS_MAP = {
        tersedia: 'bg-brand-100 text-brand-700 border-brand-200 cursor-pointer hover:bg-brand-200',
        penuh:    'bg-red-100 text-red-700 border-red-200 cursor-not-allowed opacity-60',
        pending:  'bg-amber-100 text-amber-700 border-amber-200 cursor-not-allowed opacity-60',
        blokir:   'bg-gray-100 text-gray-500 border-gray-200 cursor-not-allowed opacity-60',
    };

    function renderSlots(slots) {
        scheduleGrid.innerHTML = '';
        slots.forEach(function(slot) {
            const cls = STATUS_MAP[slot.status] || STATUS_MAP.blokir;
            const sel = state.startHour === slot.hour;

            const row = document.createElement('div');
            row.className = 'px-5 py-2.5 flex items-center gap-4 hover:bg-gray-50 transition-colors';

            row.innerHTML = `
                <span class="font-mono text-xs text-gray-400 w-24 flex-shrink-0">${slot.label}</span>
                <button type="button"
                    class="slot-btn flex-1 text-center py-2 px-3 rounded-xl border text-xs font-semibold transition-all ${cls} ${sel ? 'ring-2 ring-brand-500 ring-offset-1' : ''}"
                    data-hour="${slot.hour}" data-status="${slot.status}"
                    ${slot.status !== 'tersedia' ? 'disabled' : ''}>
                    ${slot.text}${sel ? ' ✓' : ''}
                </button>
            `;

            row.querySelector('.slot-btn')?.addEventListener('click', function() {
                if (slot.status !== 'tersedia') return;
                state.startHour = slot.hour;
                renderSlots(slots);
                updateSummary();
                showForm();
            });

            scheduleGrid.appendChild(row);
        });
    }

    function resetSummary() {
        [sumDate, sumField, sumTime, sumDuration, sumPrice, sumTotal].forEach(el => el.textContent = '–');
    }

    function updateSummary() {
        if (!state.startHour) { resetSummary(); return; }
        const endH = state.startHour + state.duration;
        sumDate.textContent     = fmtShort(state.date);
        sumField.textContent    = state.fieldName;
        sumTime.textContent     = pad(state.startHour) + ':00 – ' + pad(endH) + ':00';
        sumDuration.textContent = state.duration + ' Jam';
        sumPrice.textContent    = 'Rp ' + fmt(state.pricePerHour) + '/jam';
        sumTotal.textContent    = 'Rp ' + fmt(state.pricePerHour * state.duration);
        formFieldId.value   = state.fieldId;
        formDate.value      = state.date;
        formStartTime.value = pad(state.startHour) + ':00';
        formEndTime.value   = pad(endH) + ':00';
        formDuration.value  = state.duration;
    }

    function showForm() { hintEl.classList.add('hidden'); bookingForm.classList.remove('hidden'); }
    function hideForm() { bookingForm.classList.add('hidden'); hintEl.classList.remove('hidden'); }

    if (state.pricePerHour > 0) priceInfoEl.textContent = 'Rp ' + fmt(state.pricePerHour) + '/jam';
})();
</script>
@endpush