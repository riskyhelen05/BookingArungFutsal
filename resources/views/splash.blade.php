<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Arung Futsal</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#12B5A5] min-h-screen flex items-center justify-center">

    <div class="text-center">

        {{-- Logo --}}
        <div
            class="w-28 h-28 mx-auto bg-white rounded-3xl flex items-center justify-center shadow-lg animate-pulse">

            <svg
                class="w-14 h-14 text-[#12B5A5]"
                fill="currentColor"
                viewBox="0 0 24 24">

                <circle
                    cx="12"
                    cy="12"
                    r="10"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"/>

                <circle
                    cx="12"
                    cy="12"
                    r="3.5"/>

            </svg>

        </div>

        <h1 class="mt-6 text-3xl font-bold text-white">
            Arung Futsal
        </h1>

        <p class="mt-2 text-teal-100">
            Booking Lapangan Jadi Lebih Mudah
        </p>

        <div class="mt-8">

            <div
                class="w-8 h-8 border-4 border-white border-t-transparent rounded-full animate-spin mx-auto">
            </div>

        </div>

    </div>

    <script>
        setTimeout(() => {

            @auth
                window.location.href = "{{ route('user.beranda') }}";
            @else
                window.location.href = "{{ route('login') }}";
            @endauth

        }, 2500);
    </script>

</body>
</html>