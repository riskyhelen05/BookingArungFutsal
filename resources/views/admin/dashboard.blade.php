@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')

    {{-- Stat cards --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        @php
            $stats = [
                ['label' => 'Menunggu',     'count' => $counts['menunggu'],     'color' => 'text-amber-500',   'bg' => 'bg-amber-50',  'border' => 'border-amber-200'],
                ['label' => 'Dikonfirmasi', 'count' => $counts['dikonfirmasi'], 'color' => 'text-[#1ABC9C]',   'bg' => 'bg-[#E8FAF5]', 'border' => 'border-[#1ABC9C]/30'],
                ['label' => 'Ditolak',      'count' => $counts['ditolak'],      'color' => 'text-red-500',     'bg' => 'bg-red-50',    'border' => 'border-red-200'],
            ];
        @endphp
        @foreach($stats as $stat)
        <div class="bg-white rounded-2xl border {{ $stat['border'] }} p-4">
            <p class="text-xs text-[#6B7280] mb-1">{{ $stat['label'] }}</p>
            <p class="text-2xl font-bold {{ $stat['color'] }}">{{ $stat['count'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Search + Tab --}}
    <div class="bg-white rounded-2xl border border-[#E2E8F0] overflow-hidden">

        {{-- Search --}}
        <div class="p-4 border-b border-[#E2E8F0]">
            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex gap-3">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-[#9CA3AF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Cari berdasarkan nama atau ID pendaftar..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-[#E2E8F0] bg-[#F9FAFB] text-sm
                               focus:outline-none focus:ring-2 focus:ring-[#1ABC9C] focus:border-transparent transition">
                </div>
                <button type="submit"
                    class="bg-[#1ABC9C] text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-[#0F9E82] transition">
                    Cari
                </button>
            </form>
        </div>

        {{-- Tab --}}
        <div class="flex border-b border-[#E2E8F0] px-4">
            @foreach(['menunggu' => 'Menunggu', 'dikonfirmasi' => 'Dikonfirmasi', 'ditolak' => 'Ditolak'] as $key => $label)
            <a href="{{ route('admin.dashboard', ['tab' => $key, 'search' => $search]) }}"
                class="px-4 py-3 text-sm font-medium border-b-2 transition -mb-px
                       {{ $tab === $key
                          ? 'border-[#1ABC9C] text-[#1ABC9C]'
                          : 'border-transparent text-[#6B7280] hover:text-[#1A1A2E]' }}">
                {{ $label }}
                <span class="ml-1.5 px-2 py-0.5 rounded-full text-xs
                             {{ $tab === $key ? 'bg-[#E8FAF5] text-[#0F9E82]' : 'bg-[#F1F5F9] text-[#6B7280]' }}">
                    {{ $counts[$key] }}
                </span>
            </a>
            @endforeach
        </div>

        {{-- List booking --}}
        <div class="divide-y divide-[#E2E8F0]">
            @forelse($bookings as $booking)
            <div class="p-4 hover:bg-[#F9FAFB] transition">
                <div class="flex items-start justify-between gap-4">
                    {{-- Avatar + Info --}}
                    <div class="flex items-start gap-3 flex-1 min-w-0">
                        <div class="w-10 h-10 bg-[#E8FAF5] rounded-full flex items-center justify-center shrink-0">
                            <span class="text-[#0F9E82] font-semibold text-sm">
                                {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                            </span>
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-[#1A1A2E] text-sm">{{ $booking->user->name }}</p>
                            <p class="text-xs text-[#6B7280]">{{ $booking->reservation_code }}</p>
                            <div class="flex flex-wrap gap-x-4 gap-y-1 mt-1.5 text-xs text-[#6B7280]">
                                <span>📅 {{ $booking->booking_date->format('d M Y') }}</span>
                                <span>🏟 {{ $booking->field->name }}</span>
                                <span>🕐 {{ $booking->start_time }} - {{ $booking->end_time }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Status badge + Tombol lihat --}}
                    <div class="flex flex-col items-end gap-2 shrink-0">
                        @if($booking->status === 'waiting_confirmation')
                            <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full">Menunggu</span>
                        @elseif($booking->status === 'confirmed')
                            <span class="px-3 py-1 bg-[#E8FAF5] text-[#0F9E82] text-xs font-semibold rounded-full">Dikonfirmasi</span>
                        @elseif($booking->status === 'cancelled')
                            <span class="px-3 py-1 bg-red-100 text-red-600 text-xs font-semibold rounded-full">Ditolak</span>
                        @endif

                        <a href="{{ route('admin.booking.show', $booking) }}"
                            class="flex items-center gap-1 bg-[#1ABC9C] hover:bg-[#0F9E82] text-white
                                   text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                            Lihat
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="py-16 text-center">
                <div class="w-16 h-16 bg-[#F1F5F9] rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-[#9CA3AF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-[#6B7280] text-sm">Belum ada booking yang {{ $tab }}</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($bookings->hasPages())
        <div class="px-4 py-3 border-t border-[#E2E8F0]">
            {{ $bookings->appends(['tab' => $tab, 'search' => $search])->links() }}
        </div>
        @endif

    </div>

@endsection