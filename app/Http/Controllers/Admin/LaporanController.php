<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Field;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

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
    // TODO: hitung berdasarkan jumlah lapangan × jumlah slot × periode
    $totalSlot = 12;

    $slotTerisi = $totalBooking;

    $persentaseTerisi = $totalSlot > 0
        ? round(($slotTerisi / $totalSlot) * 100)
        : 0;

    $persentaseTersedia = 100 - $persentaseTerisi;

$fieldRevenue = (clone $query)
    ->select(
        'field_id',
        DB::raw('SUM(total_amount) as total')
    )
    ->with('field')
    ->whereIn('status', ['confirmed', 'completed'])
    ->groupBy('field_id')
    ->orderByDesc('total')
    ->get();

$recentBookings = (clone $query)
    ->with(['user', 'field'])
    ->latest()
    ->take(5)
    ->get();

    return view(
        'admin.laporan.index',
compact(
    'period',
    'totalBooking',
    'totalPendapatan',
    'persentaseTerisi',
    'persentaseTersedia',
    'fieldRevenue',
    'recentBookings'
)
    );
}
public function exportCsv(Request $request)
{
    $bookings = Booking::with(['user', 'field'])
        ->latest()
        ->get();

    $response = new StreamedResponse(function () use ($bookings) {

        $handle = fopen('php://output', 'w');

        fputcsv($handle, [
            'Kode Reservasi',
            'Pelanggan',
            'Lapangan',
            'Tanggal',
            'Jam',
            'Total',
            'Status'
        ]);

        foreach ($bookings as $booking) {

            fputcsv($handle, [
                $booking->reservation_code,
                $booking->user->name,
                $booking->field->name,
                $booking->booking_date,
                substr($booking->start_time, 0, 5) . ' - ' .
                substr($booking->end_time, 0, 5),
                $booking->total_amount,
                $booking->status,
            ]);
        }

        fclose($handle);
    });

    $response->headers->set(
        'Content-Type',
        'text/csv'
    );

    $response->headers->set(
        'Content-Disposition',
        'attachment; filename="laporan-booking.csv"'
    );

    return $response;
}
public function exportPdf()
{
    $bookings = Booking::with(['user', 'field'])
        ->latest()
        ->get();

    $pdf = Pdf::loadView(
        'admin.laporan.pdf',
        compact('bookings')
    );

    return $pdf->download('laporan-booking.pdf');
}
}