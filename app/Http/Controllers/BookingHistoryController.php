<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\ActivityLog;

class BookingHistoryController extends Controller
{
    public function index()
{
    $activeBookings = Booking::with(['field', 'payment'])
        ->where('user_id', Auth::id())
        ->whereIn('status', [
            'pending',
            'waiting_confirmation',
            'confirmed'
        ])
        ->latest()
        ->get();

    $historyBookings = Booking::with([
    'field',
    'payment',
    'review'
])
        ->whereIn('status', [
            'completed',
            'cancelled'
        ])
        ->where('user_id', Auth::id())
        ->latest()
        ->get();

    return view('user.bookings.history', compact(
        'activeBookings',
        'historyBookings'
    ));
}

    public function show(Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);

        $booking->load(['field', 'payment']);

        return view('user.bookings.detail', compact('booking'));
    }

    public function qr(Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);

        return view('user.bookings.qr', compact('booking'));
    }

    public function cancelForm(Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);

        return view('user.bookings.cancel', compact('booking'));
    }

public function cancel(Request $request, Booking $booking)
{
    abort_if($booking->user_id !== Auth::id(), 403);

    DB::transaction(function () use ($booking) {

        $booking->update([
            'status' => 'cancelled'
        ]);

        Notification::create([
            'user_id'    => $booking->user_id,
            'booking_id' => $booking->id,
            'title'      => 'Booking Dibatalkan',
            'message'    => 'Booking '
                . $booking->reservation_code
                . ' berhasil dibatalkan.',
            'type'       => 'booking_cancelled',
        ]);

        ActivityLog::record(
            action: 'booking.cancelled',
            description: 'User membatalkan booking '
                . $booking->reservation_code,
            subjectType: 'Booking',
            subjectId: $booking->id,
        );

    });

    return redirect()->route(
        'user.booking.cancel.success',
        $booking
    );
}

public function cancelSuccess(Booking $booking)
{
    abort_if($booking->user_id !== Auth::id(), 403);

    return view('user.bookings.cancel-success', compact('booking'));
}
}