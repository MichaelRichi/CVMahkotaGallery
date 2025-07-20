<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Slip Gaji Karyawan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #eee;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .header-left {
            flex: 1;
            padding-right: 20px;
        }

        .header-left img {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }

        .header-left p {
            margin: 0;
            line-height: 1.5;
        }

        .header-right {
            flex: 1.5;
            text-align: right;
        }

        .header-right h1 {
            font-size: 36px;
            margin: 0 0 10px 0;
            font-weight: bold;
            color: #000;
        }

        .employee-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5px 10px;
            font-size: 12px;
            text-align: left;
            margin-top: 15px;
        }

        .employee-details div {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
        }

        .employee-details .label {
            font-weight: normal;
            margin-right: 5px;
            white-space: nowrap;
        }

        .employee-details .value {
            font-weight: bold;
            text-align: right;
            flex-grow: 1;
        }

        .main-content {
            display: flex;
            margin-bottom: 30px;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }

        .section {
            flex: 1;
            padding: 0;
        }

        .section:first-child {
            border-right: 1px solid #ddd;
        }

        .section h2 {
            background-color: #f2f2f2;
            margin: 0;
            padding: 8px 10px;
            font-size: 14px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
        }

        .item-list {
            padding: 10px;
        }

        .item {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
        }

        .item-name {
            flex: 1;
        }

        .item-amount {
            text-align: right;
            width: 100px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 10px;
            font-weight: bold;
            background-color: #f2f2f2;
            border-top: 1px solid #ddd;
        }

        .total-row .label {
            flex: 1;
        }

        .total-row .amount {
            text-align: right;
            width: 100px;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 30px;
        }

        .footer-left {
            flex: 1;
            font-size: 11px;
            line-height: 1.6;
        }

        .footer-right {
            flex: 0.7;
            text-align: center;
            border: 1px solid #000;
            padding: 10px;
            margin-left: 20px;
        }

        .footer-right p {
            margin: 0 0 5px 0;
            font-weight: bold;
        }

        .footer-right .total-amount-box {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #000;
            padding: 5px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="header-left">
                <img src="{{ $logoBase64 }}" alt="Logo">
                <p><strong>Mahkota Gallery</strong></p>
                <p>Jl. Dempo Luar No.968, 15 Ilir, Kec. Ilir Tim. I, Kota Palembang, Sumatera Selatan 30111</p>
                <p>Palembang, Indonesia</p>
            </div>
            <div class="header-right">
                <h1>Slip Gaji</h1>
                <div class="employee-details">
                    <div><span class="label">Nama / NIK:</span> <span
                            class="value">{{ $payroll->staff->nama ?? 'Tidak Diketahui' }} (ZM0001)</span></div>
                    <div><span class="label">Periode Gaji:</span> <span
                            class="value">{{ \Carbon\Carbon::parse($payroll->periode)->format('F Y') }}</span></div>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="section section-pendapatan">
                <h2>Pendapatan</h2>
                <div class="item-list">
                    <div class="item">
                        <span class="item-name">Gaji Pokok</span>
                        <span class="item-amount">Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}</span>
                    </div>
                    <div class="item">
                        <span class="item-name">Tunjangan</span>
                        <span class="item-amount">Rp {{ number_format($payroll->gaji_tunjangan, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="total-row">
                    <span class="label">Total Pendapatan</span>
                    <span class="amount">Rp
                        {{ number_format($payroll->gaji_pokok + $payroll->gaji_tunjangan, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="section section-potongan">
                <h2>Potongan</h2>
                <div class="item-list">
                    <div class="item">
                        <span class="item-name">Potongan Denda</span>
                        <span class="item-amount">Rp
                            {{ number_format($payroll->potongan_kronologi, 0, ',', '.') }}</span>
                    </div>
                    <div class="item">
                        <span class="item-name">Potongan Peminjaman</span>
                        <span class="item-amount">Rp {{ number_format($payroll->potongan_hutang, 0, ',', '.') }}</span>
                    </div>
                    <div class="item">
                        <span class="item-name">Potongan Izin</span>
                        <span class="item-amount">Rp {{ number_format($payroll->potongan_izin, 0, ',', '.') }}</span>
                    </div>
                    <div class="item">
                        <span class="item-name">Potongan Alpha</span>
                        <span class="item-amount">Rp {{ number_format($payroll->potongan_alpha, 0, ',', '.') }}</span>
                    </div>
                    <div class="item">
                        <span class="item-name">Potongan Terlambat</span>
                        <span class="item-amount">Rp
                            {{ number_format($payroll->potongan_terlambat, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="total-row">
                    <span class="label">Total Potongan</span>
                    <span class="amount">Rp
                        {{ number_format($payroll->potongan_kronologi + $payroll->potongan_hutang + $payroll->potongan_izin + $payroll->potongan_alpha + $payroll->potongan_terlambat, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="footer-left">
                <p>Pembayaran gaji telah dilakukan oleh perusahaan</p>
                <p>Secara transfer ke rekening karyawan</p>
                <p>BCA 55501021457 ({{ $payroll->staff->nama ?? 'Tidak Diketahui' }})</p>
            </div>
            <div class="footer-right">
                <p>Total Penerimaan Bulan Ini</p>
                <div class="total-amount-box">
                    Rp {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
