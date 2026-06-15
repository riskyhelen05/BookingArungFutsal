@extends('layouts.admin')

@section('title', 'Profile Admin')
@section('page-title', 'Profile Admin')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">

        {{-- FOTO PROFIL --}}
        <div class="flex flex-col items-center">

            <div class="w-32 h-32 rounded-full overflow-hidden bg-slate-200 border-4 border-[#1ABC9C]/20">

                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=1ABC9C&color=fff&size=256"
                    class="w-full h-full object-cover">

            </div>

            <h2 class="mt-5 text-2xl font-bold text-[#1A1A2E]">
                {{ auth()->user()->name }}
            </h2>

            <p class="text-slate-500">
                {{ auth()->user()->email }}
            </p>

        </div>

        {{-- MENU PROFILE --}}
        <div class="mt-10 space-y-4">

            {{-- KONFIRMASI AKUN --}}
            <a href="{{ route('admin.profile.account') }}"
               class="flex items-center justify-between p-5 rounded-2xl border border-slate-200 hover:border-[#1ABC9C] hover:bg-[#F8FFFD] transition">

                <div>
                    <h3 class="font-semibold text-[#1A1A2E]">
                        Konfirmasi Akun
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Verifikasi informasi akun admin.
                    </p>
                </div>

                <span class="text-[#1ABC9C] text-xl">
                    →
                </span>

            </a>

            {{-- PASSWORD --}}
            <a href="{{ route('admin.profile.password') }}"
               class="flex items-center justify-between p-5 rounded-2xl border border-slate-200 hover:border-[#1ABC9C] hover:bg-[#F8FFFD] transition">

                <div>
                    <h3 class="font-semibold text-[#1A1A2E]">
                        Ubah Password
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Ganti password akun admin.
                    </p>
                </div>

                <span class="text-[#1ABC9C] text-xl">
                    →
                </span>

            </a>

            {{-- LOKASI --}}
            <a href="{{ route('admin.profile.location') }}"
               class="flex items-center justify-between p-5 rounded-2xl border border-slate-200 hover:border-[#1ABC9C] hover:bg-[#F8FFFD] transition">

                <div>
                    <h3 class="font-semibold text-[#1A1A2E]">
                        Lokasi Futsal
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Kelola alamat dan lokasi lapangan.
                    </p>
                </div>

                <span class="text-[#1ABC9C] text-xl">
                    →
                </span>

            </a>

            {{-- PEMBAYARAN --}}
            <a href="{{ route('admin.profile.payment') }}"
               class="flex items-center justify-between p-5 rounded-2xl border border-slate-200 hover:border-[#1ABC9C] hover:bg-[#F8FFFD] transition">

                <div>
                    <h3 class="font-semibold text-[#1A1A2E]">
                        Metode Pembayaran
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Kelola rekening pembayaran futsal.
                    </p>
                </div>

                <span class="text-[#1ABC9C] text-xl">
                    →
                </span>

            </a>

        </div>

    </div>

</div>

@endsection