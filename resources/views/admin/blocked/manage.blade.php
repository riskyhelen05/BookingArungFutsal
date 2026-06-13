@extends('layouts.admin')

@section('title','Blokir Jadwal')
@section('page-title','Blokir Jadwal')

@section('content')

<div class="space-y-6">

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div class="bg-white rounded-2xl border p-5 shadow-sm">
            <p class="text-sm text-gray-500">
                Total Blokir
            </p>

            <p class="text-3xl font-bold mt-2">
                {{ $totalBlocked }}
            </p>
        </div>

        <div class="bg-white rounded-2xl border p-5 shadow-sm">
            <p class="text-sm text-gray-500">
                Maintenance
            </p>

            <p class="text-3xl font-bold text-yellow-600 mt-2">
                {{ $maintenanceCount }}
            </p>
        </div>

        <div class="bg-white rounded-2xl border p-5 shadow-sm">
            <p class="text-sm text-gray-500">
                Tutup
            </p>

            <p class="text-3xl font-bold text-red-600 mt-2">
                {{ $closedCount }}
            </p>
        </div>

    </div>

    {{-- FILTER --}}
    <div class="bg-white rounded-2xl border shadow-sm p-5">

<form method="GET"
      action="{{ route('admin.blocked.manage') }}"
      class="grid md:grid-cols-3 gap-4">

    <div>
        <label class="block text-sm font-medium mb-2">
            Tanggal
        </label>

        <input
            type="date"
            name="date"
            value="{{ request('date') }}"
            class="w-full rounded-xl border-gray-300">
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">
            Lapangan
        </label>

        <select
            name="field"
            class="w-full rounded-xl border-gray-300">

            <option value="">
                Semua Lapangan
            </option>

            @foreach($fields as $field)

                <option
                    value="{{ $field->id }}"
                    {{ request('field') == $field->id ? 'selected' : '' }}>

                    {{ $field->name }}

                </option>

            @endforeach

        </select>
    </div>

    <div class="flex items-end">
        <button
            type="submit"
            class="w-full bg-[#1ABC9C] text-white py-3 rounded-xl">

            Terapkan Filter

        </button>
    </div>

</form>

    </div>
{{-- TABLE --}}
<div class="overflow-x-auto">

    <table class="w-full">

        <thead class="bg-slate-50 border-b border-gray-100">

            <tr class="text-xs font-semibold uppercase tracking-wider text-slate-500">

                <th class="px-6 py-4 text-center">
                    Lapangan
                </th>

                <th class="px-6 py-4 text-center">
                    Tanggal
                </th>

                <th class="px-6 py-4 text-center">
                    Jam
                </th>

                <th class="px-6 py-4 text-center">
                    Status
                </th>

                <th class="px-6 py-4 text-center">
                    Dibuat Oleh
                </th>

                <th class="px-6 py-4 text-center">
                    Aksi
                </th>

            </tr>

        </thead>

        <tbody class="divide-y divide-gray-100">

            @forelse($blockedSlots as $slot)

                <tr class="hover:bg-slate-50 transition">

                    {{-- Lapangan --}}
                    <td class="px-6 py-5 text-center align-middle">

                        <div class="font-medium text-slate-800">

                            {{ $slot->field->name }}

                        </div>

                    </td>

                    {{-- Tanggal --}}
                    <td class="px-6 py-5 text-center align-middle text-slate-600">

                        {{ \Carbon\Carbon::parse($slot->block_date)->translatedFormat('d M Y') }}

                    </td>

                    {{-- Jam --}}
                    <td class="px-6 py-5 text-center align-middle">

                        <span class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1 rounded-lg bg-slate-100 text-slate-700 text-sm font-medium">

                            {{ substr($slot->start_time,0,5) }}
                            -
                            {{ substr($slot->end_time,0,5) }}

                        </span>

                    </td>

                    {{-- Status --}}
                    <td class="px-6 py-5 text-center align-middle">

                        @if($slot->status === 'maintenance')

                            <span class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">

                                🛠 Maintenance

                            </span>

                        @else

                            <span class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">

                                🔒 Tutup

                            </span>

                        @endif

                    </td>

                    {{-- Admin --}}
                    <td class="px-6 py-5 text-center align-middle">

                        <span class="text-slate-700 font-medium">

                            {{ $slot->creator->name ?? '-' }}

                        </span>

                    </td>

                    {{-- Aksi --}}
                    <td class="px-6 py-5 text-center align-middle">

                        <button
                            type="button"
                            onclick="openDeleteModal(
                                '{{ route('admin.blocked.delete', $slot->id) }}',
                                '{{ $slot->field->name }}',
                                '{{ \Carbon\Carbon::parse($slot->block_date)->translatedFormat('d F Y') }}',
                                '{{ substr($slot->start_time,0,5) }} - {{ substr($slot->end_time,0,5) }}'
                            )"
                            class="inline-flex items-center justify-center min-w-[120px] px-4 py-2.5 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 font-medium transition">

                            Batalkan

                        </button>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="px-6 py-16 text-center">

                        <div class="max-w-sm mx-auto">

                            <div class="text-5xl mb-4">
                                📅
                            </div>

                            <h4 class="font-semibold text-slate-800">

                                Tidak ada data blokir

                            </h4>

                            <p class="text-sm text-slate-500 mt-2">

                                Belum ada jadwal yang diblokir sesuai filter yang dipilih.

                            </p>

                        </div>

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

    {{-- PAGINATION --}}
    @if($blockedSlots->hasPages())

        <div class="px-6 py-5 border-t border-gray-100 bg-slate-50">

            {{ $blockedSlots->links() }}

        </div>

    @endif

</div>
{{-- DELETE MODAL --}}
<div
    id="deleteModal"
    class="fixed inset-0 z-50 hidden">

    <div
        class="absolute inset-0 bg-black/50"
        onclick="closeDeleteModal()">
    </div>

    <div class="flex items-center justify-center min-h-screen p-4">

        <div class="bg-white rounded-3xl shadow-xl w-full max-w-md relative">

            <div class="p-6">

                <div class="w-14 h-14 mx-auto rounded-full bg-red-100 flex items-center justify-center">

                    <svg class="w-7 h-7 text-red-600"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>

                    </svg>

                </div>

                <h3 class="text-xl font-bold text-center mt-5">
                    Batalkan Blokir?
                </h3>

                <p class="text-center text-gray-500 mt-2">
                    Slot akan kembali tersedia untuk dipesan pengguna.
                </p>

                <div class="mt-6 bg-gray-50 rounded-2xl p-4 space-y-3">

                    <div class="flex justify-between">
                        <span class="text-gray-500">Lapangan</span>

                        <span id="modalField"
                              class="font-medium">
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">Tanggal</span>

                        <span id="modalDate"
                              class="font-medium">
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">Jam</span>

                        <span id="modalTime"
                              class="font-medium">
                        </span>
                    </div>

                </div>

                <form id="deleteForm"
                      method="POST"
                      class="mt-8">

                    @csrf
                    @method('DELETE')

                    <div class="flex gap-3">

                        <button type="button"
                                onclick="closeDeleteModal()"
                                class="flex-1 py-3 border border-gray-300 rounded-xl hover:bg-gray-100">

                            Batal

                        </button>

                        <button type="submit"
                                class="flex-1 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-semibold">

                            Ya, Batalkan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>
@push('scripts')

<script>

function openDeleteModal(url, field, date, time)
{
    document.getElementById('deleteForm').action = url;

    document.getElementById('modalField').innerText = field;
    document.getElementById('modalDate').innerText = date;
    document.getElementById('modalTime').innerText = time;

    document.getElementById('deleteModal')
        .classList.remove('hidden');
}

function closeDeleteModal()
{
    document.getElementById('deleteModal')
        .classList.add('hidden');
}

</script>

@endpush
@endsection