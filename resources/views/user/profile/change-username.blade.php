@extends('layouts.user')

@section('title', 'Ganti Username')

@section('content')

<div class="max-w-xl mx-auto">

    {{-- Header --}}
    <div class="mb-5">
        <h1 class="text-2xl font-bold text-[#0F8F87]">
            Ganti Username
        </h1>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-[30px]
                border border-[#BEEAE5]
                shadow-sm p-6">

        {{-- Tombol Kembali --}}
        <div class="mb-5">
            <a href="{{ route('user.profile') }}"
               class="inline-flex items-center gap-2
                      text-[#12B5A5]
                      font-medium hover:text-[#0F8F87]
                      transition">

                <span class="text-xl">←</span>
                Kembali ke Profil
            </a>
        </div>

        <form action="{{ route('user.profile.username.update') }}"
              method="POST">

            @csrf
            @method('PUT')

            {{-- Username Lama --}}
            <div class="mb-4">

                <label class="block mb-2 font-medium">
                    Username Saat Ini
                </label>

                <input type="text"
                       value="{{ auth()->user()->username }}"
                       disabled
                       class="w-full rounded-2xl
                              bg-gray-100
                              border border-gray-200
                              px-4 py-3 text-gray-500">
            </div>

            {{-- Username Baru --}}
            <div class="mb-6">

                <label class="block mb-2 font-medium">
                    Username Baru
                </label>

                <input type="text"
                       name="username"
                       value="{{ old('username') }}"
                       placeholder="Masukkan username baru"
                       class="w-full rounded-2xl
                              border border-[#BEEAE5]
                              px-4 py-3
                              focus:outline-none
                              focus:ring-2
                              focus:ring-[#12B5A5]">

                @error('username')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Button --}}
            <button type="submit"
                    class="w-full bg-[#12B5A5]
                           hover:bg-[#0F8F87]
                           text-white font-semibold
                           py-4 rounded-2xl transition">

                Simpan Perubahan
            </button>

        </form>

    </div>

</div>

@endsection