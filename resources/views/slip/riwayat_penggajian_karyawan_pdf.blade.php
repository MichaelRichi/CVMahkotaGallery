<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Slip Gaji Karyawan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background occolor: #f2f2f2;
            font-weight: bold;
        }

        h1 {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Slip Gaji Karyawan</h1>
    <p class="text-center">Periode: {{ \Carbon\Carbon::parse($payroll->periode)->format('F Y') }}</p>
    <p class="text-center">Nama: {{ $payroll->staff->nama ?? 'Tidak Diketahui' }}</p>

    <table>
        <thead>
            <tr>
                <th>Periode</th>
                <th class="text-right">Gaji Pokok</th>
                <th class="text-right">Tunjangan</th>
                <th class="text-right">Pot. Denda</th>
                <th class="text-right">Pot. Peminjaman</th>
                <th class="text-right">Pot. Izin</th>
                <th class="text-right">Pot. Alpha</th>
                <th class="text-right">Pot. Terlambat</th>
                <th class="text-right">Gaji Bersih</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ \Carbon\Carbon::parse($payroll->periode)->format('F Y') }}</td>
                <td class="text-right">Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($payroll->gaji_tunjangan, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($payroll->potongan_kronologi, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($payroll->potongan_hutang, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($payroll->potongan_izin, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($payroll->potongan_alpha, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($payroll->potongan_terlambat, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
