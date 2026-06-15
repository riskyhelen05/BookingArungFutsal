@extends('layouts.admin')

@section('title', 'Kelola Lapangan')
@section('page-title', 'Kelola Lapangan')

@section('content')

<div class="bg-white rounded-2xl shadow-sm p-6">


{{-- Header --}}
<div class="flex justify-between items-center mb-6">

    <div>
        <h2 class="text-2xl font-bold text-[#1A1A2E]">
            Daftar Lapangan
        </h2>

        <p class="text-sm text-slate-500 mt-1">
            Kelola data lapangan Arung Futsal.
        </p>
    </div>

    <a href="{{ route('admin.lapangan.create') }}"
       class="px-5 py-3 bg-[#1ABC9C] text-white rounded-xl font-medium hover:bg-[#16A085] transition">

        + Tambah Lapangan

    </a>

</div>



{{-- Table --}}
<div class="overflow-x-auto">

    <table class="w-full">

        <thead>

            <tr class="border-b border-slate-200 text-slate-500 text-sm">

                <th class="w-36 text-left py-4 px-4 font-semibold">
                    Foto
                </th>

                <th class="w-64 text-left py-4 px-4 font-semibold">
                    Nama Lapangan
                </th>

                <th class="w-48 text-left py-4 px-4 font-semibold">
                    Harga Perjam
                </th>

                <th class="w-40 text-left py-4 px-4 font-semibold">
                    Status
                </th>

                <th class="w-72 text-center py-4 px-4 font-semibold">
                    Aksi
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($fields as $field)

                <tr class="border-b border-slate-100 hover:bg-slate-50 transition">

                    {{-- FOTO --}}
                    <td class="px-4 py-5">

                        @if($field->photo_url)

                            <img
                                src="{{ asset('storage/' . $field->photo_url) }}"
                                alt="{{ $field->name }}"
                                class="w-24 h-16 rounded-xl object-cover border border-slate-200">

                        @else

                            <div
                                class="w-24 h-16 rounded-xl bg-slate-200 flex items-center justify-center text-xs text-slate-500">

                                No Image

                            </div>

                        @endif

                    </td>

                    {{-- NAMA --}}
                    <td class="px-4 py-5">

                        <div class="font-semibold text-[#1A1A2E]">
                            {{ $field->name }}
                        </div>

                        @if($field->description)
                            <div class="text-xs text-slate-500 mt-1">
                                {{ Str::limit($field->description, 50) }}
                            </div>
                        @endif

                    </td>

                    {{-- HARGA --}}
                    <td class="px-4 py-5 whitespace-nowrap">

                        <span class="font-semibold text-[#1A1A2E]">
                            Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}
                        </span>

                    </td>

                    {{-- STATUS --}}
                    <td class="px-4 py-5">

                        @if($field->status == 'available')

                            <span
                                class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">

                                Tersedia

                            </span>

                        @elseif($field->status == 'maintenance')

                            <span
                                class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">

                                Maintenance

                            </span>

                        @elseif($field->status == 'closed')

                            <span
                                class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">

                                Ditutup

                            </span>

                        @endif

                    </td>

                    {{-- AKSI --}}
                    <td class="px-4 py-5">

                        <div class="flex justify-center items-center gap-2 whitespace-nowrap">

                            {{-- DETAIL --}}
                            <a href="{{ route('admin.lapangan.show', $field) }}"
                               class="px-3 py-2 rounded-lg bg-sky-100 text-sky-700 text-xs font-semibold hover:bg-sky-200 transition">

                                Detail

                            </a>

                            {{-- EDIT --}}
                            <a href="{{ route('admin.lapangan.edit', $field) }}"
                               class="px-3 py-2 rounded-lg bg-amber-100 text-amber-700 text-xs font-semibold hover:bg-amber-200 transition">

                                Edit

                            </a>

                            {{-- HAPUS --}}
                            <form action="{{ route('admin.lapangan.destroy', $field) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    onclick="return confirm('Yakin ingin menghapus lapangan ini?')"
                                    class="px-3 py-2 rounded-lg bg-red-100 text-red-700 text-xs font-semibold hover:bg-red-200 transition">

                                    Hapus

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5" class="py-12 text-center text-slate-500">

                        Belum ada data lapangan.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>
```

</div>

@endsection
