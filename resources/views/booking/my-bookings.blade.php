@extends('layouts.app')

@section('title', 'Booking Saya')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">

    <div class="mb-8 animate-fade-up">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Booking Saya</h1>
        <p class="mt-1 text-gray-500">Riwayat dan status semua booking lapangan kamu.</p>
    </div>

    @if($bookings->isEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center animate-fade-up">
        <div class="w-16 h-16 bg-brand-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-brand-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <p class="text-gray-500 font-medium">Belum ada booking.</p>
        <a href="{{ route('booking.index') }}"
           class="mt-4 inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-semibold text-sm px-5 py-2.5 rounded-xl shadow-md transition-all">
            Booking Sekarang
        </a>
    </div>
    @else
    <div class="space-y-4">
        @foreach($bookings as $i => $booking)
        @php
            $badge = $booking->status_badge;
            $statusColors = [
                'badge-success' => 'bg-brand-100 text-brand-700 border-brand-200',
                'badge-warning' => 'bg-amber-100 text-amber-700 border-amber-200',
                'badge-info'    => 'bg-blue-100 text-blue-700 border-blue-200',
                'badge-error'   => 'bg-red-100 text-red-700 border-red-200',
                'badge-neutral' => 'bg-gray-100 text-gray-600 border-gray-200',
                'badge-ghost'   => 'bg-gray-100 text-gray-500 border-gray-200',
            ];
            $badgeCls = $statusColors[$badge['class']] ?? $statusColors['badge-ghost'];
        @endphp
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow overflow-hidden animate-fade-up"
             style="animation-delay:{{ $i * 0.05 }}s">
            <div class="flex flex-col sm:flex-row">
                {{-- Field image placeholder --}}
                <div class="sm:w-40 h-36 sm:h-auto bg-gradient-to-br from-brand-400 to-brand-700 flex-shrink-0 flex items-center justify-center">
                    @if($booking->field && $booking->field->photo_url)
                    <img src="{{ asset('storage/' . $booking->field->photo_url) }}" alt="{{ $booking->field->name }}" class="w-full h-full object-cover" />
                    @else
                    <svg class="w-10 h-10 text-white/60" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/><path d="M12 6l1.5 4.5H18l-3.75 2.73 1.43 4.27L12 14.54l-3.68 2.96 1.43-4.27L6 10.5h4.5z" fill="white"/></svg>
                    @endif
                </div>

                {{-- Content --}}
                <div class="flex-1 px-6 py-4">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="font-mono text-xs text-gray-400 mb-1">{{ $booking->reservation_code }}</p>
                            <h3 class="font-bold text-gray-900">{{ $booking->field->name ?? '–' }}</h3>
                        </div>
                        <span class="flex-shrink-0 text-xs font-semibold px-3 py-1 rounded-full border {{ $badgeCls }}">
                            {{ $badge['label'] }}
                        </span>
                    </div>

                    <div class="mt-3 grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                        <div>
                            <p class="text-gray-400 mb-0.5">Tanggal</p>
                            <p class="font-semibold text-gray-700">{{ \Carbon\Carbon::parse($booking->booking_date)->isoFormat('D MMM YYYY') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 mb-0.5">Jam</p>
                            <p class="font-semibold text-gray-700">
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-400 mb-0.5">Durasi</p>
                            <p class="font-semibold text-gray-700">{{ $booking->duration_hours }} Jam</p>
                        </div>
                        <div>
                            <p class="text-gray-400 mb-0.5">Total</p>
                            <p class="font-bold text-brand-600">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    {{-- Payment status --}}
                    @if($booking->payment)
                    <div class="mt-3">
                        @php
                            $payColors = ['pending' => 'text-amber-600', 'verified' => 'text-brand-600', 'rejected' => 'text-red-600'];
                            $payLabels = ['pending' => '⏳ Menunggu verifikasi', 'verified' => '✓ Pembayaran terverifikasi', 'rejected' => '✕ Pembayaran ditolak'];
                            $ps = $booking->payment->payment_status;
                        @endphp
                        <span class="text-xs font-medium {{ $payColors[$ps] ?? '' }}">
                            {{ $payLabels[$ps] ?? $ps }}
                        </span>
                    </div>
                    @endif

                </div>

                {{-- Actions --}}
                <div class="px-4 py-4 sm:py-0 sm:flex sm:items-center border-t sm:border-t-0 sm:border-l border-gray-100 flex-shrink-0">
                    <div class="flex sm:flex-col gap-2">
                        @if($booking->status === 'pending' && !$booking->payment)
                        <a href="{{ route('payment.show', $booking->id) }}"
                           class="inline-flex items-center gap-1.5 bg-brand-500 hover:bg-brand-600 text-white text-xs font-semibold px-3 py-2 rounded-lg transition-all whitespace-nowrap">
                            Bayar
                        </a>
                        @endif
                        <a href="{{ route('booking.show', $booking->id) }}"
                           class="inline-flex items-center gap-1.5 border border-gray-200 hover:border-brand-300 hover:text-brand-700 text-gray-600 text-xs font-semibold px-3 py-2 rounded-lg transition-all whitespace-nowrap">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($bookings->hasPages())
    <div class="mt-8 animate-fade-up">
        {{ $bookings->links() }}
    </div>
    @endif
    @endif

</div>
@endsection
