@extends('layouts.admin')

@section('title', 'Kelola Lapangan')
@section('page-title', 'Kelola Lapangan')

@section('content')

<div class="bg-white rounded-2xl shadow-sm p-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-[#1A1A2E]">
            Daftar Lapangan
        </h2>

        <a href="{{ route('admin.lapangan.create') }}"
           class="px-4 py-2 bg-[#1ABC9C] text-white rounded-xl hover:opacity-90">
            + Tambah Lapangan
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-sm">

            <thead>
                <tr class="border-b">
                    <th class="text-left py-3">Foto</th>
                    <th class="text-left py-3">Nama</th>
                    <th class="text-left py-3">Harga/Jam</th>
                    <th class="text-left py-3">Status</th>
                    <th class="text-left py-3">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($fields as $field)

                    <tr class="border-b">

                        <td class="py-3">

                            @if($field->photo_url)
                                <img src="{{ asset('storage/' . $field->photo_url) }}"
                                     class="w-20 h-14 rounded-lg object-cover">
                            @else
                                <div class="w-20 h-14 bg-gray-200 rounded-lg"></div>
                            @endif

                        </td>

                        <td>{{ $field->name }}</td>

                        <td>
                            Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}
                        </td>

                        <td>

                            @if($field->status == 'active')
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700">
                                    Aktif
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700">
                                    Nonaktif
                                </span>
                            @endif

                        </td>

                        <td class="space-x-2">

                            <a href="{{ route('admin.lapangan.edit', $field) }}"
                               class="text-blue-600">
                                Edit
                            </a>

                            <form action="{{ route('admin.lapangan.destroy', $field) }}"
                                  method="POST"
                                  class="inline">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        onclick="return confirm('Hapus lapangan ini?')"
                                        class="text-red-600">
                                    Hapus
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">
                            Belum ada data lapangan
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>
    </div>

</div>

@endsection