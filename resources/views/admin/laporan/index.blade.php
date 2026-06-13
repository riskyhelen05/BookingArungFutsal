@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('content')

<div class="space-y-6">

    {{-- HEADER FILTER --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">

            <div class="flex-1">

                <h3 class="font-semibold text-[#1A1A2E] text-lg">
                    Rentang Waktu Laporan
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Pilih periode untuk melihat statistik booking.
                </p>

                <form method="GET" class="mt-5 space-y-4">

                    <select
                        name="period"
                        onchange="this.form.submit()"
                        class="w-full md:w-72 rounded-xl border-gray-300 focus:border-[#1ABC9C] focus:ring-[#1ABC9C]">

                        <option value="today" {{ $period == 'today' ? 'selected' : '' }}>
                            Hari Ini
                        </option>

                        <option value="yesterday" {{ $period == 'yesterday' ? 'selected' : '' }}>
                            Kemarin
                        </option>

                        <option value="last_7_days" {{ $period == 'last_7_days' ? 'selected' : '' }}>
                            7 Hari Terakhir
                        </option>

                        <option value="last_30_days" {{ $period == 'last_30_days' ? 'selected' : '' }}>
                            30 Hari Terakhir
                        </option>

                        <option value="this_month" {{ $period == 'this_month' ? 'selected' : '' }}>
                            Bulan Ini
                        </option>

                        <option value="custom" {{ $period == 'custom' ? 'selected' : '' }}>
                            Custom
                        </option>

                    </select>

                    @if($period == 'custom')

                        <div class="grid md:grid-cols-2 gap-4">

                            <div>
                                <label class="block text-sm text-gray-600 mb-2">
                                    Tanggal Mulai
                                </label>

                                <input
                                    type="date"
                                    name="start_date"
                                    value="{{ request('start_date') }}"
                                    class="w-full rounded-xl border-gray-300 focus:border-[#1ABC9C] focus:ring-[#1ABC9C]">
                            </div>

                            <div>
                                <label class="block text-sm text-gray-600 mb-2">
                                    Tanggal Selesai
                                </label>

                                <input
                                    type="date"
                                    name="end_date"
                                    value="{{ request('end_date') }}"
                                    class="w-full rounded-xl border-gray-300 focus:border-[#1ABC9C] focus:ring-[#1ABC9C]">
                            </div>

                        </div>

                        <button
                            type="submit"
                            class="px-5 py-2.5 rounded-xl bg-[#1ABC9C] text-white hover:bg-[#17a589] transition">

                            Terapkan Filter

                        </button>

                    @endif

                </form>

            </div>

            {{-- EXPORT --}}
            <div class="flex flex-col sm:flex-row gap-3">

                <a
                    href="{{ route('admin.laporan.export.pdf', [
                        'period' => $period,
                        'start_date' => request('start_date'),
                        'end_date' => request('end_date'),
                    ]) }}"
                    class="inline-flex justify-center items-center px-5 py-3 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 transition">

                    Export PDF

                </a>

                <a
                    href="{{ route('admin.laporan.export.csv', [
                        'period' => $period,
                        'start_date' => request('start_date'),
                        'end_date' => request('end_date'),
                    ]) }}"
                    class="inline-flex justify-center items-center px-5 py-3 rounded-xl border border-gray-300 hover:bg-gray-50 transition">

                    Export CSV

                </a>

                <a
                    href="{{ route('admin.laporan.export.excel', [
                        'period' => $period,
                        'start_date' => request('start_date'),
                        'end_date' => request('end_date'),
                    ]) }}"
                    class="inline-flex justify-center items-center px-5 py-3 rounded-xl border border-green-200 text-green-600 hover:bg-green-50 transition">

                    Export Excel

                </a>

            </div>

        </div>

    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5">

<div class="bg-white rounded-2xl shadow-sm border p-6">
    <p class="text-sm text-gray-500">
        Total Booking
    </p>

    <h2 class="text-3xl font-bold text-[#1A1A2E] mt-2">
        {{ $totalBooking }}
    </h2>

    <p class="text-xs text-gray-400 mt-2">
        Semua status booking.
    </p>
</div>

<div class="bg-white rounded-2xl shadow-sm border p-6">
    <p class="text-sm text-gray-500">
        Booking Berhasil
    </p>

    <h2 class="text-3xl font-bold text-green-600 mt-2">
        {{ $bookingBerhasil }}
    </h2>

    <p class="text-xs text-gray-400 mt-2">
        Status confirmed & completed.
    </p>
</div>

<div class="bg-white rounded-2xl shadow-sm border p-6">
    <p class="text-sm text-gray-500">
        Total Pendapatan
    </p>

    <h2 class="text-3xl font-bold text-[#1ABC9C] mt-2">
        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
    </h2>

    <p class="text-xs text-gray-400 mt-2">
        Dari booking yang berhasil.
    </p>
</div>

<div class="bg-white rounded-2xl shadow-sm border p-6">
    <p class="text-sm text-gray-500">
        Slot Terisi
    </p>

    <h2 class="text-3xl font-bold text-blue-600 mt-2">
        {{ $persentaseTerisi }}%
    </h2>

    <p class="text-xs text-gray-400 mt-2">
        Berdasarkan booking berhasil.
    </p>
</div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <p class="text-sm text-gray-500">
                Slot Tersedia
            </p>

            <h2 class="text-3xl font-bold text-orange-500 mt-2">
                {{ $persentaseTersedia }}%
            </h2>

            <p class="text-xs text-gray-400 mt-2">
    Berdasarkan slot yang belum terisi.
</p>
        </div>

    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-4">
            Pendapatan per Lapangan
        </h3>

        @if($fieldRevenue->count())

    <div class="h-80">
    <canvas id="fieldRevenueChart"></canvas>
</div>

@else

    <div class="text-center py-16 text-gray-400">
        Belum ada data pendapatan.
    </div>

@endif
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-4">
            Status Booking
        </h3>

        @if($statusData->count())

    <div class="h-80">
    <canvas id="statusChart"></canvas>
</div>

@else

    <div class="text-center py-16 text-gray-400">
        Belum ada data status booking.
    </div>

@endif
    </div>

</div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

    <h3 class="font-semibold text-[#1A1A2E] mb-5">
        Booking Terbaru
    </h3>

    @if($recentBookings->count())

        <div class="overflow-x-auto">

            <table class="w-full min-w-[700px] text-sm">

                <thead>

                    <tr class="border-b text-gray-500">

                        <th class="py-3 text-center">
                            Kode
                        </th>

                        <th class="py-3 text-left">
                            Pelanggan
                        </th>

                        <th class="py-3 text-center">
                            Lapangan
                        </th>

                        <th class="py-3 text-center">
                            Tanggal
                        </th>

                        <th class="py-3 text-center">
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($recentBookings as $booking)

                        @php
                            $badge = match($booking->status) {
                                'confirmed' => 'bg-green-100 text-green-700',
                                'completed' => 'bg-blue-100 text-blue-700',
                                'pending', 'waiting_confirmation'
                                    => 'bg-yellow-100 text-yellow-700',
                                'cancelled'
                                    => 'bg-red-100 text-red-700',
                                default
                                    => 'bg-gray-100 text-gray-700',
                            };
                        @endphp

                        <tr class="border-b hover:bg-gray-50">

                            <td class="py-4 text-center font-medium">
                                {{ $booking->reservation_code }}
                            </td>

                            <td class="py-4 text-center">
                                {{ $booking->user->name }}
                            </td>

                            <td class="py-4 text-center">
                                {{ $booking->field->name }}
                            </td>

                            <td class="py-4 text-center">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                            </td>

                            <td class="py-4 text-center">

                                <span class="inline-flex px-3 py-1 rounded-full text-xs {{ $badge }}">

                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}

                                </span>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="text-center py-12 text-gray-400">

            Belum ada data booking.

        </div>

    @endif

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    @if($fieldRevenue->count())
    new Chart(document.getElementById('fieldRevenueChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($fieldRevenue->pluck('field.name')->values()) !!},
            datasets: [{
                label: 'Pendapatan',
                data: {!! json_encode($fieldRevenue->pluck('total')->values()) !!},
                backgroundColor: '#1ABC9C'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
    @endif

    @if($statusData->count())
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($statusData->keys()->values()) !!},
            datasets: [{
                data: {!! json_encode($statusData->values()->values()) !!},
                backgroundColor: [
                    '#F59E0B',
                    '#10B981',
                    '#3B82F6',
                    '#EF4444',
                    '#6B7280'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
    @endif

});
</script>

@endpush