<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan BBM</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
            color: red;
        }
    </style>
</head>

<body>
    <h1>Laporan BBM Bulan {{ $bulanNama }} Tahun {{ $tahun }}</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Nama Kendaraan</th>
                <th>Liter</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->kendaraan->nama_kendaraan }} {{ $item->kendaraan->nomor_polisi }}</td>
                    <td>{{ $item->liter }}</td>
                    <td>{{ number_format($item->harga, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4"></td>
                <td class="total">Total Pengeluaran: Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
