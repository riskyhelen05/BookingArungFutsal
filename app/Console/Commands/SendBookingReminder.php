<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\Notification;
use Carbon\Carbon;

#[Signature('app:send-booking-reminder')]
#[Description('Kirim reminder H-1 jadwal futsal')]
class SendBookingReminder extends Command
{
    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $bookings = Booking::whereDate('booking_date', $tomorrow)->get();

        foreach ($bookings as $booking) {

            $exists = Notification::where('booking_id', $booking->id)
                ->where('type', 'booking_reminder')
                ->exists();

            if (!$exists) {

                Notification::create([
                    'user_id' => $booking->user_id,
                    'title' => 'Reminder Main Futsal ⚽',
                    'message' => 'Jangan lupa! Besok kamu bermain futsal pada '
    . Carbon::parse($booking->booking_date)->translatedFormat('d F Y')
    . ' pukul '
    . Carbon::parse($booking->start_time)->format('H:i')
    . ' WIB',
                    'type' => 'booking_reminder',
                    'booking_id' => $booking->id,
                    'is_read' => false,
                ]);
            }
        }

        $this->info('Reminder berhasil dikirim.');

        return Command::SUCCESS;
    }
}