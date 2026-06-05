@extends('layouts.user')

@section('title', 'Ulasan Pesanan')

@section('content')

<div class="max-w-xl mx-auto">

    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <div class="bg-[#12B5A5] text-white text-center py-4">

            <p class="text-xs">
                ULASAN PESANAN
            </p>

            <p class="text-sm">
                {{ $booking->reservation_code }}
            </p>

        </div>

        <div class="p-6">

            <h2 class="text-center text-xl font-semibold mb-6">
                LAPANGAN ARUNG FUTSAL
            </h2>

            <form
                action="{{ route('user.review.store', $booking) }}"
                method="POST">

                @csrf

                <input
                    type="hidden"
                    name="rating"
                    id="rating"
                    value="0">

                <div class="flex justify-center gap-2 mb-6">

                    @for($i=1; $i<=5; $i++)

                    <button
                        type="button"
                        class="star text-5xl text-gray-300"
                        data-value="{{ $i }}">
                        ★
                    </button>

                    @endfor

                </div>

                <textarea
                    name="comment"
                    rows="4"
                    placeholder="Berikan ulasan anda..."
                    class="w-full bg-gray-100 rounded-xl p-4 mb-5"></textarea>

                <div class="grid grid-cols-2 gap-3">

                    <a
                        href="{{ route('user.booking.history') }}"
                        class="text-center py-3 bg-gray-100 rounded-xl">
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="bg-[#12B5A5] text-white rounded-xl">
                        Kirim Ulasan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>

const stars = document.querySelectorAll('.star');
const ratingInput = document.getElementById('rating');

stars.forEach(star => {

    star.addEventListener('click', function() {

        const value = this.dataset.value;

        ratingInput.value = value;

        stars.forEach((s,index) => {

            if(index < value){
                s.classList.remove('text-gray-300');
                s.classList.add('text-yellow-400');
            } else {
                s.classList.remove('text-yellow-400');
                s.classList.add('text-gray-300');
            }

        });

    });

});

</script>
@endpush