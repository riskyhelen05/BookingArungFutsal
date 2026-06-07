@extends('layouts.user')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="p-6 lg:p-8 max-w-2xl mx-auto">

    {{-- Step indicator --}}
    <div class="flex items-center gap-2 mb-8 animate-fade-up">
        @foreach([['done'=>true,'label'=>'Pilih Jadwal'],['done'=>true,'label'=>'Pembayaran'],['done'=>true,'label'=>'Selesai']] as $step)
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-full {{ $step['done'] ? 'bg-brand-500 shadow' : 'bg-gray-200' }} flex items-center justify-center">
                @if($step['done'])
                <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                @endif
            </div>
            <span class="text-xs font-semibold {{ $step['done'] ? 'text-brand-700' : 'text-gray-400' }} hidden sm:block">{{ $step['label'] }}</span>
        </div>
        @if(!$loop->last)
        <div class="step-line done"></div>
        @endif
        @endforeach
    </div>

    {{-- Success card --}}
    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden animate-pop" style="animation-delay:.1s">

        {{-- Green hero --}}
        <div class="bg-gradient-to-br from-brand-500 to-brand-700 px-8 pt-10 pb-8 text-center text-white">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/20 backdrop-blur mb-4 shadow-xl animate-pop" style="animation-delay:.22s">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-xl font-extrabold tracking-tight">Pembayaran Berhasil Dikirim!</h1>
            <p class="mt-1.5 text-brand-100 text-sm">
                Kamu akan mendapat notifikasi ketika booking sudah disetujui admin.
            </p>
        </div>

        {{-- Detail --}}
        <div class="px-7 py-6">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-1 h-5 bg-brand-500 rounded-full"></div>
                <h2 class="font-bold text-gray-800 text-sm">Ringkasan Booking</h2>
            </div>

            <div class="space-y-2.5 text-sm">
                @php
                    $rows = [
                        'No. Referensi' => $booking->reservation_code,
                        'Nama Pemesan'  => Auth::user()->name,
                        'Tanggal'       => \Carbon\Carbon::parse($booking->booking_date)->isoFormat('D MMMM YYYY'),
                        'Lapangan'      => $booking->field->name ?? '–',
                        'Jam'           => \Carbon\Carbon::parse($booking->start_time)->format('H:i') . ' – ' . \Carbon\Carbon::parse($booking->end_time)->format('H:i'),
                        'Durasi'        => $booking->duration_hours . ' Jam',
                        'Harga'         => 'Rp ' . number_format($booking->price_per_hour, 0, ',', '.') . '/jam',
                    ];
                @endphp
                @foreach($rows as $label => $value)
                <div class="flex justify-between gap-4 py-2 {{ !$loop->last ? 'border-b border-dashed border-gray-100' : '' }}">
                    <span class="text-gray-400 flex-shrink-0">{{ $label }}</span>
                    <span class="font-semibold text-gray-800 text-right {{ $label === 'No. Referensi' ? 'font-mono text-brand-700 text-xs' : '' }}">{{ $value }}</span>
                </div>
                @endforeach

                <div class="mt-3 bg-brand-50 rounded-xl px-4 py-3.5 flex justify-between items-center">
                    <span class="font-bold text-gray-900 text-sm">Total Pembayaran</span>
                    <span class="font-extrabold text-brand-600 text-xl">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Status note --}}
            <div class="mt-4 flex items-center gap-2 bg-amber-50 border border-amber-100 rounded-xl px-4 py-3">
                <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                <p class="text-xs text-amber-700">Status: <strong>Menunggu Konfirmasi Admin</strong> · Diproses dalam 1×24 jam</p>
            </div>

            {{-- Actions --}}
            <div class="mt-6 flex flex-col sm:flex-row gap-3">
                <a href="{{ route('user.beranda') }}"
                   class="flex-1 flex items-center justify-center gap-2 bg-brand-500 hover:bg-brand-600 active:scale-95 text-white font-bold py-3 rounded-xl shadow-md shadow-brand-200/50 transition-all text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Beranda
                </a>
                <a href="{{ route('user.booking.history') }}"
                   class="flex-1 flex items-center justify-center gap-2 border border-gray-200 hover:border-brand-300 hover:bg-brand-50 text-gray-700 font-semibold py-3 rounded-xl transition-all text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Riwayat Booking
                </a>
            </div>

        </div>
    </div>

    <div class="text-center mt-6 text-3xl animate-bounce" style="animation-delay:.5s">🎉</div>
</div>
@endsection

@push('scripts')
<script>
window.addEventListener('load', () => {
    const emojis = ['⚽','🏅','✨','🎊','🎉'];
    for (let i = 0; i < 15; i++) {
        setTimeout(() => {
            const el = document.createElement('div');
            el.textContent = emojis[Math.floor(Math.random() * emojis.length)];
            el.style.cssText = `position:fixed;top:-30px;left:${Math.random()*100}vw;font-size:${Math.random()*14+10}px;pointer-events:none;z-index:9999;animation:fall ${Math.random()*2+2}s ease forwards;`;
            document.body.appendChild(el);
            setTimeout(() => el.remove(), 4000);
        }, i * 130);
    }
});
</script>
<style>@keyframes fall { to { transform: translateY(110vh) rotate(360deg); opacity: 0; } }</style>
@endpush