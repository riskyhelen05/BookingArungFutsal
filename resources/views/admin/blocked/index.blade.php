@extends('layouts.admin')

@section('title', 'Kelola Jadwal')
@section('page-title', 'Kelola Jadwal')

@section('content')

<div class="space-y-6">

    {{-- FILTER --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">

        <form
            method="GET"
            action="{{ route('admin.jadwal') }}"
            class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-medium mb-2">
                    Tanggal
                </label>

                <input
                    type="date"
                    name="block_date"
                    value="{{ $selectedDate }}"
                    onchange="this.form.submit()"
                    class="w-full rounded-xl border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">
                    Lapangan
                </label>

                <select
                    name="field_id"
                    onchange="this.form.submit()"
                    class="w-full rounded-xl border-gray-300">

                    @foreach($fields as $field)

                        <option
                            value="{{ $field->id }}"
                            {{ $selectedField == $field->id ? 'selected' : '' }}>

                            {{ $field->name }}

                        </option>

                    @endforeach

                </select>

            </div>

        </form>

    </div> {{-- TUTUP FILTER --}}

    {{-- FORM BLOKIR --}}
    <form
        action="{{ route('admin.blocked.review') }}"
        method="POST">

        @csrf

        <input
            type="hidden"
            name="field_id"
            value="{{ $selectedField }}">

        <input
            type="hidden"
            name="block_date"
            value="{{ $selectedDate }}">

    {{-- SLOT --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm">

                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm">

                    {{-- HEADER --}}
                    <div class="border-b border-gray-100 p-6">

                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

                            <div>

                                <h3 class="font-bold text-lg text-gray-800">
                                    Pilih Slot Jadwal
                                </h3>

                                <p class="text-sm text-gray-500">
                                    Hanya slot dengan status tersedia yang dapat diblokir.
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- LEGEND --}}
                    <div class="px-6 pt-5">

                        <div class="flex flex-wrap gap-2 text-sm">

                            <span class="px-3 py-1 rounded-full bg-cyan-100 text-cyan-700">
                                Tersedia
                            </span>

                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700">
                                Dikonfirmasi
                            </span>

                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700">
                                Pending
                            </span>

                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700">
                                Maintenance
                            </span>

                            <span class="px-3 py-1 rounded-full bg-gray-200 text-gray-700">
                                Tutup
                            </span>

                        </div>

                    </div>
{{-- CONTENT --}}
<div class="p-6">

@php

    $availableCount = collect($slots)
        ->where('status', 'available')
        ->count();

    $confirmedCount = collect($slots)
        ->where('status', 'confirmed')
        ->count();

    $pendingCount = collect($slots)
        ->where('status', 'pending')
        ->count();

    $maintenanceCount = collect($slots)
        ->where('status', 'maintenance')
        ->count();

    $closedCount = collect($slots)
        ->where('status', 'closed')
        ->count();

@endphp

    {{-- SLOT GRID --}}
<div class="grid
            grid-cols-2
            md:grid-cols-3
            lg:grid-cols-4
            xl:grid-cols-6
            gap-3">

        @foreach($slots as $slot)

            @php

$status = match($slot['status']) {

    'confirmed' => [
        'label' => 'Dikonfirmasi',
        'badge' => 'bg-green-100 text-green-700 border-green-200'
    ],

    'pending' => [
        'label' => 'Pending',
        'badge' => 'bg-yellow-100 text-yellow-700 border-yellow-200'
    ],

    'maintenance' => [
        'label' => 'Maintenance',
        'badge' => 'bg-red-100 text-red-700 border-red-200'
    ],

    'closed' => [
        'label' => 'Tutup',
        'badge' => 'bg-gray-200 text-gray-700 border-gray-300'
    ],

    default => [
        'label' => 'Tersedia',
        'badge' => 'bg-cyan-100 text-cyan-700 border-cyan-200'
    ]
};

            @endphp

            <label
    class="relative border rounded-2xl p-4 transition-all duration-200

    {{ $slot['status'] === 'available'
        ? 'bg-white hover:border-[#1ABC9C] hover:shadow-md cursor-pointer'
        : 'bg-gray-50 opacity-75 cursor-not-allowed' }}">

    <input
        type="checkbox"
        name="slots[]"
        value="{{ $slot['start'] }} - {{ $slot['end'] }}"
        class="absolute top-3 right-3 w-4 h-4"
        {{ $slot['status'] !== 'available' ? 'disabled' : '' }}>

    <div class="text-center">

        <h4 class="text-xl font-bold text-gray-800">
            {{ $slot['start'] }}
        </h4>

        <p class="text-xs text-gray-500">
            {{ $slot['end'] }}
        </p>

        <span
            class="mt-2 inline-flex px-2 py-1 rounded-full text-[11px] font-medium {{ $status['badge'] }}">

            {{ $status['label'] }}

        </span>

    </div>

</label>

        @endforeach

    </div>

</div>

                </div>

            </div>

        </div>

        {{-- STATUS BLOKIR --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 mt-6">

            <h3 class="font-bold text-lg text-gray-800 mb-1">
                Status Blokir
            </h3>

            <p class="text-sm text-gray-500 mb-5">
                Tentukan alasan atau jenis pemblokiran jadwal.
            </p>

            <div class="grid md:grid-cols-2 gap-4">

                <label class="border rounded-2xl p-5 hover:border-teal-400 cursor-pointer">

                    <div class="flex items-start gap-3">

                        <input
                            type="radio"
                            name="status"
                            value="maintenance"
                            checked
                            class="mt-1">

                        <div>

                            <div class="font-semibold text-gray-800">
                                Maintenance
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                Digunakan ketika lapangan sedang dalam perawatan.
                            </div>

                        </div>

                    </div>

                </label>

                <label class="border rounded-2xl p-5 hover:border-red-400 cursor-pointer">

                    <div class="flex items-start gap-3">

                        <input
                            type="radio"
                            name="status"
                            value="closed"
                            class="mt-1">

                        <div>

                            <div class="font-semibold text-gray-800">
                                Tutup
                            </div>

                            <div class="text-sm text-gray-500 mt-1">
                                Digunakan ketika lapangan tidak dapat digunakan sementara.
                            </div>

                        </div>

                    </div>

                </label>

            </div>

            {{-- NOTES --}}
<div class="mt-6">

    <div class="flex items-center justify-between mb-2">

        <label class="font-medium text-gray-700">
            Catatan
        </label>

        <span class="text-xs text-gray-400">
            Opsional
        </span>

    </div>

    <textarea
        name="notes"
        rows="3"
        placeholder="Contoh: Maintenance rumput sintetis, perbaikan lampu lapangan, atau kegiatan internal..."
        class="w-full rounded-xl border-gray-300
               focus:border-[#1ABC9C]
               focus:ring-[#1ABC9C]
               text-sm"></textarea>

</div>

        </div>

        {{-- ACTION --}}
        <div class="flex justify-end mt-6">

            <button
                type="submit"
                class="bg-[#1ABC9C]
                       hover:bg-[#0F9E82]
                       text-white
                       font-semibold
                       px-8 py-3
                       rounded-2xl
                       shadow-md
                       transition">

                Review & Konfirmasi

            </button>

        </div>

        </form>

</div>
@endsection