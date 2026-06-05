@extends('layouts.user')

@section('title', 'Formulir Pembatalan')

@section('content')

<div class="max-w-lg mx-auto">

    <div class="bg-white rounded-2xl shadow overflow-hidden">

        {{-- HEADER --}}
        <div class="bg-[#12B5A5] text-white p-5">

            <h1 class="text-xl font-bold">
                Formulir Pembatalan
            </h1>

        </div>

        {{-- BOOKING INFO --}}
        <div class="p-5">

            <div class="bg-[#E6F7F5] rounded-xl p-4 mb-6">

                <div class="flex justify-between">

                    <div>

                        <p class="font-semibold">
                            {{ $booking->reservation_code }}
                        </p>

                        <p class="text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}
                        </p>

                        <p class="text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                        </p>

                        <p class="text-sm text-gray-600">
                            {{ $booking->field->name }}
                        </p>

                    </div>

                </div>

            </div>

            <form
                action="{{ route('user.booking.cancel', $booking) }}"
                method="POST">

                @csrf

                <label class="block mb-3 font-medium">
                    Alasan Pembatalan
                </label>

                <div class="space-y-3">

                    @foreach([
                        'Perubahan Jadwal',
                        'Salah Memilih Tanggal/Jam',
                        'Fasilitas Tidak Sesuai',
                        'Menemukan Penawaran Lebih Baik',
                        'Alasan Lainnya'
                    ] as $reason)

                    <label
                        class="flex items-center gap-3 bg-[#12B5A5] text-white px-4 py-3 rounded-xl cursor-pointer">

                        <input
                            type="radio"
                            name="cancel_reason"
                            value="{{ $reason }}"
                            required>

                        {{ $reason }}

                    </label>

                    @endforeach

                </div>

                <button
                    type="submit"
                    class="w-full mt-6 bg-red-500 text-white py-3 rounded-xl">

                    Batalkan Booking

                </button>

            </form>

        </div>

    </div>

</div>

@endsection