@extends('layouts.user')

@section('title', 'Batalkan Booking')

@section('content')

<div class="max-w-xl mx-auto">

    <div class="bg-white rounded-xl shadow p-6">

        <h1 class="text-xl font-bold mb-4">
            Batalkan Booking
        </h1>

        <p class="mb-6">
            Apakah Anda yakin ingin membatalkan booking
            <strong>{{ $booking->reservation_code }}</strong> ?
        </p>

        <form
            action="{{ route('user.booking.cancel', $booking) }}"
            method="POST"
        >
            @csrf

            <button
                type="submit"
                class="bg-red-500 text-white px-4 py-2 rounded-lg"
            >
                Ya, Batalkan
            </button>

            <a
                href="{{ route('user.booking.show', $booking) }}"
                class="ml-2 px-4 py-2 border rounded-lg"
            >
                Kembali
            </a>

        </form>

    </div>

</div>

@endsection