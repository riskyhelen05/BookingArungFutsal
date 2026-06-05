<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Arung Futsal')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#E8FAF5] min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="hidden md:flex flex-col w-64 bg-white shadow-lg">
        <div class="p-6 font-bold text-xl text-[#12B5A5]">
            Arung Futsal
        </div>

        <nav class="flex flex-col gap-2 px-4">
            <a href="{{ route('user.beranda') }}"
               class="px-4 py-2 rounded-lg bg-[#E6F7F5] text-[#12B5A5] font-medium">
                🏠 Beranda
            </a>

            <a href="#" class="px-4 py-2 rounded-lg hover:bg-gray-100">
                📅 Booking
            </a>

            <a href="{{ route('user.booking.history') }}"
               class="px-4 py-2 rounded-lg hover:bg-gray-100">
                📖 Riwayat
            </a>

            <a href="#" class="px-4 py-2 rounded-lg hover:bg-gray-100">
                👤 Profil
            </a>
        </nav>

        <div class="mt-auto p-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full bg-red-500 text-white py-2 rounded-lg">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col">

        {{-- TOPBAR --}}
        <header class="bg-white shadow p-4 flex justify-between items-center relative">

            <h1 class="font-semibold text-lg">
                @yield('title')
            </h1>

            {{-- 🔔 NOTIF --}}
            <div class="relative">
                <button id="notifBtn" class="relative text-2xl">
                    🔔
                    <span id="notifBadge"
                          class="hidden absolute -top-2 -right-2 bg-red-500 text-white text-xs px-1 rounded-full">
                    </span>
                </button>

                <div id="notifDropdown"
                     class="hidden absolute right-0 mt-2 w-80 bg-white shadow-lg rounded-xl p-3 z-50 max-h-96 overflow-y-auto">

                    <h4 class="font-bold mb-2">Notifikasi</h4>

                    <div id="notifList">
                        <p class="text-gray-400 text-sm">Loading...</p>
                    </div>

                </div>
            </div>

        </header>

        {{-- CONTENT --}}
        <main class="flex-1 p-6 pb-24 md:pb-6">
            @yield('content')
        </main>

    </div>

    {{-- MOBILE NAV --}}
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t shadow-lg">
        <div class="grid grid-cols-4 h-16">

            <a href="{{ route('user.beranda') }}"
               class="flex flex-col items-center justify-center text-[#12B5A5]">
                🏠 <span class="text-xs mt-1">Beranda</span>
            </a>

            <a href="#" class="flex flex-col items-center text-gray-400">
                📅 <span class="text-xs mt-1">Booking</span>
            </a>

            <a href="{{ route('user.booking.history') }}"
               class="flex flex-col items-center text-gray-400">
                📖 <span class="text-xs mt-1">Riwayat</span>
            </a>

            <a href="#" class="flex flex-col items-center text-gray-400">
                👤 <span class="text-xs mt-1">Profil</span>
            </a>

        </div>
    </nav>

</body>

<script>
const btn = document.getElementById('notifBtn');
const dropdown = document.getElementById('notifDropdown');
const list = document.getElementById('notifList');
const badge = document.getElementById('notifBadge');

// toggle dropdown
btn.addEventListener('click', function (e) {
    e.stopPropagation();
    dropdown.classList.toggle('hidden');
});

// klik luar nutup dropdown
document.addEventListener('click', function () {
    dropdown.classList.add('hidden');
});

// 🔥 LOAD NOTIFICATIONS
async function loadNotifications() {
    try {
        const res = await fetch("{{ route('user.notifications.get') }}"); // ✅ FIX ROUTE
        const data = await res.json();

        // badge
        if (data.unread > 0) {
            badge.classList.remove('hidden');
            badge.innerText = data.unread;
        } else {
            badge.classList.add('hidden');
        }

        // clear list
        list.innerHTML = '';

        if (!data.data || data.data.length === 0) {
            list.innerHTML = '<p class="text-gray-400 text-sm">Tidak ada notifikasi</p>';
            return;
        }

        data.data.forEach(n => {
    list.innerHTML += `
        <div onclick="readNotif('${n.id}', '${n.url}')"
             class="p-2 rounded-lg hover:bg-gray-100 cursor-pointer ${n.is_read ? '' : 'bg-gray-50'}">
            <p class="font-semibold">${n.title}</p>
            <p class="text-sm text-gray-500">${n.message}</p>
        </div>
    `;
});

    } catch (e) {
        console.error('Notif error:', e);
    }
}

// 🔥 READ + REDIRECT
async function readNotif(id, url) {
    await fetch(`/user/notifications/read/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    window.location.href = url;
}

// auto refresh
setInterval(loadNotifications, 5000);

// first load
loadNotifications();
</script>
</html>