<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Field;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\BookingExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
public function index(Request $request)
{
    $period = $request->period ?? 'today';

    $startDate = $request->start_date;
    $endDate = $request->end_date;

$query = $this->getFilteredBookings(
    $period,
    $startDate,
    $endDate
);

    $totalBooking = (clone $query)->count();

    $bookingBerhasil = (clone $query)
    ->whereIn('status', ['confirmed', 'completed'])
    ->count();

    $totalPendapatan = (clone $query)
        ->whereIn('status', ['confirmed', 'completed'])
        ->sum('total_amount');
    $fieldCount = Field::count();

$days = match ($period) {

    'today' => 1,

    'yesterday' => 1,

    'last_7_days' => 7,

    'last_30_days' => 30,

    'this_month' => now()->day,

    default => 1,
};
// Arung Futsal beroperasi 12 jam per hari (08.00–20.00)
$slotPerHari = 12;

$totalSlot = $fieldCount * $slotPerHari * $days;

    $slotTerisi = (clone $query)
    ->whereIn('status', ['confirmed', 'completed'])
    ->sum('duration_hours');

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
    ->get();

$statusData = (clone $query)
    ->select('status', DB::raw('COUNT(*) as total'))
    ->groupBy('status')
    ->pluck('total', 'status');

    return view(
        'admin.laporan.index',
compact(
    'period',
    'startDate',
    'endDate',
    'totalBooking',
    'bookingBerhasil',
    'totalPendapatan',
    'persentaseTerisi',
    'persentaseTersedia',
    'fieldRevenue',
    'recentBookings',
    'statusData'
)
    );
}
public function exportCsv(Request $request)
{
    $period = $request->period ?? 'today';

    $startDate = $request->start_date;
    $endDate = $request->end_date;

        $bookings = $this->getFilteredBookings(
        $period,
        $startDate,
        $endDate
    )
    ->with(['user', 'field'])
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
public function exportPdf(Request $request)
{
    $period = $request->period ?? 'today';

    $startDate = $request->start_date;
    $endDate = $request->end_date;

    $bookings = $this->getFilteredBookings(
        $period,
        $startDate,
        $endDate
    )
    ->with(['user', 'field'])
    ->latest()
    ->get();

    $pdf = Pdf::loadView(
        'admin.laporan.pdf',
        compact('bookings', 'period')
    );

    return $pdf->download('laporan-booking.pdf');
}
public function exportExcel(Request $request)
{
    $period = $request->period ?? 'today';

    $startDate = $request->start_date;
    $endDate = $request->end_date;

    $bookings = $this->getFilteredBookings(
        $period,
        $startDate,
        $endDate
    )
    ->with(['user', 'field'])
    ->latest()
    ->get();

    return Excel::download(
        new BookingExport($bookings),
        'laporan-booking.xlsx'
    );
}
private function getFilteredBookings(
    $period,
    $startDate = null,
    $endDate = null
)
{
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

        case 'custom':
            if ($startDate && $endDate) {
            $query->whereBetween(
            'booking_date',
            [$startDate, $endDate]
        );
    }

    break;

        default:
            $query->whereDate('booking_date', today());
            break;
    }

    return $query;
}
}