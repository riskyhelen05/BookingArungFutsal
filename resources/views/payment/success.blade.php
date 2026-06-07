@extends('layouts.user')
@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="p-6 lg:p-8 max-w-2xl">

    {{-- Steps --}}
    <div class="flex items-center gap-2 mb-8 animate-fade-up">
        @foreach([['Pilih Jadwal',true],['Pembayaran',true],['Selesai',true]] as [$label,$done])
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full flex items-center justify-center"
                 style="{{ $done ? 'background:linear-gradient(135deg,#14b8a6,#0d9488);box-shadow:0 4px 12px rgba(20,184,166,.35);' : 'background:#f3f4f6;color:#9ca3af;' }}">
                @if($done)
                <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                @endif
            </div>
            <span class="text-xs font-bold {{ $done ? 'text-brand-700' : 'text-gray-400' }} hidden sm:block">{{ $label }}</span>
        </div>
        @if(!$loop->last)<div class="step-line done"></div>@endif
        @endforeach
    </div>

    {{-- Success card --}}
    <div class="bg-white rounded-3xl overflow-hidden animate-pop" style="box-shadow:0 4px 6px rgba(0,0,0,.07),0 20px 60px rgba(0,0,0,.08);animation-delay:.08s">

        {{-- Hero --}}
        <div class="relative px-8 pt-12 pb-10 text-center overflow-hidden"
             style="background:linear-gradient(135deg,#14b8a6 0%,#0d9488 50%,#0f766e 100%);">
            {{-- Decorative circles --}}
            <div class="absolute -top-8 -right-8 w-40 h-40 rounded-full opacity-10" style="background:#fff;"></div>
            <div class="absolute -bottom-12 -left-12 w-48 h-48 rounded-full opacity-10" style="background:#fff;"></div>

            <div class="relative z-10">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-5 animate-pop"
                     style="background:rgba(255,255,255,.2);box-shadow:0 0 0 8px rgba(255,255,255,.1);animation-delay:.2s">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-extrabold text-white tracking-tight animate-fade-up" style="animation-delay:.28s">
                    Pembayaran Berhasil! 🎉
                </h1>
                <p class="mt-2 text-brand-100 text-sm animate-fade-up" style="animation-delay:.34s">
                    Kamu akan dapat notifikasi saat booking disetujui admin.
                </p>
            </div>
        </div>

        {{-- Detail --}}
        <div class="px-7 py-7">
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1 h-5 rounded-full" style="background:linear-gradient(180deg,#14b8a6,#0d9488);"></div>
                <h2 class="font-bold text-gray-800 text-sm">Ringkasan Booking</h2>
            </div>

            <div class="space-y-0">
                @php
                    $rows = [
                        'No. Referensi' => $booking->reservation_code,
                        'Nama Pemesan'  => Auth::user()->name,
                        'Tanggal'       => \Carbon\Carbon::parse($booking->booking_date)->isoFormat('D MMMM YYYY'),
                        'Lapangan'      => $booking->field->name ?? '–',
                        'Jam'           => \Carbon\Carbon::parse($booking->start_time)->format('H:i').' – '.\Carbon\Carbon::parse($booking->end_time)->format('H:i'),
                        'Durasi'        => $booking->duration_hours.' Jam',
                        'Harga'         => 'Rp '.number_format($booking->price_per_hour,0,',','.').'/ jam',
                    ];
                @endphp
                @foreach($rows as $label => $value)
                <div class="flex justify-between gap-4 py-2.5 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                    <span class="text-gray-400 text-sm flex-shrink-0">{{ $label }}</span>
                    <span class="font-bold text-gray-800 text-sm text-right {{ $label==='No. Referensi' ? 'font-mono text-brand-700 text-xs' : '' }}">{{ $value }}</span>
                </div>
                @endforeach
            </div>

            {{-- Total --}}
            <div class="mt-4 rounded-xl px-5 py-4 flex justify-between items-center"
                 style="background:linear-gradient(135deg,#f0fdf9,#ccfbef);">
                <span class="font-bold text-gray-800">Total Pembayaran</span>
                <span class="font-black text-brand-700 text-xl">Rp {{ number_format($booking->total_amount,0,',','.') }}</span>
            </div>

            {{-- Status --}}
            <div class="mt-4 flex items-center gap-3 px-4 py-3 rounded-xl" style="background:#fef9ec;border:1px solid #fde68a;">
                <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                <p class="text-xs text-amber-700 font-medium">Status: <strong>Menunggu Konfirmasi Admin</strong> · Diproses 1×24 jam</p>
            </div>

            {{-- Buttons --}}
            <div class="mt-6 flex flex-col sm:flex-row gap-3">
                <a href="{{ route('user.beranda') }}"
                   class="flex-1 flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-black text-white transition-all active:scale-95"
                   style="background:linear-gradient(135deg,#14b8a6,#0d9488);box-shadow:0 4px 16px rgba(20,184,166,.4);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Beranda
                </a>
                <a href="{{ route('user.booking.history') }}"
                   class="flex-1 flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-bold text-gray-600 border border-gray-200 hover:border-brand-300 hover:text-brand-700 transition-all">
                    Riwayat Booking
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
window.addEventListener('load',()=>{
    const em=['⚽','🏅','✨','🎊','🎉','🌟'];
    for(let i=0;i<18;i++){
        setTimeout(()=>{
            const el=document.createElement('div');
            el.textContent=em[Math.floor(Math.random()*em.length)];
            el.style.cssText=`position:fixed;top:-30px;left:${Math.random()*100}vw;font-size:${Math.random()*14+10}px;pointer-events:none;z-index:9999;animation:fall ${Math.random()*2+2}s ease forwards;`;
            document.body.appendChild(el);
            setTimeout(()=>el.remove(),4000);
        },i*110);
    }
});
</script>
<style>@keyframes fall{to{transform:translateY(110vh) rotate(360deg);opacity:0;}}</style>
@endpush