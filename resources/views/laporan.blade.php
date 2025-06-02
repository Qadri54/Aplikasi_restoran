<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            width: 350px;
            margin: auto;
            font-size: 12px;
            color: #333;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        td, th {
            padding: 6px 4px;
            vertical-align: top;
        }

        th {
            border-bottom: 1px solid #000;
            text-align: left;
        }

        .right {
            text-align: right;
        }

        .total {
            font-weight: bold;
            font-size: 14px;
            border-top: 2px solid #000;
            padding-top: 8px;
        }

        .thank-you {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
        }

        .small-text {
            font-size: 10px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="center bold">COMPANY NAME</div>
    <div class="center small-text">Jl. Contoh Alamat No. 123, Kota Contoh</div>
    <div class="center small-text">Telp: (021) 1234567 | Email: info@company.com</div>

    <div class="line"></div>

    <table>
        <tr>
            <td>Tanggal:</td>
            <td class="right">{{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td>Meja:</td>
            <td class="right">{{ $nomor_meja ?? '-' }}</td>
        </tr>
        <tr>
            <td>Metode Pembayaran:</td>
            <td class="right">Online</td>
        </tr>
    </table>

    <div class="line"></div>

    <table>
        <thead>
            <tr class="bold">
                <th>Deskripsi</th>
                <th class="right">Qty</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $item)
                @php
                    $harga = $prices[$index];
                    $jumlah = $qty[$index];
                    $subtotal = $harga * $jumlah;
                    $subtotal_fmt = (new \NumberFormatter('id_ID', \NumberFormatter::CURRENCY))->formatCurrency($subtotal, 'IDR');
                    $harga_fmt = (new \NumberFormatter('id_ID', \NumberFormatter::CURRENCY))->formatCurrency($harga, 'IDR');
                @endphp
                <tr>
                    <td>{{ $item }}</td>
                    <td class="right">{{ $jumlah }}</td>
                    <td class="right">{{ $final_amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="line"></div>

    <table>
        <tr class="bold">
            <td>Total Bayar:</td>
            <td class="right">{{ $final_amount }}</td>
        </tr>
    </table>

    <div class="thank-you">TERIMA KASIH</div>
    <div class="center small-text">Barang yang sudah dibeli tidak dapat dikembalikan.</div>
    <div class="center small-text">Hubungi kami: (021) 1234567 | info@company.com</div>

</body>
</html>
