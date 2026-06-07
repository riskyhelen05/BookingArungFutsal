<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Halaman pembayaran - upload bukti (Step 3)
     */
    public function show(string $bookingId)
    {
        $booking = Booking::with(['field', 'payment'])->findOrFail($bookingId);

        // Prevent accessing someone else's booking
        // if (Auth::id() && $booking->user_id !== Auth::id()) {
        //     abort(403);
        // }

        return view('payment.show', compact('booking'));
    }

    /**
     * Proses upload bukti pembayaran (Step 3 → Step 4)
     */
    public function upload(Request $request, string $bookingId)
    {
        $request->validate([
            'proof_image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ], [
            'proof_image.required' => 'Bukti pembayaran wajib diunggah.',
            'proof_image.image'    => 'File harus berupa gambar.',
            'proof_image.mimes'    => 'Format harus JPG, JPEG, atau PNG.',
            'proof_image.max'      => 'Ukuran file maksimal 5 MB.',
        ]);

        $booking = Booking::with('payment')->findOrFail($bookingId);

        if (!in_array($booking->status, ['pending', 'waiting_confirmation'])) {
            return back()->withErrors(['error' => 'Booking ini tidak dapat diproses.']);
        }

        // Store file
        $path = $request->file('proof_image')->store('payments/proofs', 'public');

        // Create or update payment
        if ($booking->payment) {
            // If rejected before, allow re-upload
            $booking->payment->update([
                'proof_image_url' => $path,
                'payment_status'  => 'pending',
                'submitted_at'    => now(),
            ]);
        } else {
            Payment::create([
                'booking_id'      => $booking->id,
                'proof_image_url' => $path,
                'payment_status'  => 'pending',
                'amount'          => $booking->total_amount,
                'submitted_at'    => now(),
            ]);
        }

        // Update booking status
        $booking->update(['status' => 'waiting_confirmation']);

        return redirect()->route('user.payment.success', $booking->id);
    }

    /**
     * Halaman sukses pembayaran (Step 4)
     */
    public function success(string $bookingId)
    {
        $booking = Booking::with(['field', 'payment'])->findOrFail($bookingId);
        return view('payment.success', compact('booking'));
    }
}
