@extends('layouts.user')

@section('title', 'Edit Profile')

@section('content')

<div class="max-w-xl mx-auto">

    {{-- Header --}}
    <div class="mb-5">
        <h1 class="text-2xl font-bold text-[#0F8F87]">
            Edit Profile
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
              font-medium
              hover:text-[#0F8F87]
              transition">

        <span class="text-xl">←</span>
        Kembali ke Profil
    </a>
</div>

        <form action="{{ route('user.profile.update') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            {{-- FOTO --}}
            <div class="flex justify-center mb-8">

                <div class="text-center">

                    @if(auth()->user()->avatar_url)

                        <img src="{{ asset('storage/' . auth()->user()->avatar_url) }}"
                             class="w-28 h-28 rounded-full
                                    object-cover border-4
                                    border-[#12B5A5]
                                    mx-auto">

                    @else

                        <div class="w-28 h-28 rounded-full
                                    bg-[#D9F4F1]
                                    flex items-center justify-center
                                    text-5xl text-[#12B5A5]
                                    mx-auto">
                            👤
                        </div>

                    @endif

                    <input type="file"
                           name="avatar"
                           class="mt-4 block text-sm mx-auto">

                    <p class="text-xs text-gray-400 mt-2">
                        Tambah/Edit Foto
                    </p>

                </div>

            </div>

            {{-- Nama --}}
            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Nama Lengkap
                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name', auth()->user()->name) }}"
                       class="w-full rounded-2xl
                              border border-[#BEEAE5]
                              px-4 py-3
                              focus:outline-none
                              focus:ring-2
                              focus:ring-[#12B5A5]">
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Alamat Email
                </label>

                <input type="email"
                       name="email"
                       value="{{ old('email', auth()->user()->email) }}"
                       class="w-full rounded-2xl
                              border border-[#BEEAE5]
                              px-4 py-3
                              focus:outline-none
                              focus:ring-2
                              focus:ring-[#12B5A5]">
            </div>

            {{-- Nomor Telepon --}}
            <div class="mb-6">
                <label class="block mb-2 font-medium">
                    Nomor Telepon
                </label>

                <input type="text"
                       name="phone"
                       value="{{ old('phone', auth()->user()->phone) }}"
                       class="w-full rounded-2xl
                              border border-[#BEEAE5]
                              px-4 py-3
                              focus:outline-none
                              focus:ring-2
                              focus:ring-[#12B5A5]">
            </div>

            {{-- BUTTON --}}
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