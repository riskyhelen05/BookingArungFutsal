@extends('layouts.admin')

@section('title', 'Metode Pembayaran')
@section('page-title', 'Metode Pembayaran')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Tombol Kembali --}}
    <div class="mb-5">
        <a href="{{ route('admin.profile') }}"
           class="inline-flex items-center gap-2
                  text-[#1ABC9C]
                  font-medium
                  hover:text-[#0F9E82]
                  transition">

            <span class="text-xl">←</span>
            Kembali ke Profile
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">

        <div class="mb-8">

            <h2 class="text-2xl font-bold text-[#1A1A2E]">
                Metode Pembayaran
            </h2>

            <p class="text-slate-500 mt-1">
                Kelola rekening pembayaran Arung Futsal.
            </p>

        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="mb-5 p-4 rounded-xl bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.profile.payment.update') }}"
              method="POST">

            @csrf

            <div class="space-y-5">

                {{-- Nama Bank --}}
                <div>
                    <label class="block text-sm font-medium mb-2">
                        Nama Bank
                    </label>

                    <select
    name="bank_name"
    class="w-full rounded-xl border-slate-300">

    <option value="">
        -- Pilih Bank --
    </option>

    <option value="BCA"
        {{ old('bank_name', $setting->bank_name ?? '') == 'BCA' ? 'selected' : '' }}>
        Bank Central Asia (BCA)
    </option>

    <option value="BRI"
        {{ old('bank_name', $setting->bank_name ?? '') == 'BRI' ? 'selected' : '' }}>
        Bank Rakyat Indonesia (BRI)
    </option>

    <option value="BNI"
        {{ old('bank_name', $setting->bank_name ?? '') == 'BNI' ? 'selected' : '' }}>
        Bank Negara Indonesia (BNI)
    </option>

    <option value="Mandiri"
        {{ old('bank_name', $setting->bank_name ?? '') == 'Mandiri' ? 'selected' : '' }}>
        Bank Mandiri
    </option>

    <option value="CIMB Niaga"
        {{ old('bank_name', $setting->bank_name ?? '') == 'CIMB Niaga' ? 'selected' : '' }}>
        CIMB Niaga
    </option>

    <option value="BTN"
        {{ old('bank_name', $setting->bank_name ?? '') == 'BTN' ? 'selected' : '' }}>
        Bank BTN
    </option>

    <option value="Permata"
        {{ old('bank_name', $setting->bank_name ?? '') == 'Permata' ? 'selected' : '' }}>
        Bank Permata
    </option>

    <option value="BSI"
        {{ old('bank_name', $setting->bank_name ?? '') == 'BSI' ? 'selected' : '' }}>
        Bank Syariah Indonesia (BSI)
    </option>

    <option value="Danamon"
        {{ old('bank_name', $setting->bank_name ?? '') == 'Danamon' ? 'selected' : '' }}>
        Bank Danamon
    </option>

    <option value="Maybank"
        {{ old('bank_name', $setting->bank_name ?? '') == 'Maybank' ? 'selected' : '' }}>
        Maybank Indonesia
    </option>

</select>

                {{-- Nomor Rekening --}}
                <div>
                    <label class="block text-sm font-medium mb-2">
                        Nomor Rekening
                    </label>

                    <input
                        type="text"
                        name="account_number"
                        value="{{ old('account_number', $setting->account_number ?? '') }}"
                        class="w-full rounded-xl border-slate-300">
                </div>

                {{-- Nama Pemilik --}}
                <div>
                    <label class="block text-sm font-medium mb-2">
                        Nama Pemilik Rekening
                    </label>

                    <input
                        type="text"
                        name="account_holder"
                        value="{{ old('account_holder', $setting->account_holder ?? '') }}"
                        class="w-full rounded-xl border-slate-300">
                </div>

            </div>

            {{-- Tombol --}}
            <div class="mt-8 flex justify-end">

                <button
                    type="submit"
                    class="px-6 py-3 bg-[#1ABC9C]
                           text-white rounded-xl
                           hover:bg-[#0F9E82]
                           transition">

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection