<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Field;

class LaporanController extends Controller
{
public function index(Request $request)
{
    $period = $request->period ?? 'today';

    $query = Booking::query();

    switch ($period) {

        case 'yesterday':
            $query->whereDate('booking_date', now()->subDay());
            break;

        case 'last_7_days':
            $query->whereBetween(
                'booking_date',
                [now()->subDays(6), now()]
            );
            break;

        case 'last_30_days':
            $query->whereBetween(
                'booking_date',
                [now()->subDays(29), now()]
            );
            break;

        case 'this_month':
            $query->whereMonth('booking_date', now()->month)
                  ->whereYear('booking_date', now()->year);
            break;

        default:
            $query->whereDate('booking_date', today());
            break;
    }

    $totalBooking = (clone $query)
        ->whereIn('status', ['confirmed', 'completed'])
        ->count();

    $totalPendapatan = (clone $query)
        ->whereIn('status', ['confirmed', 'completed'])
        ->sum('total_amount');

    $totalSlot = 12;

    $slotTerisi = $totalBooking;

    $persentaseTerisi = $totalSlot > 0
        ? round(($slotTerisi / $totalSlot) * 100)
        : 0;

    $persentaseTersedia = 100 - $persentaseTerisi;

    return view(
        'admin.laporan.index',
        compact(
            'period',
            'totalBooking',
            'totalPendapatan',
            'persentaseTerisi',
            'persentaseTersedia'
        )
    );
}
}