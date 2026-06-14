@extends('layouts.user')

@section('title', 'Kebijakan Privasi')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="mb-5">
        <h1 class="text-2xl font-bold text-[#0F8F87]">
            Kebijakan Privasi
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

        {{-- Isi Kebijakan Privasi --}}
        <div class="space-y-6 text-gray-700">

            <div>
                <h2 class="font-semibold text-lg mb-2">
                    1. Informasi yang Dikumpulkan
                </h2>
                <p>
                    Arung Futsal mengumpulkan informasi yang diberikan pengguna
                    saat melakukan registrasi akun, pemesanan lapangan,
                    maupun penggunaan fitur lainnya dalam aplikasi.
                </p>
            </div>

            <div>
                <h2 class="font-semibold text-lg mb-2">
                    2. Penggunaan Informasi
                </h2>
                <p>
                    Informasi digunakan untuk proses pemesanan, verifikasi
                    pembayaran, pemberian notifikasi, dan peningkatan kualitas
                    layanan Arung Futsal.
                </p>
            </div>

            <div>
                <h2 class="font-semibold text-lg mb-2">
                    3. Keamanan Data
                </h2>
                <p>
                    Kami berupaya menjaga keamanan data pengguna dan mencegah
                    akses yang tidak sah terhadap informasi pribadi pengguna.
                </p>
            </div>

            <div>
                <h2 class="font-semibold text-lg mb-2">
                    4. Kerahasiaan Data
                </h2>
                <p>
                    Data pengguna tidak akan dibagikan kepada pihak ketiga tanpa
                    persetujuan pengguna kecuali diwajibkan oleh peraturan yang
                    berlaku.
                </p>
            </div>

            <div>
                <h2 class="font-semibold text-lg mb-2">
                    5. Hak Pengguna
                </h2>
                <p>
                    Pengguna berhak memperbarui informasi akun, mengganti
                    password, dan menghubungi pengelola apabila terdapat
                    ketidaksesuaian data.
                </p>
            </div>

        </div>

    </div>

</div>

@endsection