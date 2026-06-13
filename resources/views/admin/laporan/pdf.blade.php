<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Booking</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
        }

        th {
            background: #f3f4f6;
        }
    </style>
</head>

<body>

    <h2>Laporan Booking Arung Futsal</h2>

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

            @foreach($bookings as $booking)

                <tr>
                    <td>{{ $booking->reservation_code }}</td>

                    <td>{{ $booking->user->name }}</td>

                    <td>{{ $booking->field->name }}</td>

                    <td>{{ $booking->booking_date }}</td>

                    <td>
                        {{ substr($booking->start_time,0,5) }}
                        -
                        {{ substr($booking->end_time,0,5) }}
                    </td>

                    <td>
                        Rp {{ number_format($booking->total_amount,0,',','.') }}
                    </td>

                    <td>{{ ucfirst($booking->status) }}</td>
                </tr>

            @endforeach

        </tbody>

    </table>

</body>
</html>