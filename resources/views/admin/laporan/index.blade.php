@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('content')

<div class="space-y-6">

    {{-- FILTER --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        <h3 class="font-semibold text-gray-800 mb-4">
            Rentang Waktu
        </h3>

<form method="GET">

    <select
        name="period"
        onchange="this.form.submit()"
        class="w-full md:w-72 rounded-xl border-gray-300">

        <option value="today"
            {{ $period == 'today' ? 'selected' : '' }}>
            Hari Ini
        </option>

        <option value="yesterday"
            {{ $period == 'yesterday' ? 'selected' : '' }}>
            Kemarin
        </option>

        <option value="last_7_days"
            {{ $period == 'last_7_days' ? 'selected' : '' }}>
            7 Hari Terakhir
        </option>

        <option value="last_30_days"
            {{ $period == 'last_30_days' ? 'selected' : '' }}>
            30 Hari Terakhir
        </option>

        <option value="this_month"
            {{ $period == 'this_month' ? 'selected' : '' }}>
            Bulan Ini
        </option>

    </select>

</form>

    </div>

    {{-- KARTU --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <p class="text-sm text-gray-500">Total Booking</p>
            <h2 class="text-3xl font-bold mt-2">{{ $totalBooking }}</h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <p class="text-sm text-gray-500">Total Pendapatan</p>
            <h2 class="text-3xl font-bold mt-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <p class="text-sm text-gray-500">Slot Terisi</p>
            <h2 class="text-3xl font-bold mt-2">{{ $persentaseTerisi }}%</h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <p class="text-sm text-gray-500">Slot Tersedia</p>
            <h2 class="text-3xl font-bold mt-2">{{ $persentaseTersedia }}%</h2>
        </div>

    </div>

    {{-- PENDAPATAN --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        <h3 class="font-semibold text-gray-800 mb-4">
            Pendapatan per Lapangan
        </h3>

        <div class="h-48 flex items-center justify-center text-gray-400">
            @if($fieldRevenue->count())

    <div class="space-y-4">

        @foreach($fieldRevenue as $item)

            @php
                $percentage = $totalPendapatan > 0
                    ? round(($item->total / $totalPendapatan) * 100)
                    : 0;
            @endphp

            <div>

                <div class="flex justify-between mb-2">

                    <span class="font-medium text-gray-700">
                        {{ $item->field->name }}
                    </span>

                    <span class="text-sm text-gray-500">
                        Rp {{ number_format($item->total, 0, ',', '.') }}
                    </span>

                </div>

                <div class="w-full bg-gray-100 rounded-full h-3">

                    <div
                        class="bg-[#1ABC9C] h-3 rounded-full"
                        style="width: {{ $percentage }}%">

                    </div>

                </div>

            </div>

        @endforeach

    </div>

@else

    <div class="text-gray-400 text-center py-10">

        Belum ada data pendapatan.

    </div>

@endif
        </div>

    </div>

    {{-- BOOKING TERBARU --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        <div class="flex justify-between items-center mb-4">

            <h3 class="font-semibold text-gray-800">
                Booking Terbaru
            </h3>

            <button
                class="text-sm text-[#1ABC9C] font-medium">

                Lihat Semua

            </button>

        </div>

        <div class="text-gray-400 text-center py-10">

            @if($recentBookings->count())

    <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead>

                <tr class="border-b text-left text-gray-500">

                    <th class="py-3">Kode</th>
                    <th class="py-3">Pelanggan</th>
                    <th class="py-3">Lapangan</th>
                    <th class="py-3">Tanggal</th>
                    <th class="py-3">Status</th>

                </tr>

            </thead>

            <tbody>

                @foreach($recentBookings as $booking)

                    <tr class="border-b">

                        <td class="py-4 font-medium">
                            {{ $booking->reservation_code }}
                        </td>

                        <td class="py-4">
                            {{ $booking->user->name }}
                        </td>

                        <td class="py-4">
                            {{ $booking->field->name }}
                        </td>

                        <td class="py-4">
                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                        </td>

                        <td class="py-4">

                            @php
                                $badge = match($booking->status) {

                                    'confirmed' => 'bg-green-100 text-green-700',

                                    'completed' => 'bg-blue-100 text-blue-700',

                                    'pending',
                                    'waiting_confirmation'
                                        => 'bg-yellow-100 text-yellow-700',

                                    'cancelled'
                                        => 'bg-red-100 text-red-700',

                                    default
                                        => 'bg-gray-100 text-gray-700',
                                };
                            @endphp

                            <span class="px-2 py-1 rounded-full text-xs {{ $badge }}">

                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}

                            </span>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

@else

    <div class="text-gray-400 text-center py-10">

        Belum ada data booking.

    </div>

@endif

        </div>

    </div>

    {{-- EXPORT --}}
    <div class="flex justify-end gap-3">

        <button
            class="px-5 py-3 rounded-xl border border-red-200 text-red-600">

            Export PDF

        </button>

        <button
            class="px-5 py-3 rounded-xl border border-green-200 text-green-600">

            Export CSV

        </button>

    </div>

</div>

@endsection