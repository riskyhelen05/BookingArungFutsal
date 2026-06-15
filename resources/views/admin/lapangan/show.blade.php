@extends('layouts.app')

@section('title', 'Detail Lapangan')
@section('page-title', 'Detail Lapangan')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">

        <div>
            <h2 class="text-2xl font-bold text-[#1A1A2E]">
                Detail Lapangan
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Informasi lengkap lapangan futsal
            </p>
        </div>

        <a href="{{ route('admin.lapangan.index') }}"
           class="px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200
                  text-sm font-semibold transition">

            Kembali

        </a>

    </div>

    {{-- Card --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

        {{-- Image --}}
        <div class="relative">

            @if($field->photo_url)

                <img
                    src="{{ asset('storage/'.$field->photo_url) }}"
                    class="w-full h-[320px] object-cover">

            @else

                <div class="w-full h-[320px] bg-slate-100 flex items-center justify-center">
                    <span class="text-slate-400">
                        Tidak ada foto
                    </span>
                </div>

            @endif

            {{-- status --}}
            <div class="absolute top-5 right-5">

                @if($field->status == 'available')

                    <span class="px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-700">
                        Tersedia
                    </span>

                @elseif($field->status == 'maintenance')

                    <span class="px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-700">
                        Maintenance
                    </span>

                @else

                    <span class="px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-700">
                        Ditutup
                    </span>

                @endif

            </div>

        </div>

        {{-- Content --}}
        <div class="p-8">

            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">

                {{-- Left --}}
                <div class="flex-1">

                    <h3 class="text-3xl font-bold text-[#1A1A2E]">
                        {{ $field->name }}
                    </h3>

                    <p class="text-slate-500 mt-3 leading-relaxed">
                        {{ $field->description ?? 'Tidak ada deskripsi.' }}
                    </p>

                </div>

                {{-- Right --}}
                <div class="lg:w-72">

                    <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100">

                        <p class="text-sm text-slate-500">
                            Harga Booking
                        </p>

                        <h4 class="text-3xl font-bold text-[#0F9E82] mt-2">
                            Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}
                        </h4>

                        <p class="text-sm text-slate-500 mt-1">
                            per jam
                        </p>

                        <div class="mt-6 pt-6 border-t border-slate-200 space-y-4">

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-slate-500">
                                    ID Lapangan
                                </span>

                                <span class="text-sm font-semibold text-[#1A1A2E]">
                                    {{ substr($field->id, 0, 8) }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-slate-500">
                                    Status
                                </span>

                                <span class="text-sm font-semibold text-[#1A1A2E] capitalize">
                                    {{ $field->status }}
                                </span>
                            </div>

                        </div>

                    </div>

                    {{-- Button --}}
                    <div class="mt-5 flex gap-3">

                        <a href="{{ route('admin.lapangan.edit', $field->id) }}"
                           class="flex-1 px-5 py-3 rounded-2xl bg-[#0F9E82]
                                  hover:bg-[#0c876f]
                                  text-white text-center text-sm font-semibold transition">

                            Edit

                        </a>

                        <form action="{{ route('admin.lapangan.destroy', $field->id) }}"
                              method="POST"
                              class="flex-1">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Hapus lapangan ini?')"
                                class="w-full px-5 py-3 rounded-2xl bg-red-500
                                       hover:bg-red-600
                                       text-white text-sm font-semibold transition">

                                Hapus

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

