@extends('layouts.auth')

@section('title', 'Login')

@section('content')

    <h2 class="text-xl font-semibold text-[#1A1A2E] mb-1">Selamat datang!</h2>
    <p class="text-sm text-[#6B7280] mb-6">Masuk ke akun kamu untuk mulai booking.</p>

    {{-- Alert error global --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 mb-5">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Alert success (setelah logout) --}}
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3 mb-5">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Email / Username --}}
        <div>
            <label class="block text-sm font-medium text-[#1A1A2E] mb-1.5">
                Email atau Username
            </label>
            <input
                type="text"
                name="login"
                value="{{ old('login') }}"
                placeholder="contoh@email.com atau username"
                class="w-full px-4 py-3 rounded-xl border text-sm text-[#1A1A2E] placeholder-[#9CA3AF]
                       focus:outline-none focus:ring-2 focus:ring-[#1ABC9C] focus:border-transparent transition
                       {{ $errors->has('login') ? 'border-red-400 bg-red-50' : 'border-[#E2E8F0] bg-white' }}"
                autocomplete="username"
            >
            @error('login')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label class="block text-sm font-medium text-[#1A1A2E] mb-1.5">
                Password
            </label>
            <div class="relative">
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Masukkan password"
                    class="w-full px-4 py-3 rounded-xl border text-sm text-[#1A1A2E] placeholder-[#9CA3AF]
                           focus:outline-none focus:ring-2 focus:ring-[#1ABC9C] focus:border-transparent transition pr-11
                           {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-[#E2E8F0] bg-white' }}"
                    autocomplete="current-password"
                >
                {{-- Toggle show/hide password --}}
                <button type="button" onclick="togglePassword('password', 'eye-login')"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-[#9CA3AF] hover:text-[#1ABC9C] transition">
                    <svg id="eye-login" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
                               -1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember me --}}
        <div class="flex items-center">
            <input type="checkbox" name="remember" id="remember"
                class="w-4 h-4 rounded border-gray-300 text-[#1ABC9C] focus:ring-[#1ABC9C]">
            <label for="remember" class="ml-2 text-sm text-[#6B7280]">Ingat saya</label>
        </div>

        {{-- Submit --}}
        <button type="submit"
            class="w-full bg-[#1ABC9C] hover:bg-[#0F9E82] text-white font-semibold py-3 rounded-xl
                   transition duration-150 active:scale-[0.98] text-sm mt-2">
            Masuk
        </button>

    </form>

    {{-- Link ke register --}}
    <p class="text-center text-sm text-[#6B7280] mt-6">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-[#1ABC9C] font-semibold hover:underline">
            Daftar sekarang
        </a>
    </p>

@endsection

@push('scripts')
<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.style.opacity = '0.5';
    } else {
        input.type = 'password';
        icon.style.opacity = '1';
    }
}
</script>
@endpush