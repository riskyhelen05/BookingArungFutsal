@extends('layouts.user')

@section('title', 'Terima Kasih')

@section('content')

<div class="max-w-md mx-auto">

    <div class="bg-[#12B5A5] text-white rounded-3xl p-10 text-center">

        <div class="w-28 h-28 bg-white rounded-full mx-auto flex items-center justify-center text-6xl text-[#12B5A5] mb-8">
            ✓
        </div>

        <h1 class="text-3xl font-bold mb-4">
            TERIMA KASIH!
        </h1>

        <p class="mb-10">
            Ulasan Anda sangat berarti bagi kami.
        </p>

        <div class="bg-black/20 rounded-xl py-3 text-sm">
            Halaman akan kembali otomatis...
        </div>

    </div>

</div>

<script>
setTimeout(() => {
    window.location.href =
        "{{ route('user.booking.history') }}";
}, 3000);
</script>

@endsection