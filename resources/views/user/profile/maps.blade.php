@extends('layouts.user')

@section('title', 'Maps Arung Futsal')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="bg-white rounded-[32px]
                border border-[#BEEAE5]
                shadow-sm overflow-hidden p-8">

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
            <h1 class="text-3xl font-bold text-[#12B5A5]">
                Maps Arung Futsal
            </h1>

            <p class="text-gray-500 mt-2">
                Informasi lokasi dan jam operasional Arung Futsal.
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-8">

            {{-- Gambar Maps --}}
            <div>

                <a href="https://maps.google.com/?q=Arung+Futsal+Surabaya"
                   target="_blank"
                   class="block rounded-[28px]
                          overflow-hidden border
                          border-[#D9F4F1]
                          hover:shadow-md transition">

                    <img
                        src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/World_map_blank_without_borders.svg/1920px-World_map_blank_without_borders.svg.png"
                        alt="Maps Arung Futsal"
                        class="w-full h-[350px] object-cover">

                </a>

                <p class="text-sm text-gray-400 mt-3 text-center">
                    Klik gambar untuk membuka Google Maps
                </p>

            </div>

            {{-- Informasi Tempat --}}
            <div class="bg-[#F8FFFD]
                        border border-[#D9F4F1]
                        rounded-[28px]
                        p-7">

                {{-- Nama Tempat --}}
                <div class="mb-5">

                    <p class="text-sm text-gray-400 mb-1">
                        Nama Tempat
                    </p>

                    <h2 class="text-2xl font-bold text-gray-800">
                        Arung Futsal
                    </h2>

                </div>

                {{-- Alamat --}}
                <div class="mb-5">

                    <p class="text-sm text-gray-400 mb-1">
                        Alamat Lengkap
                    </p>

                    <p class="text-gray-700 leading-relaxed">
                        Perumahan IKIP C10A,
                        Gunung Anyar,
                        Kecamatan Gunung Anyar,
                        Surabaya,
                        Jawa Timur 60294
                    </p>

                </div>

                {{-- Google Maps Link --}}
                <div class="mb-5">

                    <p class="text-sm text-gray-400 mb-1">
                        Link Google Maps
                    </p>

                    <a href="https://maps.google.com/?q=Arung+Futsal+Surabaya"
                       target="_blank"
                       class="text-[#12B5A5]
                              hover:underline break-all">

                        https://maps.google.com/?q=Arung+Futsal+Surabaya
                    </a>

                </div>

                {{-- Jam Operasional --}}
                <div class="bg-white border
                            border-[#D9F4F1]
                            rounded-2xl p-5">

                    <div class="flex items-center gap-3">

                        {{-- Icon Jam --}}
                        <div class="w-12 h-12 rounded-full
                                    bg-[#E8FAF5]
                                    flex items-center
                                    justify-center text-2xl">

                            🕒

                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-800">
                                Jam Operasional
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Senin - Minggu :
                                09.00 - 21.00 WIB
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection