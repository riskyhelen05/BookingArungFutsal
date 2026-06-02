<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — Arung Futsal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#E8FAF5] flex items-center justify-center px-4">

    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-[#1ABC9C] rounded-2xl mb-3">
                <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2z" fill="none"/>
                    <circle cx="12" cy="12" r="3.5"/>
                </svg>
            </div>
            <h1 class="text-2xl font-semibold text-[#1A1A2E]">Arung Futsal</h1>
            <p class="text-sm text-[#6B7280] mt-1">JL. IKIP C10A, Gunung Anyar, Surabaya</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-sm p-8">
            @yield('content')
        </div>

        {{-- Footer --}}
        <p class="text-center text-xs text-[#6B7280] mt-6">
            &copy; {{ date('Y') }} Arung Futsal. All rights reserved.
        </p>

    </div>
@stack('scripts')
</body>
</html>