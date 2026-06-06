@extends('layouts.app')

@section('title', 'Detail Booking – ' . $booking->reservation_code)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">

    <div class="mb-8 animate-fade-up">
        <a href="{{ route('booking.my') }}" class="inline-flex items-center gap-1.5 text-sm text-brand-600 hover:text-brand-700 font-medium mb-3 group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
            Booking Saya
        </a>
        <h1 class="text-2xl font-extrabold text-gray-900">Detail Booking</h1>
        <p class="text-xs text-gray-400 font-mono mt-1">{{ $booking->reservation_code }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-fade-up" style="animation-delay:.08s">
        {{-- Header bar --}}
        @php
            $badge = $booking->status_badge;
            $statusColors = [
                'badge-success' => 'bg-brand-100 text-brand-700 border-brand-200',
                'badge-warning' => 'bg-amber-100 text-amber-700 border-amber-200',
                'badge-info'    => 'bg-blue-100 text-blue-700 border-blue-200',
                'badge-error'   => 'bg-red-100 text-red-700 border-red-200',
                'badge-neutral' => 'bg-gray-100 text-gray-600 border-gray-200',
            ];
            $badgeCls = $statusColors[$badge['class']] ?? 'bg-gray-100 text-gray-500';
        @endphp
        <div class="bg-gradient-to-r from-brand-500 to-brand-700 px-6 py-4 flex items-center justify-between">
            <h2 class="text-white font-bold">{{ $booking->field->name ?? '–' }}</h2>
            <span class="bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full">
                {{ $badge['label'] }}
            </span>
        </div>

        <div class="p-6 space-y-6">
            {{-- Booking info --}}
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Info Booking</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    @php
                        $info = [
                            'Tanggal'    => \Carbon\Carbon::parse($booking->booking_date)->isoFormat('dddd, D MMMM YYYY'),
                            'Jam'        => \Carbon\Carbon::parse($booking->start_time)->format('H:i') . ' – ' . \Carbon\Carbon::parse($booking->end_time)->format('H:i'),
                            'Durasi'     => $booking->duration_hours . ' Jam',
                            'Harga/Jam'  => 'Rp ' . number_format($booking->price_per_hour, 0, ',', '.'),
                        ];
                    @endphp
                    @foreach($info as $label => $val)
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 mb-1">{{ $label }}</p>
                        <p class="font-semibold text-gray-800">{{ $val }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Total --}}
            <div class="bg-brand-50 rounded-xl px-5 py-4 flex justify-between items-center">
                <span class="font-bold text-gray-900">Total Pembayaran</span>
                <span class="font-extrabold text-brand-600 text-xl">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
            </div>

            {{-- Payment info --}}
            @if($booking->payment)
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Pembayaran</h3>
                <div class="border border-gray-100 rounded-xl p-4 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Status</span>
                        @php
                            $payColors = ['pending' => 'text-amber-600', 'verified' => 'text-brand-600', 'rejected' => 'text-red-600'];
                            $payLabels = ['pending' => 'Menunggu Verifikasi', 'verified' => 'Terverifikasi', 'rejected' => 'Ditolak'];
                            $ps = $booking->payment->payment_status;
                        @endphp
                        <span class="font-semibold {{ $payColors[$ps] ?? '' }}">{{ $payLabels[$ps] ?? $ps }}</span>
                    </div>
                    @if($booking->payment->submitted_at)
                    <div class="flex justify-between">
                        <span class="text-gray-500">Dikirim</span>
                        <span class="font-medium text-gray-700">{{ $booking->payment->submitted_at->isoFormat('D MMM YYYY, HH:mm') }}</span>
                    </div>
                    @endif
                    @if($booking->payment->proof_image_url)
                    <div>
                        <p class="text-gray-500 mb-2">Bukti Pembayaran</p>
                        <a href="{{ asset('storage/' . $booking->payment->proof_image_url) }}" target="_blank">
                            <img src="{{ asset('storage/' . $booking->payment->proof_image_url) }}" alt="Bukti" class="max-h-48 rounded-xl object-contain border border-gray-100 hover:opacity-90 transition-opacity" />
                        </a>
                    </div>
                    @endif
                    @if($booking->payment->rejection_reason)
                    <div class="bg-red-50 border border-red-100 rounded-lg px-3 py-2">
                        <p class="text-xs font-semibold text-red-700 mb-1">Alasan Penolakan</p>
                        <p class="text-xs text-red-600">{{ $booking->payment->rejection_reason }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Actions --}}
            <div class="flex gap-3 pt-2">
                @if($booking->status === 'pending' && !$booking->payment)
                <a href="{{ route('payment.show', $booking->id) }}"
                   class="flex-1 flex items-center justify-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-bold py-3 rounded-xl shadow-md transition-all text-sm">
                    Upload Bukti Pembayaran
                </a>
                @elseif($booking->payment && $booking->payment->payment_status === 'rejected')
                <a href="{{ route('payment.show', $booking->id) }}"
                   class="flex-1 flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 rounded-xl shadow-md transition-all text-sm">
                    Upload Ulang Bukti
                </a>
                @endif
                <a href="{{ route('booking.my') }}"
                   class="flex-1 flex items-center justify-center gap-2 border border-gray-200 hover:border-brand-300 text-gray-700 font-semibold py-3 rounded-xl transition-all text-sm">
                    Kembali
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
