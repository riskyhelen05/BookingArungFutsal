@extends('layouts.admin')

@section('title', 'Ubah Password')
@section('page-title', 'Ubah Password')

@section('content')

        <div class="max-w-3xl mx-auto">
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
                Ubah Password
            </h2>

            <p class="text-slate-500 mt-1">
                Gunakan password yang kuat dan mudah diingat.
            </p>

        </div>

        {{-- ERROR --}}
        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-100 text-red-700">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.profile.password.update') }}"
              method="POST">

            @csrf

            <div class="space-y-5">

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Password Lama
                    </label>

                    <input
                        type="password"
                        name="current_password"
                        required
                        class="w-full rounded-xl border-slate-300">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Password Baru
                    </label>

                    <input
                        type="password"
                        name="new_password"
                        required
                        class="w-full rounded-xl border-slate-300">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Konfirmasi Password Baru
                    </label>

                    <input
                        type="password"
                        name="new_password_confirmation"
                        required
                        class="w-full rounded-xl border-slate-300">
                </div>

            </div>

            <div class="mt-8 flex justify-end">

                <button
                    type="submit"
                    class="px-6 py-3 bg-[#1ABC9C] text-white rounded-xl hover:bg-[#17a589] transition">

                    Simpan Password

                </button>

            </div>

        </form>

    </div>

</div>

@endsection