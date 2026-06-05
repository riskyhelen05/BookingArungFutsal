<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    $historyBookings = Booking::with(['field', 'payment'])
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

        $booking->update([
            'status' => 'cancelled'
        ]);

        return redirect()
            ->route('user.booking.history')
            ->with('success', 'Booking berhasil dibatalkan.');
    }
}