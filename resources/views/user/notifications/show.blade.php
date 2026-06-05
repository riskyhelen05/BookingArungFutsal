@extends('layouts.user')

@section('title', 'Detail Notifikasi')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Detail Notifikasi
            </h1>

            <p class="text-sm text-gray-500">
                Informasi pemberitahuan sistem
            </p>
        </div>

        <a href="{{ url()->previous() }}"
           class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">

            ← Kembali
        </a>

    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-lg p-6">

        {{-- STATUS --}}
        <div class="flex items-center justify-between mb-5">

            <span class="px-3 py-1 rounded-full text-xs font-semibold
                {{ $notification->is_read
                    ? 'bg-green-100 text-green-700'
                    : 'bg-yellow-100 text-yellow-700' }}">

                {{ $notification->is_read ? 'Sudah Dibaca' : 'Belum Dibaca' }}

            </span>

            <span class="text-sm text-gray-400">
                {{ \Carbon\Carbon::parse($notification->created_at)->format('d M Y H:i') }}
            </span>

        </div>

        {{-- JUDUL --}}
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            {{ $notification->title }}
        </h2>

        {{-- PESAN --}}
        <div class="bg-gray-50 rounded-xl p-4">

            <p class="text-gray-700 leading-relaxed">
                {{ $notification->message }}
            </p>

        </div>

        {{-- TYPE --}}
        <div class="mt-6 border-t pt-4">

            <p class="text-sm text-gray-500">
                Jenis Notifikasi
            </p>

            <p class="font-semibold text-[#12B5A5]">
                {{ strtoupper(str_replace('_', ' ', $notification->type)) }}
            </p>

        </div>

    </div>

</div>

@endsection