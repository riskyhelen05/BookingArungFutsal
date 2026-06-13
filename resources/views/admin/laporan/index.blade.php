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

        <select class="w-full md:w-72 rounded-xl border-gray-300">
            <option>Hari Ini</option>
            <option>Kemarin</option>
            <option>7 Hari Terakhir</option>
            <option>30 Hari Terakhir</option>
            <option>Bulan Ini</option>
        </select>

    </div>

    {{-- KARTU --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <p class="text-sm text-gray-500">Total Booking</p>
            <h2 class="text-3xl font-bold mt-2">0</h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <p class="text-sm text-gray-500">Total Pendapatan</p>
            <h2 class="text-3xl font-bold mt-2">Rp 0</h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <p class="text-sm text-gray-500">Slot Terisi</p>
            <h2 class="text-3xl font-bold mt-2">0%</h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <p class="text-sm text-gray-500">Slot Tersedia</p>
            <h2 class="text-3xl font-bold mt-2">0%</h2>
        </div>

    </div>

    {{-- PENDAPATAN --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        <h3 class="font-semibold text-gray-800 mb-4">
            Pendapatan per Lapangan
        </h3>

        <div class="h-48 flex items-center justify-center text-gray-400">
            Chart akan ditampilkan di sini
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

            Belum ada data booking.

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