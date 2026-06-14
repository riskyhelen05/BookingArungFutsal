@extends('layouts.user')

@section('title', 'Dukungan & Bantuan')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="mb-5">
        <h1 class="text-2xl font-bold text-[#0F8F87]">
            Dukungan & Bantuan
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

        {{-- Informasi Bantuan --}}
        <div class="space-y-6">

            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-2">
                    Hubungi Kami
                </h2>

                <p class="text-gray-600">
                    Jika Anda mengalami kendala saat menggunakan sistem
                    Booking Arung Futsal, silakan hubungi admin melalui
                    kontak berikut.
                </p>
            </div>

            {{-- WhatsApp --}}
            <div class="p-4 rounded-2xl bg-[#F4FBFA] border border-[#BEEAE5]">
                <h3 class="font-semibold text-[#0F8F87] mb-2">
                    WhatsApp
                </h3>

                <p class="text-gray-700">
                    +62 812-3456-7890
                </p>
            </div>

            {{-- Email --}}
            <div class="p-4 rounded-2xl bg-[#F4FBFA] border border-[#BEEAE5]">
                <h3 class="font-semibold text-[#0F8F87] mb-2">
                    Email
                </h3>

                <p class="text-gray-700">
                    admin@arungfutsal.com
                </p>
            </div>

            {{-- Jam Operasional --}}
            <div class="p-4 rounded-2xl bg-[#F4FBFA] border border-[#BEEAE5]">
                <h3 class="font-semibold text-[#0F8F87] mb-2">
                    Jam Operasional
                </h3>

                <p class="text-gray-700">
                    Senin - Minggu
                </p>

                <p class="text-gray-700">
                    08.00 - 21.00 WIB
                </p>
            </div>

            {{-- FAQ --}}
            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Pertanyaan Umum
                </h2>

                <div class="space-y-4">

                    <div>
                        <p class="font-medium">
                            Bagaimana cara melakukan booking?
                        </p>

                        <p class="text-gray-600">
                            Pilih jadwal yang tersedia, lakukan pemesanan,
                            kemudian unggah bukti pembayaran.
                        </p>
                    </div>

                    <div>
                        <p class="font-medium">
                            Kapan booking dikonfirmasi?
                        </p>

                        <p class="text-gray-600">
                            Booking akan dikonfirmasi setelah admin
                            memverifikasi pembayaran.
                        </p>
                    </div>

                    <div>
                        <p class="font-medium">
                            Apakah saya bisa mengubah data akun?
                        </p>

                        <p class="text-gray-600">
                            Ya, melalui menu Edit Profile,
                            Ganti Username, dan Ganti Password.
                        </p>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

@endsection