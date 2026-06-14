@extends('layouts.admin')

@section('title', 'Tambah Lapangan')
@section('page-title', 'Tambah Lapangan')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm p-6">

        <div class="mb-6">
            <a href="{{ route('admin.lapangan') }}"
               class="text-[#1ABC9C] hover:underline">
                ← Kembali ke Daftar Lapangan
            </a>
        </div>

        <form action="{{ route('admin.lapangan.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            {{-- Nama Lapangan --}}
            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Nama Lapangan
                </label>

                <input type="text"
                       name="name"
                       class="w-full border rounded-xl px-4 py-3"
                       required>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Deskripsi
                </label>

                <textarea name="description"
                          rows="4"
                          class="w-full border rounded-xl px-4 py-3"></textarea>
            </div>

            {{-- Harga --}}
            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Harga per Jam
                </label>

                <input type="number"
                       name="price_per_hour"
                       class="w-full border rounded-xl px-4 py-3"
                       required>
            </div>

            {{-- Foto --}}
            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Foto Lapangan
                </label>

                <input type="file"
                       name="photo"
                       class="w-full">
            </div>

            {{-- Status --}}
            <div class="mb-6">
                <label class="block mb-2 font-medium">
                    Status
                </label>

                <select name="status"
                        class="w-full border rounded-xl px-4 py-3">

                    <option value="active">
                        Aktif
                    </option>

                    <option value="inactive">
                        Nonaktif
                    </option>

                </select>
            </div>

            <button type="submit"
                    class="bg-[#1ABC9C] text-white px-6 py-3 rounded-xl">
                Simpan Lapangan
            </button>

        </form>

    </div>

</div>

@endsection