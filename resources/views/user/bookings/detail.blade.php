@extends('layouts.user')

@section('title', 'Detail Booking')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-xl shadow p-6">

        <h1 class="text-2xl font-bold mb-6">
            Detail Booking
        </h1>

        <div class="grid gap-4">

            <div>
                <p class="text-gray-500">Kode Reservasi</p>
                <p class="font-semibold">
                    {{ $booking->reservation_code }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Lapangan</p>
                <p class="font-semibold">
                    {{ $booking->field->name }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Tanggal</p>
                <p class="font-semibold">
                    {{ $booking->booking_date }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Jam</p>
                <p class="font-semibold">
                    {{ $booking->start_time }}
                    -
                    {{ $booking->end_time }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Durasi</p>
                <p class="font-semibold">
                    {{ $booking->duration_hours }} Jam
                </p>
            </div>

            <div>
                <p class="text-gray-500">Total Bayar</p>
                <p class="font-semibold text-green-600">
                    Rp {{ number_format($booking->total_amount,0,',','.') }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Status</p>
                <p class="font-semibold">
                    {{ ucfirst($booking->status) }}
                </p>
            </div>

        </div>

        <div class="mt-6 flex gap-3">

            <a
                href="{{ route('user.booking.qr', $booking) }}"
                class="bg-green-500 text-white px-4 py-2 rounded-lg"
            >
                QR Code
            </a>

            @if(in_array($booking->status,['pending','waiting_confirmation']))
                <a
                    href="{{ route('user.booking.cancel.form', $booking) }}"
                    class="bg-red-500 text-white px-4 py-2 rounded-lg"
                >
                    Batalkan
                </a>
            @endif

        </div>

    </div>

</div>

@endsection