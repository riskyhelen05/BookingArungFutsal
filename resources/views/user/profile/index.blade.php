@extends('layouts.user')

@section('title', 'Profil')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="bg-white rounded-[32px]
                border border-[#BEEAE5]
                shadow-sm overflow-hidden">

        <div class="grid grid-cols-1 lg:grid-cols-3">

            {{-- LEFT SIDE PROFILE --}}
            <div class="bg-[#F4FCFA] border-r border-[#E4F3F0]
                        p-8 flex flex-col items-center text-center">

                {{-- Foto Profile --}}
                <div class="w-36 h-36 rounded-full overflow-hidden
                            border-4 border-[#12B5A5]
                            bg-[#D9F4F1] mb-5">

                    @if(Auth::user()->avatar_url)

                        <img src="{{ asset('storage/' . Auth::user()->avatar_url) }}"
                             class="w-full h-full object-cover"
                             alt="Profile">

                    @else

                        <div class="w-full h-full flex items-center
                                    justify-center text-[#12B5A5]
                                    text-5xl font-bold">

                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

                        </div>

                    @endif

                </div>

                {{-- Nama --}}
                <h2 class="text-2xl font-bold text-gray-800">
                    {{ Auth::user()->name }}
                </h2>

                {{-- Username --}}
                <p class="text-[#12B5A5] font-semibold mt-1">
                    {{ '@' . Auth::user()->username }}
                </p>

                {{-- Email --}}
                <p class="text-sm text-gray-500 mt-4 break-all">
                    {{ Auth::user()->email }}
                </p>

                {{-- Nomor Telepon --}}
                <p class="text-sm text-gray-500 mt-1">
                    {{ Auth::user()->phone }}
                </p>

            </div>

            {{-- RIGHT SIDE MENU --}}
            <div class="lg:col-span-2 p-8">

                <h3 class="text-2xl font-bold text-[#12B5A5] mb-6">
                    Pengaturan Profil
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- Edit Profile --}}
                    <a href="{{ route('user.profile.edit') }}"
                       class="bg-[#F8FFFD]
                              border border-[#D9F4F1]
                              rounded-2xl p-5
                              hover:border-[#12B5A5]
                              hover:shadow-md
                              transition">

                        <h4 class="font-semibold text-gray-800">
                            Edit Profile
                        </h4>

                        <p class="text-sm text-gray-500 mt-1">
                            Ubah informasi akun kamu
                        </p>
                    </a>

                    {{-- Username --}}
                    <a href="{{ route('user.profile.username') }}"
                       class="bg-[#F8FFFD]
                              border border-[#D9F4F1]
                              rounded-2xl p-5
                              hover:border-[#12B5A5]
                              hover:shadow-md
                              transition">

                        <h4 class="font-semibold text-gray-800">
                            Ganti Username
                        </h4>

                        <p class="text-sm text-gray-500 mt-1">
                            Perbarui username akun
                        </p>
                    </a>

                    {{-- Password --}}
                    <a href="{{ route('user.profile.password') }}"
                       class="bg-[#F8FFFD]
                              border border-[#D9F4F1]
                              rounded-2xl p-5
                              hover:border-[#12B5A5]
                              hover:shadow-md
                              transition">

                        <h4 class="font-semibold text-gray-800">
                            Ganti Password
                        </h4>

                        <p class="text-sm text-gray-500 mt-1">
                            Ubah password akun
                        </p>
                    </a>

                    {{-- Maps --}}
                    <a href="{{ route('user.profile.maps') }}"
                    class="bg-[#F8FFFD]
                            border border-[#D9F4F1]
                            rounded-2xl p-5
                            hover:border-[#12B5A5]
                            hover:shadow-md
                            transition">

                        <h4 class="font-semibold text-gray-800">
                            Maps Arung Futsal
                        </h4>

                        <p class="text-sm text-gray-500 mt-1">
                            Lihat lokasi lapangan
                        </p>

                    </a>

                    {{-- Privacy --}}
                    <a href="{{ route('user.profile.privacy') }}"
                       class="bg-[#F8FFFD]
                              border border-[#D9F4F1]
                              rounded-2xl p-5
                              hover:border-[#12B5A5]
                              hover:shadow-md
                              transition">

                        <h4 class="font-semibold text-gray-800">
                            Kebijakan Privasi
                        </h4>

                        <p class="text-sm text-gray-500 mt-1">
                            Informasi privasi pengguna
                        </p>
                    </a>

                    {{-- Terms --}}
                    <a href="{{ route('user.profile.terms') }}"
                       class="bg-[#F8FFFD]
                              border border-[#D9F4F1]
                              rounded-2xl p-5
                              hover:border-[#12B5A5]
                              hover:shadow-md
                              transition">

                        <h4 class="font-semibold text-gray-800">
                            Syarat & Ketentuan
                        </h4>

                        <p class="text-sm text-gray-500 mt-1">
                            Ketentuan penggunaan aplikasi
                        </p>
                    </a>

                    {{-- Support --}}
                    <a href="{{ route('user.profile.support') }}"
                       class="bg-[#F8FFFD]
                              border border-[#D9F4F1]
                              rounded-2xl p-5
                              hover:border-[#12B5A5]
                              hover:shadow-md
                              transition md:col-span-2">

                        <h4 class="font-semibold text-gray-800">
                            Dukungan & Bantuan
                        </h4>

                        <p class="text-sm text-gray-500 mt-1">
                            Hubungi admin jika mengalami kendala
                        </p>
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection