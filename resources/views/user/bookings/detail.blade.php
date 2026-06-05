@extends('layouts.user')

@section('title', 'Detail Booking')

@section('content')

@php
$statusColor = match($booking->status) {
    'confirmed' => 'bg-green-100 text-green-700',
    'pending' => 'bg-yellow-100 text-yellow-700',
    'waiting_confirmation' => 'bg-blue-100 text-blue-700',
    'cancelled' => 'bg-red-100 text-red-700',
    'completed' => 'bg-purple-100 text-purple-700',
    default => 'bg-gray-100 text-gray-700'
};

$statusText = match($booking->status) {
    'confirmed' => 'TERKONFIRMASI',
    'pending' => 'MENUNGGU PEMBAYARAN',
    'waiting_confirmation' => 'MENUNGGU KONFIRMASI',
    'cancelled' => 'DIBATALKAN',
    'completed' => 'SELESAI',
    default => strtoupper($booking->status)
};
@endphp

<div class="max-w-xl mx-auto">

    {{-- STATUS --}}
    <div class="mb-4">

        <div class="bg-[#12B5A5] text-white py-3 rounded-xl text-center font-semibold text-sm uppercase">
            Pesanan {{ $statusText }}
        </div>

    </div>

    {{-- DETAIL BOOKING --}}
    <div class="bg-[#BDE6DF] border border-[#87D6C8] rounded-2xl overflow-hidden">

        <div class="bg-[#12B5A5] text-white px-4 py-2 font-semibold text-sm">
            INFORMASI BOOKING
        </div>

        <div class="p-5">

            <div class="space-y-3 text-sm">

                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">
                        Nomor Reservasi
                    </span>

                    <span class="font-bold">
                        {{ $booking->reservation_code }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-700">
                        Nama Pemesan
                    </span>

                    <span>
                        {{ auth()->user()->name }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-700">
                        Tanggal
                    </span>

                    <span>
                        {{ $booking->booking_date->translatedFormat('d M Y') }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-700">
                        Lapangan
                    </span>

                    <span>
                        {{ $booking->field->name }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-700">
                        Jam
                    </span>

                    <span>
                        {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                        -
                        {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-700">
                        Durasi
                    </span>

                    <span>
                        {{ $booking->duration_hours }} Jam
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-700">
                        Harga
                    </span>

                    <span class="font-semibold">
                        Rp {{ number_format($booking->total_amount,0,',','.') }}
                    </span>
                </div>

            </div>

        </div>

    </div>

    {{-- FASILITAS --}}
    <div class="bg-[#BDE6DF] border border-[#87D6C8] rounded-2xl overflow-hidden mt-5">

        <div class="bg-[#12B5A5] text-white px-4 py-2 font-semibold text-sm">
            RINCIAN FASILITAS
        </div>

        <div class="p-5">

            <ol class="list-decimal pl-5 text-sm text-gray-700 space-y-1">

                <li>Set Rompi Tim</li>
                <li>Bola Futsal</li>
                <li>Kamar Mandi</li>
                <li>Area Parkir</li>
                <li>Mushola</li>
                <li>Air Minum</li>

            </ol>

        </div>

    </div>

    {{-- AKSI --}}
    <div class="mt-6 space-y-3">

        @if($booking->status === 'confirmed')

            <a
                href="{{ route('user.booking.qr', $booking) }}"
                class="block w-full bg-[#12B5A5] text-white text-center py-3 rounded-xl font-semibold"
            >
                📱 Lihat QR Code
            </a>

        @endif

        @if(in_array($booking->status,['pending','waiting_confirmation']))

            <a
                href="{{ route('user.booking.cancel.form', $booking) }}"
                class="block w-full bg-red-500 text-white text-center py-3 rounded-xl font-semibold"
            >
                ❌ Batalkan Booking
            </a>

        @endif

        <a
            href="{{ route('user.booking.history') }}"
            class="block w-full border border-gray-300 text-center py-3 rounded-xl font-medium bg-white"
        >
            ← Kembali ke Riwayat
        </a>

    </div>

</div>

@endsection