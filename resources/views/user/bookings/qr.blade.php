@extends('layouts.user')

@section('title', 'QR Booking')

@section('content')

<div class="max-w-xl mx-auto">

    <div class="bg-white rounded-3xl shadow-md p-6 md:p-8">

        {{-- HEADER --}}
        <div class="text-center mb-6">

            <h1 class="text-2xl font-bold text-[#12B5A5]">
                ARUNG FUTSAL
            </h1>

            <p class="text-sm text-gray-500 mt-2">
                Tunjukkan tiket digital ini kepada petugas saat datang.
            </p>

        </div>

        {{-- TOAST --}}
        <div
            id="successToast"
            class="hidden mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-xl text-center">
            ✅ Tiket berhasil disimpan
        </div>

        {{-- TIKET --}}
        <div
            id="ticket-download"
            class="border-2 border-dashed border-[#12B5A5] rounded-2xl p-6 bg-[#F8FFFD]">

            <div class="text-center">

                <h2 class="font-bold text-lg text-gray-800">
                    E-TICKET BOOKING
                </h2>

                <p class="text-sm text-gray-500">
                    {{ $booking->reservation_code }}
                </p>

            </div>

            <div class="my-5 border-t"></div>

            <div class="space-y-3 text-sm">

                <div class="flex justify-between">
                    <span class="text-gray-500">Lapangan</span>
                    <span class="font-medium">
                        {{ $booking->field->name }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal</span>
                    <span class="font-medium">
                        {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Jam Bermain</span>
                    <span class="font-medium">
                        {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                        -
                        {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                    </span>
                </div>

            </div>

            <div class="flex justify-center my-6">

                {!! QrCode::size(220)->generate($booking->reservation_code) !!}

            </div>

            <p class="text-center text-xs text-gray-500">
                Scan QR Code ini saat check-in
            </p>

        </div>

        {{-- ACTION BUTTON --}}
        <div class="mt-6 grid gap-3">

            <button
                id="downloadQR"
                class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl font-medium transition">

                📥 Download Tiket PNG

            </button>

            <a
                href="{{ route('user.booking.show', $booking) }}"
                class="block text-center bg-[#12B5A5] hover:bg-[#0FA293] text-white py-3 rounded-xl font-medium transition">

                📋 Detail Booking

            </a>

            <a
                href="{{ route('user.booking.history') }}"
                class="block text-center border py-3 rounded-xl font-medium hover:bg-gray-50">

                ← Kembali ke Riwayat

            </a>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>

document.getElementById('downloadQR')
.addEventListener('click', async function () {

    const ticket =
        document.getElementById('ticket-download');

    try {

        const dataUrl =
            await htmlToImage.toPng(ticket);

        const link =
            document.createElement('a');

        link.download =
            'Tiket-{{ $booking->reservation_code }}.png';

        link.href = dataUrl;

        document.body.appendChild(link);

        link.click();

        document.body.removeChild(link);

        const toast =
            document.getElementById('successToast');

        toast.classList.remove('hidden');

        setTimeout(() => {
            toast.classList.add('hidden');
        }, 30000);

    } catch (error) {

        console.error(error);

        alert('Gagal menyimpan tiket');

    }

});

</script>
@endpush