@extends('layouts.user')

@section('title', 'Detail Notifikasi')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-6">

        <h1 class="text-2xl font-bold text-gray-800">
            Detail Notifikasi
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Informasi dan riwayat pemberitahuan sistem.
        </p>

    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

        {{-- TOP BAR --}}
        <div class="bg-[#12B5A5] text-white px-6 py-4 flex justify-between items-center">

            <div>
                <p class="text-sm opacity-90">
                    Status Notifikasi
                </p>

                <p class="font-semibold">
                    {{ $notification->is_read ? 'Sudah Dibaca' : 'Belum Dibaca' }}
                </p>
            </div>

            <span class="text-sm opacity-90">
                {{ \Carbon\Carbon::parse($notification->created_at)->format('d M Y H:i') }}
            </span>

        </div>

        {{-- CONTENT --}}
        <div class="p-6">

            {{-- JUDUL --}}
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                {{ $notification->title }}
            </h2>

            {{-- PESAN --}}
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">

                <p class="text-gray-700 leading-relaxed">
                    {{ $notification->message }}
                </p>

            </div>

            {{-- INFORMASI --}}
            <div class="mt-6 border-t pt-5">

                <div class="flex justify-between items-center">

                    <div>
                        <p class="text-sm text-gray-500">
                            Jenis Notifikasi
                        </p>

                        <p class="font-semibold text-[#12B5A5] mt-1">
                            {{ strtoupper(str_replace('_', ' ', $notification->type)) }}
                        </p>
                    </div>

                    <div>
                        @if($notification->is_read)

                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                                ✓ Dibaca
                            </span>

                        @else

                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm">
                                ⏳ Belum Dibaca
                            </span>

                        @endif
                    </div>

                </div>

            </div>

            {{-- BUTTON --}}
            <div class="mt-8">

                <a
                    href="{{ route('user.booking.history') }}"
                    class="block text-center border border-gray-300 py-3 rounded-xl font-medium hover:bg-gray-50 transition">
                    ← Kembali ke Riwayat
                </a>

            </div>

        </div>

    </div>

</div>

@endsection