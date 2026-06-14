@extends('layouts.user')

@section('title', 'Syarat & Ketentuan')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="mb-5">
        <h1 class="text-2xl font-bold text-[#0F8F87]">
            Syarat & Ketentuan
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

        {{-- Isi --}}
        <div class="space-y-6 text-gray-700">

            <div>
                <h2 class="font-semibold text-lg mb-2">
                    1. Penggunaan Layanan
                </h2>
                <p>
                    Dengan menggunakan aplikasi Booking Arung Futsal,
                    pengguna dianggap telah memahami dan menyetujui seluruh
                    syarat dan ketentuan yang berlaku.
                </p>
            </div>

            <div>
                <h2 class="font-semibold text-lg mb-2">
                    2. Akun Pengguna
                </h2>
                <p>
                    Pengguna bertanggung jawab atas keamanan akun dan
                    kerahasiaan informasi login yang dimiliki.
                </p>
            </div>

            <div>
                <h2 class="font-semibold text-lg mb-2">
                    3. Pemesanan Lapangan
                </h2>
                <p>
                    Pemesanan lapangan dilakukan melalui sistem dan dianggap
                    sah setelah pengguna mengikuti prosedur yang ditetapkan.
                </p>
            </div>

            <div>
                <h2 class="font-semibold text-lg mb-2">
                    4. Pembayaran
                </h2>
                <p>
                    Pengguna wajib melakukan pembayaran sesuai ketentuan
                    dan mengunggah bukti pembayaran yang valid.
                </p>
            </div>

            <div>
                <h2 class="font-semibold text-lg mb-2">
                    5. Pembatalan
                </h2>
                <p>
                    Pembatalan pemesanan mengikuti kebijakan yang berlaku
                    pada Arung Futsal dan dapat berubah sewaktu-waktu.
                </p>
            </div>

            <div>
                <h2 class="font-semibold text-lg mb-2">
                    6. Perubahan Ketentuan
                </h2>
                <p>
                    Arung Futsal berhak memperbarui syarat dan ketentuan
                    tanpa pemberitahuan sebelumnya apabila diperlukan.
                </p>
            </div>

        </div>

    </div>

</div>

@endsection