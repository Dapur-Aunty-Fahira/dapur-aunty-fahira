<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            position: relative;
        }

        /* Watermark pink */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 60px;
            color: rgba(255, 105, 180, 0.1);
            /* Hot pink with transparency */
            white-space: nowrap;
            z-index: 0;
            pointer-events: none;
        }

        .content {
            position: relative;
            z-index: 1;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #555;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #2c3e50;
        }

        .header p {
            margin: 4px 0;
            font-size: 12px;
            color: #777;
        }

        .section-title {
            font-size: 14px;
            margin-top: 20px;
            margin-bottom: 5px;
            color: #2c3e50;
            border-bottom: 1px solid #ccc;
            padding-bottom: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background: #f0f0f0;
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        tfoot td {
            font-weight: bold;
        }

        .info-table td {
            border: none;
            padding: 4px 0;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 30px;
            border-top: 1px dashed #aaa;
            padding-top: 10px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="watermark">Dapur Aunty Fahira</div>

    <div class="content">
        <div class="header">
            <h1>Dapur Aunty Fahira</h1>
            <p>Jl. Raya Serang km.25, Kp. Jaha Rt 02/01, Sentul Jaya, Kec. Balaraja, Kabupaten Tangerang, Banten 15610
            </p>
            <p>Telp: 0877-9792-4356 | Instagram: @dapurauntyfahira</p>
        </div>

        <div class="section-title">Informasi Pelanggan</div>
        <table class="info-table">
            <tr>
                <td><strong>Nomor Order:</strong></td>
                <td>#{{ $order->order_number }}</td>
            </tr>
            <tr>
                <td><strong>Nama:</strong></td>
                <td>{{ $order->user->name }}</td>
            </tr>
            <tr>
                <td><strong>Alamat:</strong></td>
                <td>{{ $order->address }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Order:</strong></td>
                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
            </tr>
            <tr>
                <td><strong>Pengantaran:</strong></td>
                <td>{{ $order->delivery_date }} pukul {{ $order->delivery_time }}</td>
            </tr>
            <tr>
                <td><strong>Metode Pembayaran:</strong></td>
                <td>{{ ucfirst($order->payment_method) }}</td>
            </tr>
        </table>

        <div class="section-title">Rincian Pesanan</div>
        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->menu->name ?? 'Menu tidak ditemukan' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;">Total:</td>
                    <td>Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="section-title">Status</div>
        <table class="info-table">
            <tr>
                <td><strong>Status Pembayaran:</strong></td>
                <td>{{ ucwords($order->payment_status) }}</td>
            </tr>
        </table>

        <div class="footer">
            Terima kasih telah memesan di Dapur Aunty Fahira. Semoga Anda puas dengan layanan kami!<br>
            Invoice ini dicetak secara otomatis oleh sistem.
        </div>
    </div>
</body>

</html>
