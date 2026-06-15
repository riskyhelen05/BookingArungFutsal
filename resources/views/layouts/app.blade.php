<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'ArungFutsal') – Booking Lapangan</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet" />

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        mono: ['DM Mono', 'monospace'],
                    },
                    colors: {
                        brand: {
                            50:  '#edfcf7',
                            100: '#d2f9ec',
                            200: '#a9f1da',
                            300: '#6fe4c1',
                            400: '#33cfa2',
                            500: '#0fb589',   // primary
                            600: '#069270',
                            700: '#07745b',
                            800: '#095c49',
                            900: '#0a4c3d',
                        },
                        surface: '#f0faf7',
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.45s ease both',
                        'slide-in': 'slideIn 0.35s ease both',
                        'pop': 'pop 0.25s cubic-bezier(0.34,1.56,0.64,1) both',
                    },
                    keyframes: {
                        fadeUp:  { from: { opacity: 0, transform: 'translateY(18px)' }, to: { opacity: 1, transform: 'translateY(0)' } },
                        slideIn: { from: { opacity: 0, transform: 'translateX(-16px)' }, to: { opacity: 1, transform: 'translateX(0)' } },
                        pop:     { from: { opacity: 0, transform: 'scale(0.88)' }, to: { opacity: 1, transform: 'scale(1)' } },
                    },
                }
            }
        }
    </script>

    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f0faf7; }
        ::-webkit-scrollbar-thumb { background: #0fb589; border-radius: 999px; }

        /* Slot badge animations */
        .slot-btn { transition: all .18s ease; }
        .slot-btn:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(15,181,137,.25); }
        .slot-btn.selected { ring: 2px solid #0fb589; }

        /* Grid checkbox hack */
        .slot-check:checked + label .slot-pill { background: #0fb589 !important; color: #fff !important; }

        /* Upload zone */
        .upload-zone { transition: border-color .2s, background .2s; }
        .upload-zone.drag-over { border-color: #0fb589; background: #edfcf7; }

        /* Floating label */
        .float-label { transition: all .15s ease; }
        select:focus ~ .float-label, select:not([value=""]) ~ .float-label { transform: translateY(-20px) scale(.8); }

        /* Step indicator */
        .step-line { flex: 1; height: 2px; background: #d1fae5; }
        .step-line.active { background: #0fb589; }

        @media (max-width: 640px) {
            .hide-mobile { display: none; }
        }
    </style>

    @stack('head')
</head>
<body class="bg-surface min-h-screen flex flex-col">

    <!-- ═══ Navbar ═══ -->
    <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-brand-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            <!-- Logo -->
            <a href="/" class="flex items-center gap-2.5 group">
                <div class="w-9 h-9 rounded-xl bg-brand-500 flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6l1.5 4.5H18l-3.75 2.73 1.43 4.27L12 14.54l-3.68 2.96 1.43-4.27L6 10.5h4.5z" fill="white"/>
                    </svg>
                </div>
                <span class="font-extrabold text-xl text-brand-700 tracking-tight">ArungFutsal</span>
            </a>


                <!-- Mobile menu toggle -->
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg hover:bg-brand-50 transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile nav -->
        <div id="mobile-nav" class="hidden md:hidden border-t border-brand-100 bg-white px-4 py-3 space-y-1">
            <a href="{{ route('user.beranda') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-brand-50 hover:text-brand-700 transition-colors">Beranda</a>
            <a href="{{ route('user.booking.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-brand-50 hover:text-brand-700 transition-colors">Booking</a>
            <a href="{{ route('user.booking.history') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-brand-50 hover:text-brand-700 transition-colors">Booking Saya</a>
        </div>
    </header>

    <!-- ═══ Flash Messages ═══ -->
    @if(session('success'))
    <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-4">
        <div class="flex items-center gap-3 bg-brand-50 border border-brand-200 text-brand-800 px-4 py-3 rounded-xl animate-fade-up">
            <svg class="w-5 h-5 flex-shrink-0 text-brand-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-4">
        <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl animate-fade-up">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/></svg>
            <ul class="text-sm font-medium space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- ═══ Content ═══ -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- ═══ Footer ═══ -->
    <footer class="bg-brand-800 text-brand-100 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-brand-500 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/><path d="M12 6l1.5 4.5H18l-3.75 2.73 1.43 4.27L12 14.54l-3.68 2.96 1.43-4.27L6 10.5h4.5z" fill="white"/></svg>
                    </div>
                    <span class="font-bold text-white">ArungFutsal</span>
                </div>
                <p class="text-sm text-brand-300">Jl. IKIP C10A, Gunung Anyar, Surabaya, Jawa Timur</p>
                <p class="text-xs text-brand-400">© {{ date('Y') }} ArungFutsal. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
            document.getElementById('mobile-nav').classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>
</html>