
@extends('layouts.admin')

@section('title', 'Detail Lapangan')
@section('page-title', 'Detail Lapangan')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-2xl font-bold text-[#1A1A2E]">
                Detail Lapangan
            </h1>

            <p class="text-slate-500 mt-1">
                Informasi lengkap lapangan futsal
            </p>
        </div>

        <a href="{{ route('admin.lapangan.index') }}"
           class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 transition">
            Kembali
        </a>

    </div>

    {{-- Card --}}
    <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-slate-100">

        {{-- FOTO --}}
        <div class="relative">

            @if($field->photo_url)

                <img src="{{ asset('storage/' . $field->photo_url) }}"
                     class="w-full h-[350px] object-cover">

            @else

                <div class="w-full h-[350px] bg-slate-200 flex items-center justify-center text-slate-400">
                    Tidak ada foto
                </div>

            @endif

            {{-- STATUS --}}
            <div class="absolute top-5 right-5">

                @if($field->status == 'available')

                    <span class="px-4 py-2 rounded-full bg-green-100 text-green-700 text-sm font-medium">
                        Tersedia
                    </span>

                @elseif($field->status == 'maintenance')

                    <span class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 text-sm font-medium">
                        Maintenance
                    </span>

                @elseif($field->status == 'closed')

                    <span class="px-4 py-2 rounded-full bg-red-100 text-red-700 text-sm font-medium">
                        Ditutup
                    </span>

                @endif

            </div>

        </div>

        {{-- CONTENT --}}
        <div class="p-8 grid md:grid-cols-3 gap-8">

            {{-- LEFT --}}
            <div class="md:col-span-2">

                <h2 class="text-3xl font-bold text-[#1A1A2E] mb-3">
                    {{ $field->name }}
                </h2>

                <p class="text-slate-600 leading-relaxed">
                    {{ $field->description ?: 'Belum ada deskripsi lapangan.' }}
                </p>

            </div>

            {{-- RIGHT --}}
            <div>

                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200">

                    <p class="text-slate-500 text-sm mb-2">
                        Harga Booking
                    </p>

                    <h3 class="text-4xl font-bold text-[#0F9E82]">
                        Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}
                    </h3>

                    <p class="text-slate-500 mt-2 text-sm">
                        / jam
                    </p>

                </div>

                {{-- BUTTON --}}
                <div class="mt-5 space-y-3">

                    <a href="{{ route('admin.lapangan.edit', $field) }}"
                       class="w-full flex justify-center px-4 py-3 rounded-2xl
                              bg-[#0F9E82] hover:bg-[#0c876f]
                              text-white font-semibold transition">

                        Edit Lapangan

                    </a>

                    <form action="{{ route('admin.lapangan.destroy', $field) }}"
                          method="POST">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                onclick="return confirm('Hapus lapangan ini?')"
                                class="w-full px-4 py-3 rounded-2xl
                                       bg-red-500 hover:bg-red-600
                                       text-white font-semibold transition">

                            Hapus Lapangan

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

