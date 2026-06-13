<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Booking</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1f2937;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
        }

        .header p {
            margin: 4px 0;
            color: #6b7280;
        }

        .summary {
            margin-bottom: 20px;
        }

        .summary table {
            width: 100%;
            border: none;
        }

        .summary td {
            border: none;
            padding: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f3f4f6;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .empty {
            text-align: center;
            padding: 20px;
        }
    </style>
</head>

<body>

    <div class="header">

        <h2>Laporan Booking Arung Futsal</h2>

        <p>
            Periode:
            {{ ucfirst(str_replace('_', ' ', $period)) }}
        </p>

        <p>
            Dicetak pada:
            {{ now()->format('d M Y H:i') }}
        </p>

    </div>

@php
    $bookingBerhasil = $bookings
        ->whereIn('status', ['confirmed', 'completed']);

    $jumlahBookingBerhasil = $bookingBerhasil->count();

    $totalPendapatan = $bookingBerhasil->sum('total_amount');
@endphp

<div class="summary">

    <table>

        <tr>

            <td>
                <strong>Total Booking:</strong>
                {{ $bookings->count() }}

                <br>

                <small>Mencakup seluruh status reservasi.</small>

                <br><br>

                <strong>Booking Berhasil:</strong>
                {{ $jumlahBookingBerhasil }}

                <br>

                <small>Reservasi dengan status confirmed dan completed.</small>
            </td>

            <td class="text-right">
                <strong>Total Pendapatan:</strong>

                <br>

                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}

                <br>

                <small>Berdasarkan reservasi yang berhasil.</small>
            </td>

        </tr>

    </table>

</div>

    <table>

        <thead>

            <tr>
                <th>Kode</th>
                <th>Pelanggan</th>
                <th>Lapangan</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Total</th>
                <th>Status</th>
            </tr>

        </thead>

        <tbody>

            @forelse($bookings as $booking)

                <tr>

                    <td>
                        {{ $booking->reservation_code }}
                    </td>

                    <td>
                        {{ $booking->user->name }}
                    </td>

                    <td>
                        {{ $booking->field->name }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}
                    </td>

                    <td>
                        {{ substr($booking->start_time, 0, 5) }}
                        -
                        {{ substr($booking->end_time, 0, 5) }}
                    </td>

                    <td>
                        Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                    </td>

                    <td>
                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7" class="empty">

                        Tidak ada data booking.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</body>
</html>