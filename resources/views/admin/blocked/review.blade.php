@extends('layouts.admin')

@section('title','Review Blokir')
@section('page-title','Review Blokir')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

        {{-- HEADER --}}
        <div class="px-6 py-5 border-b border-gray-100">

            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">

    <div>

        <h2 class="text-xl font-bold text-slate-800">
            Review Blokir Jadwal
        </h2>

        <p class="text-sm text-slate-500 mt-1">
            Periksa kembali data sebelum menyimpan blokir jadwal.
        </p>

    </div>

    @if($status === 'maintenance')

        <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-yellow-100 text-yellow-700 text-sm font-semibold">
            🛠 Maintenance
        </span>

    @else

        <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-red-100 text-red-700 text-sm font-semibold">
            🔒 Tutup
        </span>

    @endif

</div>

        </div>

        <div class="p-6">

            {{-- INFORMASI --}}
            <div class="grid md:grid-cols-3 gap-4">

                <div class="border rounded-xl p-4">

                    <div class="text-xs uppercase text-gray-500 mb-1">
                        Lapangan
                    </div>

                    <div class="font-semibold text-slate-800">
                        {{ $field->name }}
                    </div>

                </div>

                <div class="border rounded-xl p-4">

                    <div class="text-xs uppercase text-gray-500 mb-1">
                        Tanggal
                    </div>

                    <div class="font-semibold text-slate-800">
                        {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
                    </div>

                </div>

                <div class="border rounded-xl p-4">

                    <div class="text-xs uppercase text-gray-500 mb-1">
                        Total Slot
                    </div>

                    <div class="font-semibold text-slate-800">
                        {{ count($slots) }} Slot
                    </div>

                </div>

            </div>

            {{-- SLOT --}}
            <div class="mt-6">

                <div class="flex items-center justify-between mb-3">

                    <h3 class="font-semibold text-slate-800">
                        Slot yang Akan Diblokir
                    </h3>

                    <span class="text-sm text-gray-500">
                        {{ count($slots) }} Slot Dipilih
                    </span>

                </div>

                @if(count($slots))

                    <div class="flex flex-wrap gap-2">

                        @foreach($slots as $slot)

                            <span class="px-4 py-2 rounded-lg bg-cyan-50 border border-cyan-100 text-cyan-700 text-sm font-medium">
                                {{ $slot }}
                            </span>

                        @endforeach

                    </div>

                @else

                    <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-red-600">
                        Tidak ada slot dipilih.
                    </div>

                @endif

            </div>

            {{-- CATATAN --}}
            <div class="mt-6">

                <h3 class="font-semibold text-slate-800 mb-3">
                    Catatan
                </h3>

                <div class="border rounded-xl p-4 bg-gray-50 text-slate-700">

                    {{ $notes ?: 'Tidak ada catatan tambahan.' }}

                </div>

            </div>

            {{-- ALERT --}}
            <div class="mt-6">

                <div class="flex gap-3 p-4 rounded-xl border border-amber-200 bg-amber-50">

                    <div class="text-lg">
                        ⚠️
                    </div>

                    <div>

                        <div class="font-semibold text-amber-700">
                            Perhatian
                        </div>

                        <div class="text-sm text-amber-600 mt-1">
                            Slot yang diblokir tidak dapat dipesan pengguna sampai blokir dihapus oleh admin.
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- FOOTER --}}
        <div class="border-t border-gray-100 bg-gray-50 px-6 py-4">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div class="text-sm text-gray-600">

                    Akan memblokir

                    <span class="font-semibold">
                        {{ count($slots) }}
                    </span>

                    slot pada

                    <span class="font-semibold">
                        {{ $field->name }}
                    </span>

                </div>

                <div class="flex flex-col sm:flex-row gap-3 ml-auto">

    <a
        href="{{ route('admin.jadwal') }}"
        class="px-5 py-2.5 border border-gray-300 rounded-lg text-center hover:bg-gray-100 transition">

        Kembali

    </a>

    <form
        action="{{ route('admin.blocked.confirm') }}"
        method="POST">

        @csrf

        <input type="hidden" name="field_id" value="{{ $field->id }}">
        <input type="hidden" name="block_date" value="{{ $date }}">
        <input type="hidden" name="status" value="{{ $status }}">
        <input type="hidden" name="notes" value="{{ $notes }}">

        @foreach($slots as $slot)
            <input type="hidden" name="slots[]" value="{{ $slot }}">
        @endforeach

        <button
            type="submit"
            class="px-6 py-2.5 bg-[#1ABC9C] hover:bg-[#0F9E82] text-white rounded-lg font-semibold transition">

            Konfirmasi Blokir

        </button>

    </form>

</div>

            </div>

        </div>

    </div>

</div>

@endsection