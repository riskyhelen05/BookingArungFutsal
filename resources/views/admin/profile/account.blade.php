@extends('layouts.admin')

@section('title', 'Konfirmasi Akun')
@section('page-title', 'Konfirmasi Akun')

@section('content')

<div class="max-w-3xl mx-auto">

   

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">

        <div class="mb-8">

            <a href="{{ route('admin.profile') }}"
               class="inline-flex items-center gap-2
                      text-[#1ABC9C]
                      hover:text-[#169c83]
                      font-medium mb-5">

                ← Kembali ke Profil

            </a>

            <h2 class="text-2xl font-bold text-[#1A1A2E]">
                Konfirmasi Akun
            </h2>

            <p class="text-slate-500 mt-1">
                Masukkan password untuk memverifikasi akun admin.
            </p>

        </div>

        <form action="{{ route('admin.profile.account.confirm') }}"
              method="POST">

            @csrf

            <div class="space-y-5">

                <div>

                    <label class="block text-sm font-medium mb-2">
                        Nama Admin
                    </label>

                    <input
                        type="text"
                        value="{{ auth()->user()->name }}"
                        readonly
                        class="w-full rounded-xl border-slate-300 bg-slate-50">

                </div>

                <div>

                    <label class="block text-sm font-medium mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        value="{{ auth()->user()->email }}"
                        readonly
                        class="w-full rounded-xl border-slate-300 bg-slate-50">

                </div>

                <div>

                    <label class="block text-sm font-medium mb-2">
                        Password Saat Ini
                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Masukkan password"
                        class="w-full rounded-xl border-slate-300">

                    @error('password')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

            <div class="mt-8 flex justify-end">

                <button
                    type="submit"
                    class="px-6 py-3 bg-[#1ABC9C]
                           text-white rounded-xl
                           hover:bg-[#169c83]
                           transition">

                    Konfirmasi Akun

                </button>

            </div>

        </form>

    </div>

</div>

@endsection