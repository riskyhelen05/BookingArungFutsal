@extends('layouts.user')

@section('title', 'Pembatalan Berhasil')

@section('content')

<div class="max-w-md mx-auto">

    <div class="bg-[#12B5A5] rounded-3xl p-8 text-center text-white">

        <div class="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center">

            <span class="text-5xl text-[#12B5A5]">
                ✓
            </span>

        </div>

        <h1 class="text-3xl font-bold mt-8">
            Pesanan Berhasil
            Dibatalkan
        </h1>

        <p class="mt-6 text-white/90">
            Pesanan dengan Nomor Reservasi
            <br>

            <span class="font-bold">
                {{ $booking->reservation_code }}
            </span>

            <br>

            pada

            {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}

            telah dibatalkan.
        </p>

        <div class="mt-10">

            <p class="font-semibold uppercase leading-tight">
                Dana akan dikembalikan
                sesuai kebijakan yang berlaku.
            </p>

        </div>

        <div class="mt-12">

            <a
                href="{{ route('user.booking.history') }}"
                class="inline-block bg-[#0F8D80] px-6 py-3 rounded-xl"
            >
                Kembali ke Riwayat
            </a>

        </div>

    </div>

</div>

@endsection