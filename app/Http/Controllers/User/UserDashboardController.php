<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $nextBooking = Booking::where('user_id', Auth::id())
            ->whereIn('status', [
                'confirmed',
                'pending',
                'waiting_confirmation'
            ])
            ->with('field')
            ->latest()
            ->first();

        $totalBooking = Booking::where('user_id', Auth::id())
            ->count();

        $activeBooking = Booking::where('user_id', Auth::id())
            ->whereIn('status', [
                'pending',
                'confirmed'
            ])
            ->count();

        $completedBooking = Booking::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->count();

        $statusColor = 'bg-gray-100 text-gray-700';
        $statusText = '-';

        if ($nextBooking) {

            $statusColor = match ($nextBooking->status) {
                'confirmed' => 'bg-green-100 text-green-700',
                'pending' => 'bg-yellow-100 text-yellow-700',
                'waiting_confirmation' => 'bg-blue-100 text-blue-700',
                default => 'bg-gray-100 text-gray-700'
            };

            $statusText = match ($nextBooking->status) {
                'confirmed' => 'Dikonfirmasi',
                'pending' => 'Menunggu Pembayaran',
                'waiting_confirmation' => 'Menunggu Konfirmasi',
                default => ucfirst($nextBooking->status)
            };
        }

        return view('user.beranda', compact(
            'nextBooking',
            'totalBooking',
            'activeBooking',
            'completedBooking',
            'statusColor',
            'statusText'
        ));
    }
}