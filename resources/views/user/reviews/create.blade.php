@extends('layouts.user')

@section('title', 'Berikan Ulasan')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-4">
        Berikan Ulasan ⭐
    </h2>

    <form method="POST"
          action="{{ route('user.review.store', $booking) }}">
        @csrf

        <label class="block mb-2">
            Rating
        </label>

        <select
            name="rating"
            class="w-full border rounded-lg p-2 mb-4">

            <option value="5">⭐⭐⭐⭐⭐</option>
            <option value="4">⭐⭐⭐⭐</option>
            <option value="3">⭐⭐⭐</option>
            <option value="2">⭐⭐</option>
            <option value="1">⭐</option>

        </select>

        <label class="block mb-2">
            Komentar
        </label>

        <textarea
            name="comment"
            rows="4"
            class="w-full border rounded-lg p-2"></textarea>

        <button
            type="submit"
            class="mt-4 bg-[#12B5A5] text-white px-5 py-2 rounded-lg">

            Kirim Ulasan
        </button>

    </form>

</div>

@endsection