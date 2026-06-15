@extends('layouts.admin')

@section('title', 'Lokasi Futsal')
@section('page-title', 'Lokasi Futsal')

@section('content')

<div class="max-w-4xl mx-auto">

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
                Lokasi Futsal
            </h2>

            <p class="text-slate-500 mt-1">
                Kelola informasi Arung Futsal.
            </p>

        </div>

        <form
            action="{{ route('admin.profile.location.update') }}"
            method="POST">
            @csrf

            <div class="space-y-5">

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Nama Tempat
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $setting->name ?? '') }}"
                        class="w-full rounded-xl border-slate-300">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Nomor Telepon
                    </label>

                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone', $setting->phone ?? '') }}"
                        class="w-full rounded-xl border-slate-300">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Alamat Lengkap
                    </label>

                    <textarea
                        name="address"
                        rows="4"
                        class="w-full rounded-xl border-slate-300">{{ old('address', $setting->address ?? '') }}</textarea>
                </div>

                <div>
    <label class="block text-sm font-medium mb-2">
        Link Google Maps
    </label>

    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">

        <a
            href="{{ $setting->google_maps ?? 'https://maps.google.com/?q=Arung+Futsal' }}"
            target="_blank"
            class="text-[#1ABC9C] break-all">

            {{ $setting->google_maps ?? 'https://maps.google.com/?q=Arung+Futsal' }}

        </a>

    </div>
</div>

                    <input
                        type="text"
                        name="google_maps"
                        value="{{ old('google_maps', $setting->google_maps ?? '') }}"
                        class="w-full rounded-xl border-slate-300">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Jam Operasional
                    </label>

                    <input
                        type="text"
                        name="operational_hours"
                        value="{{ old('operational_hours', $setting->operational_hours ?? '') }}"
                        placeholder="08:00 - 23:00"
                        class="w-full rounded-xl border-slate-300">
                </div>

            </div>

            <div class="mt-8 flex justify-end">

                <button
                    type="submit"
                    class="px-6 py-3 bg-[#1ABC9C]
                           text-white rounded-xl
                           hover:bg-[#17a589] transition">

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection