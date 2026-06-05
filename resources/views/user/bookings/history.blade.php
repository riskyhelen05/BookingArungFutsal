@extends('layouts.user')

@section('title', 'Riwayat Booking')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Riwayat Booking
</h1>

<div class="space-y-4">

    @forelse($activeBookings as $booking)

        <div
            class="bg-white rounded-xl shadow p-5">

            <div
                class="flex justify-between items-center">

                <div>

                    <h2 class="font-bold">

                        {{ $booking->field->name }}

                    </h2>

                    <p class="text-sm text-gray-500">

                        {{ $booking->reservation_code }}

                    </p>

                </div>

            @php
    $badge = match($booking->status) {
        'pending' => 'bg-gray-100 text-gray-700',
        'waiting_confirmation' => 'bg-yellow-100 text-yellow-700',
        'confirmed' => 'bg-green-100 text-green-700',
        'completed' => 'bg-blue-100 text-blue-700',
        'cancelled' => 'bg-red-100 text-red-700',
        default => 'bg-gray-100 text-gray-700'
    };
@endphp

<span class="px-3 py-1 rounded-full text-sm {{ $badge }}">
    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
</span>

            </div>

            <div class="mt-4">

                <p>
                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                </p>

                <p>
                    {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
-
{{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                </p>

                <p class="font-semibold mt-2">

                    Rp
                    {{ number_format($booking->total_amount,0,',','.') }}

                </p>

                <div class="mt-4">

    <a
    href="{{ route('user.booking.show', $booking) }}"
    class="inline-block mt-2 text-sm font-semibold text-[#1ABC9C] hover:underline"
>
    Lihat Detail →
</a>

</div>

            </div>

        </div>

    @empty

        <div
            class="bg-white rounded-xl p-6 text-center">

            Belum ada booking.

        </div>

    @endforelse

</div>

@endsection