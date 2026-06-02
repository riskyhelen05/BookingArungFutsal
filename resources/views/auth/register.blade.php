@extends('layouts.auth')

@section('title', 'Daftar')

@section('content')

    <h2 class="text-xl font-semibold text-[#1A1A2E] mb-1">Buat akun baru</h2>
    <p class="text-sm text-[#6B7280] mb-6">Daftar untuk mulai booking lapangan futsal.</p>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 mb-5">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Nama --}}
        <div>
            <label class="block text-sm font-medium text-[#1A1A2E] mb-1.5">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}"
                placeholder="Yahya Zahid"
                class="w-full px-4 py-3 rounded-xl border text-sm placeholder-[#9CA3AF]
                       focus:outline-none focus:ring-2 focus:ring-[#1ABC9C] focus:border-transparent transition
                       {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-[#E2E8F0]' }}">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-[#1A1A2E] mb-1.5">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                placeholder="contoh@email.com"
                class="w-full px-4 py-3 rounded-xl border text-sm placeholder-[#9CA3AF]
                       focus:outline-none focus:ring-2 focus:ring-[#1ABC9C] focus:border-transparent transition
                       {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-[#E2E8F0]' }}">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- No HP --}}
        <div>
            <label class="block text-sm font-medium text-[#1A1A2E] mb-1.5">Nomor HP</label>
            <input type="text" name="phone" value="{{ old('phone') }}"
                placeholder="08xxxxxxxxxx"
                class="w-full px-4 py-3 rounded-xl border text-sm placeholder-[#9CA3AF]
                       focus:outline-none focus:ring-2 focus:ring-[#1ABC9C] focus:border-transparent transition
                       {{ $errors->has('phone') ? 'border-red-400 bg-red-50' : 'border-[#E2E8F0]' }}">
            @error('phone')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Username --}}
        <div>
            <label class="block text-sm font-medium text-[#1A1A2E] mb-1.5">Username</label>
            <input type="text" name="username" value="{{ old('username') }}"
                placeholder="yahya_my"
                class="w-full px-4 py-3 rounded-xl border text-sm placeholder-[#9CA3AF]
                       focus:outline-none focus:ring-2 focus:ring-[#1ABC9C] focus:border-transparent transition
                       {{ $errors->has('username') ? 'border-red-400 bg-red-50' : 'border-[#E2E8F0]' }}">
            @error('username')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label class="block text-sm font-medium text-[#1A1A2E] mb-1.5">Password</label>
            <div class="relative">
                <input type="password" name="password" id="reg-password"
                    placeholder="Minimal 8 karakter"
                    class="w-full px-4 py-3 rounded-xl border text-sm placeholder-[#9CA3AF] pr-11
                           focus:outline-none focus:ring-2 focus:ring-[#1ABC9C] focus:border-transparent transition
                           {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-[#E2E8F0]' }}">
                <button type="button" onclick="togglePassword('reg-password', 'eye-reg')"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-[#9CA3AF] hover:text-[#1ABC9C] transition">
                    <svg id="eye-reg" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

        {{-- Konfirmasi Password --}}
        <div>
            <label class="block text-sm font-medium text-[#1A1A2E] mb-1.5">Konfirmasi Password</label>
            <div class="relative">
                <input type="password" name="password_confirmation" id="reg-confirm"
                    placeholder="Ulangi password"
                    class="w-full px-4 py-3 rounded-xl border text-sm placeholder-[#9CA3AF] pr-11
                           focus:outline-none focus:ring-2 focus:ring-[#1ABC9C] focus:border-transparent transition
                           border-[#E2E8F0]">
                <button type="button" onclick="togglePassword('reg-confirm', 'eye-confirm')"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-[#9CA3AF] hover:text-[#1ABC9C] transition">
                    <svg id="eye-confirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
                               -1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit"
            class="w-full bg-[#1ABC9C] hover:bg-[#0F9E82] text-white font-semibold py-3 rounded-xl
                   transition duration-150 active:scale-[0.98] text-sm mt-2">
            Daftar Sekarang
        </button>

    </form>

    <p class="text-center text-sm text-[#6B7280] mt-6">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-[#1ABC9C] font-semibold hover:underline">
            Masuk di sini
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