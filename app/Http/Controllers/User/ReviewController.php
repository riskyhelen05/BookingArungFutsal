<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Booking $booking)
{
    abort_if($booking->user_id !== Auth::id(), 403);

    if ($booking->status !== 'completed') {
        return redirect()
            ->route('user.booking.history');
    }

    $alreadyReview = Review::where('booking_id', $booking->id)
        ->where('user_id', Auth::id())
        ->exists();

    if ($alreadyReview) {
        return redirect()
            ->route('user.booking.history')
            ->with('error', 'Anda sudah memberikan ulasan.');
    }

    return view('user.reviews.create', compact('booking'));
}

public function store(Request $request, Booking $booking)
{
    abort_if($booking->user_id !== Auth::id(), 403);

    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ]);

  Review::create([
    'user_id' => Auth::id(),
    'booking_id' => $booking->id,
    
    'rating' => $request->rating,
    'comment' => $request->comment,
]);

    return view('user.reviews.success');
}
}