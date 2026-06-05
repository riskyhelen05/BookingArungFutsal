@extends('layouts.user')

@section('title', 'QR Booking')

@section('content')

<div class="max-w-xl mx-auto">
    
    <div class="bg-white rounded-2xl shadow-md p-8 text-center">

        <h1 class="text-2xl font-bold text-gray-800 mb-2">
            QR Booking
        </h1>

        <p class="text-gray-500 mb-6">
            Tunjukkan QR Code ini kepada petugas saat datang.
        </p>

        <div class="flex justify-center mb-6">
            <div class="p-4 bg-white border rounded-xl">
                {!! QrCode::size(250)->generate(json_encode([
                    'code'  => $booking->reservation_code,
                    'field' => $booking->field->name,
                    'date'  => $booking->booking_date,
                ])) !!}
            </div>
        </div>

        <div class="border-t pt-4 text-sm text-gray-600 space-y-1">
            <p>
                <span class="font-semibold">Kode Booking:</span>
                {{ $booking->reservation_code }}
            </p>

            <p>
                <span class="font-semibold">Lapangan:</span>
                {{ $booking->field->name }}
            </p>

            <p>
                <span class="font-semibold">Tanggal:</span>
                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
            </p>
        </div>

        <div class="mt-6">
            <a
                href="{{ route('user.booking.show', $booking) }}"
                class="inline-flex items-center px-4 py-2 bg-[#1ABC9C] text-white rounded-lg hover:bg-[#16a085] transition"
            >
                ← Kembali ke Detail
            </a>
        </div>

    </div>

</div>

@endsection