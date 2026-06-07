<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Arung Futsal')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#E8FAF5] min-h-screen flex">

    {{-- ═══════════════════════════════
         SIDEBAR (desktop)
    ═══════════════════════════════ --}}
    <aside class="hidden md:flex flex-col w-64 bg-white shadow-lg shrink-0">

        {{-- Logo --}}
        <div class="p-6 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-[#12B5A5] flex items-center justify-center">
                <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <circle cx="12" cy="12" r="10"/>
                    <path fill="white" d="M12 6l1.5 4.5H18l-3.75 2.73 1.43 4.27L12 14.54l-3.68 2.96 1.43-4.27L6 10.5h4.5z"/>
                </svg>
            </div>
            <span class="font-bold text-xl text-[#12B5A5]">Arung Futsal</span>
        </div>

        {{-- Nav links --}}
        <nav class="flex flex-col gap-1 px-4 flex-1">

            {{-- Beranda --}}
            <a href="{{ route('user.beranda') }}"
               class="px-4 py-3 rounded-xl flex items-center gap-3 text-sm font-medium transition-colors
                      {{ request()->routeIs('user.beranda') ? 'bg-[#E6F7F5] text-[#12B5A5] font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-lg">🏠</span> Beranda
            </a>

            {{-- Booking --}}
            <a href="{{ route('user.booking.index') }}"
               class="px-4 py-3 rounded-xl flex items-center gap-3 text-sm font-medium transition-colors
                      {{ request()->routeIs('user.booking.index') || request()->routeIs('user.payment.*') ? 'bg-[#E6F7F5] text-[#12B5A5] font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-lg">📅</span> Booking
            </a>

            {{-- Riwayat --}}
            <a href="{{ route('user.booking.history') }}"
               class="px-4 py-3 rounded-xl flex items-center gap-3 text-sm font-medium transition-colors
                      {{ request()->routeIs('user.booking.history') || request()->routeIs('user.booking.show') ? 'bg-[#E6F7F5] text-[#12B5A5] font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                <span class="text-lg">📖</span> Riwayat
            </a>

            {{-- Profil (belum ada route, pakai # dulu) --}}
            <a href="#"
               class="px-4 py-3 rounded-xl flex items-center gap-3 text-sm font-medium transition-colors
                      text-gray-400 cursor-not-allowed"
               title="Segera hadir">
                <span class="text-lg">👤</span> Profil
                <span class="ml-auto text-xs bg-gray-100 text-gray-400 px-1.5 py-0.5 rounded-md">Soon</span>
            </a>

        </nav>

        {{-- Logout --}}
        <div class="p-4 border-t border-gray-100">
            <div class="flex items-center gap-3 mb-3 px-1">
                <div class="w-9 h-9 rounded-full bg-[#12B5A5] text-white flex items-center justify-center font-bold text-sm shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full bg-red-500 hover:bg-red-600 active:scale-95 text-white text-sm
                               font-semibold py-2 rounded-lg transition-all">
                    Logout
                </button>
            </form>
        </div>

    </aside>

    {{-- ═══════════════════════════════
         MAIN CONTENT
    ═══════════════════════════════ --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- TOPBAR --}}
        <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center sticky top-0 z-30">

            <h1 class="font-bold text-lg text-gray-800">@yield('title')</h1>

            <div class="flex items-center gap-3">

                {{-- Notifikasi --}}
                <div class="relative">
                    <button id="notifBtn"
                            class="relative w-10 h-10 flex items-center justify-center rounded-xl
                                   hover:bg-gray-100 transition-colors text-xl">
                        🔔
                        <span id="notifBadge"
                              class="hidden absolute top-1 right-1 w-4 h-4 bg-red-500 text-white
                                     text-[10px] font-bold rounded-full flex items-center justify-center">
                        </span>
                    </button>

                    {{-- Dropdown notifikasi --}}
                    <div id="notifDropdown"
                         class="hidden absolute right-0 mt-2 w-80 bg-white shadow-xl rounded-2xl
                                border border-gray-100 z-50 max-h-96 overflow-y-auto">
                        <div class="flex justify-between items-center px-4 py-3 border-b border-gray-100">
                            <h4 class="font-bold text-gray-800">Notifikasi</h4>
                            <span class="text-xs text-gray-400">Live</span>
                        </div>
                        <div id="notifList" class="p-2">
                            <p class="text-gray-400 text-sm p-3">Memuat...</p>
                        </div>
                    </div>
                </div>

                {{-- Avatar --}}
                <div class="w-9 h-9 rounded-full bg-[#12B5A5] text-white flex items-center
                            justify-center font-bold text-sm shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>

            </div>
        </header>

        {{-- Flash messages --}}
        @if(session('success'))
        <div class="mx-6 mt-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800
                    px-4 py-3 rounded-xl text-sm font-medium">
            <span>✅</span> {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="mx-6 mt-4 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800
                    px-4 py-3 rounded-xl text-sm">
            <span class="shrink-0">❌</span>
            <ul class="space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- CONTENT --}}
        <main class="flex-1 p-6 pb-24 md:pb-6">
            @yield('content')
        </main>

    </div>

    {{-- ═══════════════════════════════
         MOBILE BOTTOM NAV
    ═══════════════════════════════ --}}
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-40">
        <div class="grid grid-cols-4 h-16">

            <a href="{{ route('user.beranda') }}"
               class="flex flex-col items-center justify-center gap-0.5 text-xs font-medium transition-colors
                      {{ request()->routeIs('user.beranda') ? 'text-[#12B5A5]' : 'text-gray-400' }}">
                <span class="text-xl">🏠</span>
                Beranda
            </a>

            <a href="{{ route('user.booking.index') }}"
               class="flex flex-col items-center justify-center gap-0.5 text-xs font-medium transition-colors
                      {{ request()->routeIs('user.booking.index') || request()->routeIs('user.payment.*') ? 'text-[#12B5A5]' : 'text-gray-400' }}">
                <span class="text-xl">📅</span>
                Booking
            </a>

            <a href="{{ route('user.booking.history') }}"
               class="flex flex-col items-center justify-center gap-0.5 text-xs font-medium transition-colors
                      {{ request()->routeIs('user.booking.history') || request()->routeIs('user.booking.show') ? 'text-[#12B5A5]' : 'text-gray-400' }}">
                <span class="text-xl">📖</span>
                Riwayat
            </a>

            <a href="#"
               class="flex flex-col items-center justify-center gap-0.5 text-xs font-medium text-gray-300">
                <span class="text-xl">👤</span>
                Profil
            </a>

        </div>
    </nav>

    {{-- Scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html-to-image/1.11.11/html-to-image.min.js"></script>

    @stack('scripts')

    {{-- ═══════════════════════════════
         NOTIFIKASI SCRIPT
         Pure JS — tidak ada Blade di dalam script
    ═══════════════════════════════ --}}
    <div id="notif-config"
         data-get-url="{{ route('user.notifications.get') }}"
         data-csrf="{{ csrf_token() }}"
         class="hidden">
    </div>

    <script>
    (function () {
        'use strict';

        var cfg      = document.getElementById('notif-config').dataset;
        var GET_URL  = cfg.getUrl;
        var CSRF     = cfg.csrf;

        var btn      = document.getElementById('notifBtn');
        var dropdown = document.getElementById('notifDropdown');
        var list     = document.getElementById('notifList');
        var badge    = document.getElementById('notifBadge');

        /* ── Toggle dropdown ── */
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
            if (!dropdown.classList.contains('hidden')) {
                loadNotifications();
            }
        });

        document.addEventListener('click', function () {
            dropdown.classList.add('hidden');
        });

        dropdown.addEventListener('click', function (e) {
            e.stopPropagation();
        });

        /* ── Load notifikasi ── */
        function loadNotifications() {
            fetch(GET_URL, { headers: { 'Accept': 'application/json' } })
                .then(function (res) { return res.json(); })
                .then(function (data) {

                    /* Badge unread */
                    if (data.unread > 0) {
                        badge.classList.remove('hidden');
                        badge.textContent = data.unread > 9 ? '9+' : data.unread;
                    } else {
                        badge.classList.add('hidden');
                    }

                    /* List */
                    list.innerHTML = '';

                    if (!data.data || data.data.length === 0) {
                        list.innerHTML = '<p class="text-gray-400 text-sm p-3 text-center">Tidak ada notifikasi</p>';
                        return;
                    }

                    data.data.forEach(function (n) {
                        var div  = document.createElement('div');
                        div.className = 'p-3 mb-1 rounded-xl border cursor-pointer transition hover:bg-gray-50 '
                                      + (n.is_read ? 'bg-white border-gray-100' : 'bg-[#E6F7F5] border-[#12B5A5]');

                        var title = document.createElement('p');
                        title.className   = 'font-semibold text-gray-800 text-sm';
                        title.textContent = n.title;

                        var msg = document.createElement('p');
                        msg.className   = 'text-xs text-gray-500 mt-0.5';
                        msg.textContent = n.message;

                        div.appendChild(title);
                        div.appendChild(msg);

                        div.addEventListener('click', function () {
                            readAndRedirect(n.id, '/user/notifications/' + n.id);
                        });

                        list.appendChild(div);
                    });
                })
                .catch(function (e) {
                    console.error('Notif error:', e);
                    list.innerHTML = '<p class="text-red-400 text-sm p-3">Gagal memuat notifikasi.</p>';
                });
        }

        /* ── Mark as read & redirect ── */
        function readAndRedirect(id, url) {
            fetch('/user/notifications/read/' + id, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' }
            }).finally(function () {
                window.location.href = url;
            });
        }

        /* ── Auto refresh tiap 30 detik ── */
        setInterval(loadNotifications, 30000);

        /* ── Load awal (badge saja, dropdown masih tersembunyi) ── */
        loadNotifications();

    }());
    </script>

</body>
</html>