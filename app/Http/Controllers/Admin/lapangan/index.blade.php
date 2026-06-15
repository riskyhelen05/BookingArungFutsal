@php
use Illuminate\Support\Str;
@endphp


@extends('layouts.app')

@section('title', 'Kelola Lapangan')
@section('page-title', 'Kelola Lapangan')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h2 class="text-2xl font-bold text-[#1A1A2E]">
                Lapangan Futsal
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Kelola data lapangan, status, dan harga booking
            </p>
        </div>

        <a href="{{ route('admin.lapangan.create') }}"
            class="bg-[#0F9E82] hover:bg-[#0c876f]
                   text-white px-5 py-3 rounded-2xl
                   text-sm font-semibold transition">

            + Tambah Lapangan

        </a>

    </div>

    {{-- Summary --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- tersedia --}}
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500">
                Lapangan Tersedia
            </p>

            <div class="mt-3 flex items-center justify-between">
                <h3 class="text-3xl font-bold text-[#1A1A2E]">
                    {{ $available }}
                </h3>

                <div class="w-12 h-12 rounded-2xl bg-green-100 flex items-center justify-center">
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                </div>
            </div>
        </div>

        {{-- maintenance --}}
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500">
                Maintenance
            </p>

            <div class="mt-3 flex items-center justify-between">
                <h3 class="text-3xl font-bold text-[#1A1A2E]">
                    {{ $maintenance }}
                </h3>

                <div class="w-12 h-12 rounded-2xl bg-yellow-100 flex items-center justify-center">
                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                </div>
            </div>
        </div>

        {{-- tutup --}}
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500">
                Ditutup
            </p>

            <div class="mt-3 flex items-center justify-between">
                <h3 class="text-3xl font-bold text-[#1A1A2E]">
                    {{ $closed }}
                </h3>

                <div class="w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                </div>
            </div>
        </div>

    </div>

    {{-- Table --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">
                            Lapangan
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">
                            Harga
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-sm font-semibold text-slate-600">
                            Aksi
                        </th>

                    </tr>
                </thead>

                <tbody>

                    @forelse($fields as $field)

                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition">

                        {{-- foto + nama --}}
                        <td class="px-6 py-4">

                            <div class="flex items-center gap-4">

                                @if($field->photo_url)

                                <img
                                    src="{{ asset('storage/'.$field->photo_url) }}"
                                    class="w-16 h-16 rounded-2xl object-cover">

                                @else

                                <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center">
                                    <span class="text-slate-400 text-xs">
                                        No Image
                                    </span>
                                </div>

                                @endif

                                <div>
                                    <h4 class="font-semibold text-[#1A1A2E]">
                                        {{ $field->name }}
                                    </h4>

                                    <p class="text-sm text-slate-500 mt-1">
                                        {{ Str::limit($field->description, 40) }}
                                    </p>
                                </div>

                            </div>

                        </td>

                        {{-- harga --}}
                        <td class="px-6 py-4">

                            <p class="font-semibold text-[#1A1A2E]">
                                Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}
                            </p>

                            <span class="text-sm text-slate-500">
                                / jam
                            </span>

                        </td>

                        {{-- status --}}
                        <td class="px-6 py-4">

                            @if($field->status == 'available')

                                <span class="px-4 py-2 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    Tersedia
                                </span>

                            @elseif($field->status == 'maintenance')

                                <span class="px-4 py-2 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                    Maintenance
                                </span>

                            @else

                                <span class="px-4 py-2 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    Ditutup
                                </span>

                            @endif

                        </td>

                        {{-- aksi --}}
                        <td class="px-6 py-4">

                            <div class="flex items-center justify-end gap-2">

                                <a href="{{ route('admin.lapangan.show', $field->id) }}"
                                    class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-sm font-medium transition">

                                    Detail

                                </a>

                                <a href="{{ route('admin.lapangan.edit', $field->id) }}"
                                    class="px-4 py-2 rounded-xl bg-[#0F9E82] hover:bg-[#0c876f] text-white text-sm font-medium transition">

                                    Edit

                                </a>

                                <form action="{{ route('admin.lapangan.destroy', $field->id) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Hapus lapangan ini?')"
                                        class="px-4 py-2 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-medium transition">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                            Belum ada data lapangan
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

