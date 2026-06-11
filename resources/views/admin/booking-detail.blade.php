@extends('layouts.admin')

@section('title', 'Detail Booking')
@section('page-title', 'Detail Booking')

@section('content')

<div class="max-w-2xl mx-auto">

    {{-- Back --}}
    <a href="{{ route('admin.dashboard') }}"
        class="inline-flex items-center gap-2 text-sm text-[#6B7280] hover:text-[#1A1A2E] mb-5 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Dashboard
    </a>

    {{-- Info User --}}
    <div class="bg-white rounded-2xl border border-[#E2E8F0] p-5 mb-4">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 bg-[#E8FAF5] rounded-full flex items-center justify-center">
                <span class="text-[#0F9E82] font-bold text-base">
                    {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                </span>
            </div>
            <div>
                <p class="font-semibold text-[#1A1A2E]">{{ $booking->user->name }}</p>
                <p class="text-sm text-[#6B7280]">{{ $booking->user->phone }}</p>
            </div>
        </div>
    </div>

    {{-- Ringkasan Booking --}}
    <div class="bg-white rounded-2xl border border-[#E2E8F0] p-5 mb-4">
        <h3 class="font-semibold text-[#1A1A2E] mb-4">Ringkasan Booking</h3>
        <div class="space-y-3">
            @php
                $rows = [
                    'Nama Pemesan'    => $booking->user->name,
                    'Tanggal'         => $booking->booking_date->format('d M Y'),
                    'Lapangan'        => $booking->field->name,
                    'Jam'             => $booking->start_time . ' - ' . $booking->end_time,
                    'Durasi'          => $booking->duration_hours . ' Jam',
                    'Harga'           => 'Rp ' . number_format($booking->price_per_hour, 0, ',', '.') . '/jam',
                ];
            @endphp
            @foreach($rows as $label => $value)
            <div class="flex justify-between items-center text-sm">
                <span class="text-[#6B7280]">{{ $label }}</span>
                <span class="text-[#1A1A2E] font-medium">{{ $value }}</span>
            </div>
            @endforeach
            <div class="border-t border-[#E2E8F0] pt-3 flex justify-between items-center">
                <span class="text-sm font-semibold text-[#1A1A2E]">Total Pembayaran</span>
                <span class="text-[#1ABC9C] font-bold text-base">
                    Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Bukti Transfer --}}
    @if($booking->payment)
    <div class="bg-white rounded-2xl border border-[#E2E8F0] p-5 mb-4">
        <h3 class="font-semibold text-[#1A1A2E] mb-4">Bukti Transfer</h3>
        <img src="{{ asset('storage/' . $booking->payment->proof_image_url) }}"
            alt="Bukti Transfer"
            class="w-full rounded-xl border border-[#E2E8F0] object-contain max-h-96 cursor-pointer"
            onclick="openImageModal(this.src)">
    </div>
    @endif

    {{-- Alasan tolak (jika sudah ditolak) --}}
    @if($booking->payment?->rejection_reason)
    <div class="bg-red-50 border border-red-200 rounded-2xl p-4 mb-4">
        <p class="text-sm font-semibold text-red-700 mb-1">Alasan Penolakan</p>
        <p class="text-sm text-red-600">{{ $booking->payment->rejection_reason }}</p>
    </div>
    @endif

    {{-- Action buttons --}}
    @if($booking->status === 'waiting_confirmation')
    <div class="flex gap-3">
        {{-- Tolak --}}
        <button onclick="openRejectModal()"
            class="flex-1 border-2 border-red-400 text-red-500 hover:bg-red-50 font-semibold
                   py-3 rounded-xl transition text-sm active:scale-[0.98]">
            Tolak
        </button>
        {{-- Verifikasi --}}
        <button onclick="openVerifyModal()"
            class="flex-1 bg-[#1ABC9C] hover:bg-[#0F9E82] text-white font-semibold
                   py-3 rounded-xl transition text-sm active:scale-[0.98]">
            Verifikasi
        </button>
    </div>

    @elseif($booking->status === 'confirmed')
    <div class="bg-[#E8FAF5] border border-[#1ABC9C]/30 rounded-2xl py-4 text-center">
        <p class="text-[#0F9E82] font-semibold text-sm flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            Berhasil Diverifikasi
        </p>
        @if($booking->payment?->verified_at)
        <p class="text-xs text-[#6B7280] mt-1">
            {{ $booking->payment->verified_at->format('d M Y, H:i') }} WIB
        </p>
        @endif
    </div>

    @elseif($booking->status === 'cancelled')
    <div class="bg-red-50 border border-red-200 rounded-2xl py-4 text-center">
        <p class="text-red-600 font-semibold text-sm flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            Pembayaran Ditolak
        </p>
    </div>
    @endif

</div>

{{-- Modal Verifikasi --}}
<div id="verify-modal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm text-center">
        <div class="w-14 h-14 bg-[#E8FAF5] rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-[#1ABC9C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h3 class="font-bold text-[#1A1A2E] text-lg mb-2">Konfirmasi Penerimaan</h3>
        <p class="text-sm text-[#6B7280] mb-6">
            Apakah anda yakin untuk memverifikasi dan menerima pembayaran booking tersebut?
        </p>
        <div class="flex gap-3">
            <button onclick="closeVerifyModal()"
                class="flex-1 border-2 border-[#E2E8F0] text-[#6B7280] hover:bg-[#F1F5F9]
                       font-semibold py-2.5 rounded-xl transition text-sm">
                Tidak
            </button>
            <form action="{{ route('admin.booking.verify', $booking) }}" method="POST" class="flex-1">
                @csrf
                @method('PATCH')
                <button type="submit"
                    class="w-full bg-[#1ABC9C] hover:bg-[#0F9E82] text-white font-semibold
                           py-2.5 rounded-xl transition text-sm">
                    Ya
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Modal Tolak --}}
<div id="reject-modal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm">
        <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <h3 class="font-bold text-[#1A1A2E] text-lg mb-2 text-center">Konfirmasi Penolakan</h3>
        <p class="text-sm text-[#6B7280] mb-4 text-center">
            Apakah anda yakin untuk menolak pembayaran booking tersebut?
        </p>
        <form action="{{ route('admin.booking.reject', $booking) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label class="block text-sm font-medium text-[#1A1A2E] mb-1.5">
                    Keterangan <span class="text-red-500">*</span>
                </label>
                <textarea name="rejection_reason" rows="3"
                    placeholder="Contoh: Jumlah pembayaran tidak sesuai dengan tagihan"
                    class="w-full px-4 py-3 rounded-xl border border-[#E2E8F0] bg-[#F9FAFB] text-sm
                           focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent
                           resize-none transition"></textarea>
                @error('rejection_reason')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeRejectModal()"
                    class="flex-1 border-2 border-[#E2E8F0] text-[#6B7280] hover:bg-[#F1F5F9]
                           font-semibold py-2.5 rounded-xl transition text-sm">
                    Tidak
                </button>
                <button type="submit"
                    class="flex-1 bg-red-500 hover:bg-red-600 text-white font-semibold
                           py-2.5 rounded-xl transition text-sm">
                    Ya, Tolak
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal gambar fullscreen --}}
<div id="image-modal" class="fixed inset-0 bg-black/80 z-50 hidden flex items-center justify-center p-4"
    onclick="closeImageModal()">
    <img id="modal-image" src="" alt="Bukti Transfer"
        class="max-w-full max-h-full rounded-xl object-contain">
</div>

@endsection

@push('scripts')
<script>
function openVerifyModal()  { document.getElementById('verify-modal').classList.remove('hidden'); }
function closeVerifyModal() { document.getElementById('verify-modal').classList.add('hidden'); }
function openRejectModal()  { document.getElementById('reject-modal').classList.remove('hidden'); }
function closeRejectModal() { document.getElementById('reject-modal').classList.add('hidden'); }

function openImageModal(src) {
    document.getElementById('modal-image').src = src;
    document.getElementById('image-modal').classList.remove('hidden');
}
function closeImageModal() {
    document.getElementById('image-modal').classList.add('hidden');
}
</script>
@endpush