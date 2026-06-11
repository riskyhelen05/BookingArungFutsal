@extends('layouts.admin')

@section('title', 'Scanner Tiket')
@section('page-title', 'Scanner Tiket Masuk')

@section('content')

<div class="max-w-lg mx-auto">

    @if(!isset($scanned) || !$scanned)

    <div class="bg-white rounded-2xl border border-[#E2E8F0] overflow-hidden">

        <div class="bg-[#1ABC9C] px-6 py-5 text-center">
            <h2 class="text-white font-semibold text-lg">Scanner Tiket Masuk</h2>
            <p class="text-white/80 text-sm mt-1">Arahkan kamera ke QR code pelanggan</p>
        </div>

        <div class="p-6">

            {{-- Container QR Scanner — ini yang dipakai library --}}
            <div id="qr-reader" class="w-full rounded-2xl overflow-hidden bg-[#E8FAF5]" style="min-height: 300px;"></div>

            {{-- Status scanning --}}
            <div id="scan-status" class="hidden mt-3 text-center">
                <p class="text-sm text-[#1ABC9C] font-medium animate-pulse">🔍 Sedang memindai...</p>
            </div>

            {{-- Manual input --}}
            <div class="mt-5">
                <p class="text-xs text-[#6B7280] text-center mb-3">atau masukkan kode reservasi manual</p>
                <div class="flex gap-2">
                    <input type="text" id="manual-code"
                        placeholder="Contoh: BKK202606001"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-[#E2E8F0] bg-[#F9FAFB] text-sm
                               focus:outline-none focus:ring-2 focus:ring-[#1ABC9C] focus:border-transparent transition">
                    <button onclick="manualSearch()"
                        class="bg-[#1ABC9C] hover:bg-[#0F9E82] text-white px-4 py-2.5 rounded-xl text-sm font-medium transition">
                        Cek
                    </button>
                </div>
            </div>

            {{-- Tip --}}
            <div class="flex items-center gap-3 bg-[#E8FAF5] rounded-xl px-4 py-3 mt-4">
                <div class="w-8 h-8 bg-[#1ABC9C] rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-sm text-[#0F9E82] font-medium">Pastikan QR code terlihat jelas</p>
            </div>

            {{-- Tombol --}}
            <button id="btn-start" onclick="startScan()"
                class="w-full bg-[#1ABC9C] hover:bg-[#0F9E82] text-white font-semibold py-3.5 rounded-xl
                       transition active:scale-[0.98] text-sm mt-4 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Mulai Scan
            </button>

            <button id="btn-stop" onclick="stopScan()"
                class="hidden w-full border-2 border-red-400 text-red-500 hover:bg-red-50 font-semibold
                       py-3.5 rounded-xl transition active:scale-[0.98] text-sm mt-2">
                Stop Kamera
            </button>

        </div>
    </div>

    @else

    {{-- Hasil scan --}}
    <div class="bg-white rounded-2xl border border-[#E2E8F0] overflow-hidden">

        <div class="bg-[#1ABC9C] px-6 py-5 text-center">
            <h2 class="text-white font-semibold text-lg">Informasi Tiket</h2>
        </div>

        <div class="p-6">

            @if($valid && isset($booking))

            <div class="text-center mb-6">
                <div class="w-20 h-20 bg-[#E8FAF5] rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-10 h-10 text-[#1ABC9C]" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-[#1ABC9C] font-bold text-xl">Tiket Valid</h3>
                <p class="text-sm text-[#6B7280] mt-1">
                    Status Booking :
                    <span class="font-semibold text-[#1ABC9C]">[ Terkonfirmasi ]</span>
                </p>
            </div>

            @if($booking->checked_in_at)
            <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 mb-4 text-center">
                <p class="text-amber-700 text-sm font-semibold">
                    ⚠️ Sudah check-in: {{ \Carbon\Carbon::parse($booking->checked_in_at)->format('d M Y, H:i') }} WIB
                </p>
            </div>
            @endif

            <div class="bg-[#F9FAFB] rounded-xl border border-[#E2E8F0] p-4 mb-5">
                <p class="font-semibold text-[#1A1A2E] text-sm mb-3">Ringkasan Booking</p>
                <div class="space-y-2.5">
                    @php
                        $rows = [
                            'No Referensi' => $booking->reservation_code,
                            'Nama Pemesan' => $booking->user->name,
                            'Tanggal'      => $booking->booking_date->format('d M Y'),
                            'Lapangan'     => $booking->field->name,
                            'Jam'          => $booking->start_time . ' - ' . $booking->end_time,
                            'Durasi'       => $booking->duration_hours . ' Jam',
                            'Harga'        => 'Rp ' . number_format($booking->price_per_hour, 0, ',', '.') . '/jam',
                        ];
                    @endphp
                    @foreach($rows as $label => $value)
                    <div class="flex justify-between text-sm">
                        <span class="text-[#6B7280]">{{ $label }}</span>
                        <span class="text-[#1A1A2E] font-medium text-right">{{ $value }}</span>
                    </div>
                    @endforeach
                    <div class="border-t border-[#E2E8F0] pt-2.5 flex justify-between text-sm">
                        <span class="font-semibold text-[#1A1A2E]">Total Pembayaran</span>
                        <span class="text-[#1ABC9C] font-bold">
                            Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            @if(!$booking->checked_in_at)
            <button onclick="openCheckinModal()"
                class="w-full bg-[#1ABC9C] hover:bg-[#0F9E82] text-white font-semibold py-3.5 rounded-xl
                       transition active:scale-[0.98] text-sm">
                Verifikasi Kehadiran
            </button>
            @else
            <div class="w-full bg-[#E8FAF5] border border-[#1ABC9C]/30 rounded-xl py-3.5 text-center">
                <p class="text-[#0F9E82] font-semibold text-sm">✓ Sudah Diverifikasi</p>
            </div>
            @endif

            @else

            <div class="text-center mb-6">
                <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-10 h-10 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-red-500 font-bold text-xl">Tiket Tidak Valid</h3>
                <p class="text-sm text-[#6B7280] mt-1">{{ $message }}</p>
            </div>

            @endif

            <a href="{{ route('admin.scanner') }}"
                class="block w-full border-2 border-[#E2E8F0] text-[#6B7280] hover:bg-[#F1F5F9]
                       font-semibold py-3 rounded-xl transition text-sm text-center mt-3">
                ← Scan Ulang
            </a>

        </div>
    </div>

    @endif

</div>

{{-- Modal Konfirmasi Kehadiran --}}
@if(isset($booking) && $valid)
<div id="checkin-modal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm text-center">
        <div class="w-14 h-14 bg-[#E8FAF5] rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-[#1ABC9C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h3 class="font-bold text-[#1A1A2E] text-lg mb-2">Konfirmasi Kehadiran</h3>
        <p class="text-sm text-[#6B7280] mb-6">Apakah anda yakin untuk mengkonfirmasi kehadiran pelanggan?</p>
        <div class="flex gap-3">
            <button onclick="closeCheckinModal()"
                class="flex-1 border-2 border-[#E2E8F0] text-[#6B7280] hover:bg-[#F1F5F9]
                       font-semibold py-2.5 rounded-xl transition text-sm">
                Tidak
            </button>
            <form action="{{ route('admin.scanner.checkin', $booking) }}" method="POST" class="flex-1">
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
@endif

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>

<script>
let html5QrCode = null;
let isScanning  = false;

function startScan() {
    if (isScanning) return;

    document.getElementById('btn-start').classList.add('hidden');
    document.getElementById('btn-stop').classList.remove('hidden');
    document.getElementById('scan-status').classList.remove('hidden');

    html5QrCode = new Html5Qrcode("qr-reader");

    const config = {
        fps: 10,
        qrbox: { width: 250, height: 250 },
        aspectRatio: 1.0,
    };

    html5QrCode.start(
        { facingMode: "environment" },
        config,
        (decodedText) => {
            // Berhasil scan
            isScanning = false;
            html5QrCode.stop().then(() => {
                redirectToResult(decodedText);
            }).catch(() => {
                redirectToResult(decodedText);
            });
        },
        () => { /* abaikan error frame */ }
    ).then(() => {
        isScanning = true;
    }).catch((err) => {
        document.getElementById('btn-start').classList.remove('hidden');
        document.getElementById('btn-stop').classList.add('hidden');
        document.getElementById('scan-status').classList.add('hidden');
        alert('Gagal akses kamera. Pastikan izin kamera sudah diberikan.\n\nError: ' + err);
    });
}

function stopScan() {
    if (html5QrCode && isScanning) {
        html5QrCode.stop().catch(() => {});
    }
    isScanning = false;
    html5QrCode = null;
    document.getElementById('btn-start').classList.remove('hidden');
    document.getElementById('btn-stop').classList.add('hidden');
    document.getElementById('scan-status').classList.add('hidden');
}

function redirectToResult(code) {
    const base = "{{ url('admin/scanner/scan') }}";
    window.location.href = base + '/' + encodeURIComponent(code);
}

function manualSearch() {
    const code = document.getElementById('manual-code').value.trim();
    if (!code) {
        document.getElementById('manual-code').focus();
        return;
    }
    redirectToResult(code);
}

// Enter key pada input manual
document.getElementById('manual-code')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') manualSearch();
});

function openCheckinModal()  { document.getElementById('checkin-modal').classList.remove('hidden'); }
function closeCheckinModal() { document.getElementById('checkin-modal').classList.add('hidden'); }
</script>
@endpush