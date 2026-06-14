<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminBookingController extends Controller
{
    // Dashboard — list semua booking
    public function index(Request $request)
    {
        $tab    = $request->query('tab', 'menunggu');
        $search = $request->query('search');

        $statusMap = [
            'menunggu'     => 'waiting_confirmation',
            'dikonfirmasi' => 'confirmed',
            'ditolak'      => 'cancelled',
        ];

        $status = $statusMap[$tab] ?? 'waiting_confirmation';

        $bookings = Booking::with(['user', 'field', 'payment'])
            ->where('status', $status)
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('username', 'like', "%{$search}%");
                })->orWhere('reservation_code', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        $counts = [
            'menunggu'     => Booking::where('status', 'waiting_confirmation')->count(),
            'dikonfirmasi' => Booking::where('status', 'confirmed')->count(),
            'ditolak'      => Booking::where('status', 'cancelled')->count(),
        ];

        return view('admin.dashboard', compact('bookings', 'tab', 'search', 'counts'));
    }

    // Detail booking
    public function show(Booking $booking)
    {
        $booking->load(['user', 'field', 'payment']);
        return view('admin.booking-detail', compact('booking'));
    }

    // Verifikasi pembayaran → konfirmasi booking
public function verify(Booking $booking)
{
    DB::transaction(function () use ($booking) {

        // Update payment
        $booking->payment()->update([
            'payment_status' => 'verified',
            'verified_at'    => now(),
            'verified_by'    => Auth::id(),
        ]);

        // Update booking
        $booking->update([
            'status' => 'confirmed'
        ]);

        // Notifikasi
        Notification::create([
            'user_id'    => $booking->user_id,
            'booking_id' => $booking->id,
            'title'      => 'Booking Berhasil Dikonfirmasi!',
            'message'    => 'Pembayaran kamu untuk '
                . $booking->field->name .
                ' pada '
                . $booking->booking_date->format('d M Y')
                . ' pukul '
                . $booking->start_time .
                ' telah diverifikasi.',
            'type'       => 'booking_confirmed',
        ]);

        // Activity Log
        ActivityLog::record(
            action: 'payment.verified',
            description: 'Admin memverifikasi pembayaran booking '
                . $booking->reservation_code,
            subjectType: 'Booking',
            subjectId: $booking->id,
        );

    });

    return redirect()
        ->route('admin.booking.show', $booking)
        ->with('success', 'Pembayaran berhasil diverifikasi.');
}

    // Tolak pembayaran
public function reject(Request $request, Booking $booking)
{
    $request->validate([
        'rejection_reason' => 'required|string|max:255',
    ], [
        'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
    ]);

    DB::transaction(function () use ($booking, $request) {

        $booking->payment()->update([
            'payment_status'   => 'rejected',
            'verified_at'      => now(),
            'verified_by'      => Auth::id(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        $booking->update([
            'status' => 'cancelled'
        ]);

        Notification::create([
            'user_id'    => $booking->user_id,
            'booking_id' => $booking->id,
            'title'      => 'Pembayaran Ditolak',
            'message'    => 'Pembayaran booking '
                . $booking->reservation_code
                . ' ditolak. Alasan: '
                . $request->rejection_reason,
            'type'       => 'payment_rejected',
        ]);

        ActivityLog::record(
            action: 'payment.rejected',
            description: 'Admin menolak pembayaran booking '
                . $booking->reservation_code,
            subjectType: 'Booking',
            subjectId: $booking->id,
        );

    });

    return redirect()
        ->route('admin.booking.show', $booking)
        ->with('error', 'Pembayaran ditolak.');
}
}