<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;

class ScannerController extends Controller
{
    // Halaman utama scanner
    public function index()
    {
        return view('admin.scanner');
    }

    // Proses hasil scan QR — cari booking by reservation_code
    public function scan(string $code)
    {
        $booking = Booking::with(['user', 'field'])
            ->where('reservation_code', $code)
            ->first();

        if (!$booking) {
            return view('admin.scanner', [
                'scanned' => true,
                'valid'   => false,
                'message' => 'QR Code tidak ditemukan.',
            ]);
        }

        $isValid = $booking->status === 'confirmed';

        return view('admin.scanner', [
            'scanned' => true,
            'valid'   => $isValid,
            'booking' => $booking,
            'message' => $isValid
                ? 'Tiket Valid'
                : 'Tiket tidak valid — status: ' . $booking->status,
        ]);
    }

    // Konfirmasi kehadiran
public function checkIn(Booking $booking)
{
    DB::transaction(function () use ($booking) {

        $booking->update([
            'checked_in_at' => now(),
            'status'        => 'completed',
        ]);

        Notification::create([
            'user_id'    => $booking->user_id,
            'booking_id' => $booking->id,
            'title'      => 'Check-In Berhasil',
            'message'    => 'Kehadiran untuk booking '
                . $booking->reservation_code
                . ' berhasil dikonfirmasi.',
            'type' => 'booking_success'
        ]);

        ActivityLog::record(
            action: 'booking.checkin',
            description: 'Admin mengkonfirmasi kehadiran booking '
                . $booking->reservation_code,
            subjectType: 'Booking',
            subjectId: $booking->id,
        );

    });

    return redirect()
        ->route('admin.scanner')
        ->with(
            'success',
            'Kehadiran ' . $booking->user->name . ' berhasil dikonfirmasi.'
        );
}
}