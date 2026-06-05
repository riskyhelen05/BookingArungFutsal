@extends('layouts.user')

@section('title', 'Riwayat Booking')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-6">
        <p class="text-sm text-gray-500 mt-1">
            Kelola booking aktif dan lihat riwayat permainan Anda.
        </p>
    </div>

    {{-- TAB --}}
    <div class="flex gap-2 mb-6">

        <button
            id="tab-active"
            class="flex-1 py-3 rounded-xl bg-[#12B5A5] text-white font-semibold">
            Booking Aktif
        </button>

        <button
            id="tab-history"
            class="flex-1 py-3 rounded-xl bg-white border text-gray-600 font-semibold">
            Riwayat
        </button>

    </div>

    {{-- ACTIVE CONTENT --}}
    <div id="active-content" class="space-y-5">

        @forelse($activeBookings as $booking)

            @php

                $statusText = match($booking->status) {

                    'confirmed' => 'Pesanan Terkonfirmasi',
                    'pending' => 'Menunggu Pembayaran',
                    'waiting_confirmation' => 'Menunggu Konfirmasi',

                    default => ucfirst($booking->status)

                };

                $statusClass = match($booking->status) {

                    'confirmed' => 'bg-green-100 text-green-700',

                    'pending' => 'bg-yellow-100 text-yellow-700',

                    'waiting_confirmation' => 'bg-blue-100 text-blue-700',

                    default => 'bg-gray-100 text-gray-700'

                };

            @endphp

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                <div class="bg-[#12B5A5] text-white px-4 py-3 flex justify-between items-center">

                    <span class="text-sm">
                        {{ $booking->reservation_code }}
                    </span>

                    <span class="text-xs px-3 py-1 rounded-full {{ $statusClass }}">
                        {{ $statusText }}
                    </span>

                </div>

                <div class="p-5">

                    <h3 class="font-bold text-lg text-gray-800">
                        {{ $booking->field->name }}
                    </h3>

                    <div class="mt-4 grid md:grid-cols-2 gap-3 text-sm">

                        <div>
                            <p class="text-gray-500">Tanggal</p>
                            <p class="font-medium">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">Jam</p>
                            <p class="font-medium">
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">Durasi</p>
                            <p class="font-medium">
                                {{ $booking->duration_hours }} Jam
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">Total Bayar</p>
                            <p class="font-semibold text-[#12B5A5]">
                                Rp {{ number_format($booking->total_amount,0,',','.') }}
                            </p>
                        </div>

                    </div>

 {{-- BOOKING SUDAH DIKONFIRMASI --}}
@if($booking->status == 'confirmed')

    <a
        href="{{ route('user.booking.qr', $booking) }}"
        class="block mt-5 text-center bg-green-500 text-white py-3 rounded-xl">
        📱 Tampilkan QR Code
    </a>

@endif

{{-- MASIH MENUNGGU --}}
@if(in_array($booking->status,['pending','waiting_confirmation']))

    <div class="mt-5 grid grid-cols-2 gap-3">

        <a
            href="{{ route('user.booking.cancel.form', $booking) }}"
            class="text-center bg-red-500 text-white py-3 rounded-xl">
            Batalkan
        </a>

        <a
            href="{{ route('user.booking.show', $booking) }}"
            class="text-center bg-[#12B5A5] text-white py-3 rounded-xl">
            Detail
        </a>

    </div>

@endif

                </div>

            </div>

        @empty

            <div class="bg-white rounded-2xl shadow-sm p-10 text-center">

                <div class="text-5xl mb-3">
                    📅
                </div>

                <h3 class="font-semibold text-gray-700">
                    Belum Ada Booking Aktif
                </h3>

            </div>

        @endforelse

    </div>

    {{-- HISTORY CONTENT --}}
    <div id="history-content" class="space-y-5 hidden">

        @forelse($historyBookings as $booking)

            @php

                $statusText = $booking->status == 'completed'
                    ? 'Selesai'
                    : 'Dibatalkan';

                $statusClass = $booking->status == 'completed'
                    ? 'bg-green-100 text-green-700'
                    : 'bg-red-100 text-red-700';

            @endphp

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                <div class="bg-gray-100 px-4 py-3 flex justify-between items-center">

                    <span class="text-sm font-medium">
                        {{ $booking->reservation_code }}
                    </span>

                    <span class="text-xs px-3 py-1 rounded-full {{ $statusClass }}">
                        {{ $statusText }}
                    </span>

                </div>

                <div class="p-5">

                    <h3 class="font-bold text-lg">
                        {{ $booking->field->name }}
                    </h3>

                    <p class="text-sm text-gray-500 mt-2">
                        {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}
                    </p>

                    <p class="font-semibold text-[#12B5A5] mt-3">
                        Rp {{ number_format($booking->total_amount,0,',','.') }}
                    </p>

                    <div class="mt-4">

    <a
        href="{{ route('user.booking.show', $booking) }}"
        class="block text-center bg-gray-100 py-2 rounded-xl mb-2">
        Detail Booking
    </a>

    @if($booking->status == 'completed')

        @php
            $alreadyReview = \App\Models\Review::where(
                'booking_id',
                $booking->id
            )->exists();
        @endphp

@if($booking->status == 'completed')

    @if(!$booking->review)

        <a
            href="{{ route('user.review.create', $booking) }}"
            class="block text-center bg-[#12B5A5] text-white py-2 rounded-xl">
            ⭐ Beri Ulasan
        </a>

    @else

        <div
            class="text-center bg-green-100 text-green-700 py-2 rounded-xl">
            ✓ Sudah Diulas
        </div>

    @endif

@endif

    @endif

</div>

                </div>

            </div>

        @empty

            <div class="bg-white rounded-2xl shadow-sm p-10 text-center">

                <div class="text-5xl mb-3">
                    📖
                </div>

                <h3 class="font-semibold text-gray-700">
                    Belum Ada Riwayat Booking
                </h3>

            </div>

        @endforelse

    </div>

</div>

<script>

const tabActive = document.getElementById('tab-active');
const tabHistory = document.getElementById('tab-history');

const activeContent = document.getElementById('active-content');
const historyContent = document.getElementById('history-content');

tabActive.addEventListener('click', () => {

    activeContent.classList.remove('hidden');
    historyContent.classList.add('hidden');

    tabActive.classList.add('bg-[#12B5A5]', 'text-white');
    tabActive.classList.remove('bg-white', 'text-gray-600');

    tabHistory.classList.remove('bg-[#12B5A5]', 'text-white');
    tabHistory.classList.add('bg-white', 'text-gray-600');

});

tabHistory.addEventListener('click', () => {

    historyContent.classList.remove('hidden');
    activeContent.classList.add('hidden');

    tabHistory.classList.add('bg-[#12B5A5]', 'text-white');
    tabHistory.classList.remove('bg-white', 'text-gray-600');

    tabActive.classList.remove('bg-[#12B5A5]', 'text-white');
    tabActive.classList.add('bg-white', 'text-gray-600');

});

</script>

@endsection