<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingExport implements FromCollection, WithHeadings
{
    protected $bookings;

    public function __construct($bookings)
    {
        $this->bookings = $bookings;
    }

    public function collection()
    {
        return $this->bookings->map(function ($booking) {

            return [
                $booking->reservation_code,
                $booking->user->name,
                $booking->field->name,
                $booking->booking_date,
                substr($booking->start_time, 0, 5)
                    . ' - ' .
                substr($booking->end_time, 0, 5),
                $booking->total_amount,
                ucfirst($booking->status),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Kode Reservasi',
            'Pelanggan',
            'Lapangan',
            'Tanggal',
            'Jam',
            'Total',
            'Status',
        ];
    }
}