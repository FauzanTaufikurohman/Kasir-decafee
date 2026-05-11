<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struk Pesanan {{ $order->order_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
            margin: 0;
            padding: 16px;
        }
        .receipt {
            max-width: 420px;
            margin: 0 auto;
            line-height: 1.4;
        }
        .receipt h1,
        .receipt h2,
        .receipt h3,
        .receipt p,
        .receipt table {
            margin: 0;
            padding: 0;
            width: 100%;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 16px;
        }
        .receipt-header h1 {
            font-size: 18px;
            margin-bottom: 4px;
        }
        .receipt-header p {
            font-size: 12px;
            color: #555;
        }
        .receipt-info,
        .receipt-total {
            margin-bottom: 12px;
        }
        .receipt-info div {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }
        .receipt-items {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            margin: 12px 0;
            padding: 8px 0;
        }
        .receipt-items .item {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 4px;
        }
        .receipt-items .item:last-child {
            margin-bottom: 0;
        }
        .receipt-summary {
            font-size: 12px;
        }
        .receipt-summary div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }
        .receipt-summary .total {
            font-weight: bold;
            font-size: 14px;
            margin-top: 8px;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .receipt {
                margin: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="receipt-header">
            <h1>Origin Cafee</h1>
            <p>Struk Pembayaran</p>
            <p>{{ now()->format('d/m/Y H:i') }}</p>
        </div>

        <div class="receipt-info">
            <div><span>No Pesanan</span><span>{{ $order->order_number }}</span></div>
            <div><span>No Meja</span><span>{{ $order->table_number ?? '-' }}</span></div>
            <div><span>Pelayan</span><span>{{ $order->user->name ?? '-' }}</span></div>
            <div><span>Status</span><span>{{ ucfirst($order->status) }}</span></div>
        </div>

        <div class="receipt-items">
            @foreach ($order->items as $item)
                <div class="item">
                    <span>{{ $item->menu->name ?? 'Menu hilang' }} x{{ $item->qty }}</span>
                    <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>

        <div class="receipt-summary">
            <div><span>Subtotal</span><span>Rp {{ number_format($order->total, 0, ',', '.') }}</span></div>
            <div><span>Metode</span><span>{{ $order->payment_method ? strtoupper($order->payment_method) : '-' }}</span></div>
            <div><span>Pembayaran</span><span>{{ $order->paid_at ? 'Lunas' : 'Belum' }}</span></div>
            <div class="total"><span>Total</span><span>Rp {{ number_format($order->total, 0, ',', '.') }}</span></div>
        </div>

        <div style="text-align:center; margin-top: 16px; font-size: 12px;">
            Terima kasih atas kunjungan Anda!
        </div>
    </div>

    <script>
        window.addEventListener('load', function () {
            window.print();
        });
    </script>
</body>
</html>
