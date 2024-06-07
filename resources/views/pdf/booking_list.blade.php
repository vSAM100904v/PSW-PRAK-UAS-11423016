<!DOCTYPE html>
<html>

<head>
    <title>Booking List PDF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Booking List</h2>
    <h1>Dipesan oleh {{ $bookings->$user->username_pengguna }}</h1><br>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Lapangan</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th>Waktu Pembookingan</th>
                <th>Lapangan yang dibooking</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookings as $booking)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $booking->lapangan->nama_lapangan }}</td>
                    <td>{{ $booking->waktu_mulai_booking }}</td>
                    <td>{{ $booking->waktu_selesai_booking }}</td>
                    <td>{{ $booking->created_at }}</td>
                    <td>{{ $booking->nama_lapangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
