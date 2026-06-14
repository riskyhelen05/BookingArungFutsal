@extends('layouts.user')

@section('title', 'Beranda')

@section('content')

@php

$nextBooking = \App\Models\Booking::where('user_id', Auth::id())
    ->whereIn('status', [
        'confirmed',
        'pending',
        'waiting_confirmation'
    ])
    ->with('field')
    ->latest()
    ->first();

$statusColor = 'bg-gray-100 text-gray-700';
$statusText = '-';

if ($nextBooking) {
    $statusColor = match($nextBooking->status) {
        'confirmed' => 'bg-green-100 text-green-700',
        'pending' => 'bg-yellow-100 text-yellow-700',
        'waiting_confirmation' => 'bg-blue-100 text-blue-700',
        default => 'bg-gray-100 text-gray-700'
    };

    $statusText = match($nextBooking->status) {
        'confirmed' => 'Dikonfirmasi',
        'pending' => 'Menunggu Pembayaran',
        'waiting_confirmation' => 'Menunggu Konfirmasi',
        default => ucfirst($nextBooking->status)
    };
}

@endphp

<div class="space-y-5">

    {{-- Header --}}
    <div class="bg-[#12B5A5] text-white rounded-b-[32px] px-6 pt-8 pb-8">

        <h1 class="text-2xl font-bold">
            Halo, {{ Auth::user()->name }}!
        </h1>

        <p class="mt-1 text-sm text-teal-100">
            Siap main futsal hari ini?
        </p>

    </div>

    <div class="px-4 space-y-5">

    {{-- Statistik --}}
    <div class="grid grid-cols-3 gap-3">

    <div class="bg-white rounded-xl p-3 text-center">
        <p class="text-xs text-gray-500">Booking</p>
        <p class="text-xl font-bold text-[#12B5A5]">
            {{ \App\Models\Booking::where('user_id', Auth::id())->count() }}
        </p>
    </div>

    <div class="bg-white rounded-xl p-3 text-center">
        <p class="text-xs text-gray-500">Aktif</p>
        <p class="text-xl font-bold text-green-600">
            {{ \App\Models\Booking::where('user_id', Auth::id())->whereIn('status',['pending','confirmed'])->count() }}
        </p>
    </div>

    <div class="bg-white rounded-xl p-3 text-center">
        <p class="text-xs text-gray-500">Selesai</p>
        <p class="text-xl font-bold text-blue-600">
            {{ \App\Models\Booking::where('user_id', Auth::id())->where('status','completed')->count() }}
        </p>
    </div>

</div>

        {{-- Informasi Lapangan --}}
        <div class="bg-white rounded-2xl shadow-sm p-4">

            <div class="flex gap-4">

<img
    src="{{ $nextBooking?->field?->photo_url ?? 'https://images.unsplash.com/photo-1517466787929-bc90951d0974?w=400' }}"
    alt="Lapangan Futsal"
    class="w-28 h-28 rounded-xl object-cover flex-shrink-0"
>

                <div class="flex-1">

                    <h2 class="font-semibold text-lg text-gray-800">
                        Lapangan Arung Futsal
                    </h2>

                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                        JL. IKIP C10A, Gunung Anyar,
                        Surabaya, Jawa Timur
                    </p>

                    <hr class="my-3">

                    <p class="text-xs text-gray-600 leading-relaxed">
                        Fasilitas:
                        Area parkir, air minum,
                        mushola, kamar mandi.
                    </p>

                    <a
                        href="{{ route('user.booking.index') }}"
                        class="inline-flex items-center gap-2 mt-4 px-4 py-2 rounded-full bg-[#12B5A5] text-white text-sm font-medium hover:bg-[#0fa293] transition"
                    >
                        Booking Sekarang
                        <span>→</span>
                    </a>

                </div>

            </div>

        </div>

        {{-- Booking Mendatang --}}
        <div>

            <div class="flex items-center justify-between mb-3">

                <h2 class="text-lg font-semibold text-gray-800">
                    Booking Mendatang
                </h2>

                <a
                    href="{{ route('user.booking.history') }}"
                    class="text-sm font-medium text-[#12B5A5]"
                >
                    Lihat Semua
                </a>

            </div>

            @if($nextBooking)

                <div class="bg-white rounded-2xl shadow-sm p-4">

                    <div class="flex items-start justify-between">

                        <div>

                            <h3 class="font-semibold text-gray-800">
                                {{ $nextBooking->field->name }}
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                {{ \Carbon\Carbon::parse($nextBooking->booking_date)->translatedFormat('d F Y') }}
                            </p>

                            <p class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($nextBooking->start_time)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($nextBooking->end_time)->format('H:i') }}
                            </p>

                        </div>

                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                            {{ $statusText }}
                        </span>

                    </div>

                    <div class="mt-4 pt-3 border-t">

                        <p class="text-xs text-gray-500">
                            Total Bayar
                        </p>

                        <p class="text-xl font-bold text-[#12B5A5]">
                            Rp {{ number_format($nextBooking->total_amount, 0, ',', '.') }}
                        </p>

                    </div>

                </div>

                            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">

    <p class="font-semibold text-yellow-800">
        ⏰ Jadwal Terdekat
    </p>

    <p class="text-sm text-yellow-700 mt-1">
        Main futsal pada
        {{ $nextBooking->booking_date->translatedFormat('d F Y') }}
        pukul
        {{ \Carbon\Carbon::parse($nextBooking->start_time)->format('H:i') }}
        WIB
    </p>

</div>

            @else

                <div class="bg-white rounded-2xl shadow-sm p-6 text-center">

                    <p class="text-gray-500">
                        Belum ada booking aktif.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection