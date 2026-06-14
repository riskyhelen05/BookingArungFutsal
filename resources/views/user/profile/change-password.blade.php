@extends('layouts.user')

@section('title', 'Ganti Password')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="bg-white rounded-[30px]
                border border-[#BEEAE5]
                shadow-sm p-8">

        {{-- Tombol Kembali --}}
        <div class="mb-6">
            <a href="{{ route('user.profile') }}"
               class="inline-flex items-center gap-2
                      text-[#12B5A5]
                      font-medium hover:text-[#0F8F87]
                      transition">

                <span class="text-xl">←</span>
                Kembali ke Profil
            </a>
        </div>

        {{-- Title --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-[#12B5A5]">
                Ganti Password
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Pastikan password baru mudah diingat tetapi aman.
            </p>
        </div>

        <form action="{{ route('user.profile.password.update') }}"
              method="POST">

            @csrf
            @method('PUT')

            {{-- Password Lama --}}
            <div class="mb-5">
                <label class="block mb-2 font-medium text-gray-700">
                    Password Lama
                </label>

                <input type="password"
                       name="old_password"
                       placeholder="Masukkan password lama"
                       class="w-full rounded-2xl
                              border border-[#BEEAE5]
                              px-4 py-3
                              focus:outline-none
                              focus:ring-2
                              focus:ring-[#12B5A5]">

                @error('old_password')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Password Baru --}}
            <div class="mb-5">
                <label class="block mb-2 font-medium text-gray-700">
                    Password Baru
                </label>

                <input type="password"
                       name="password"
                       placeholder="Masukkan password baru"
                       class="w-full rounded-2xl
                              border border-[#BEEAE5]
                              px-4 py-3
                              focus:outline-none
                              focus:ring-2
                              focus:ring-[#12B5A5]">

                @error('password')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-7">
                <label class="block mb-2 font-medium text-gray-700">
                    Konfirmasi Password Baru
                </label>

                <input type="password"
                       name="password_confirmation"
                       placeholder="Ulangi password baru"
                       class="w-full rounded-2xl
                              border border-[#BEEAE5]
                              px-4 py-3
                              focus:outline-none
                              focus:ring-2
                              focus:ring-[#12B5A5]">
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