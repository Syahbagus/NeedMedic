<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice Pesanan #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 20px;
            color: #555;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <h1 style="text-align: center; margin-bottom: 20px;">NeedMedic</h1>
        <h2 style="text-align: center; margin-bottom: 40px;">Laporan Belanja Anda</h2>

        <table>
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                <strong>User ID:</strong> {{ $order->user->id }}<br>
                                <strong>Nama:</strong> {{ $order->user->name }}<br>
                                <strong>Alamat:</strong> {{ $order->shipping_address }}<br>
                                <strong>No HP:</strong> {{ $order->user->contact_no }}
                            </td>
                            <td class="text-right">
                                <strong>Tanggal:</strong> {{ $order->created_at->format('d M Y') }}<br>
                                <strong>ID Paypal:</strong> {{ $order->user->paypal_id ?? '-' }}<br>
                                <strong>Nama Bank:</strong> {{ $order->payment_bank ?? '-' }}<br>
                                <strong>Cara Bayar:</strong>
                                {{ $order->payment_method === 'card' ? 'Debit/Credit Card' : ucfirst($order->payment_method) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Nama Produk</td>
                <td class="text-right">Jumlah</td>
                <td class="text-right">Harga Satuan</td>
                <td class="text-right">Subtotal</td>
            </tr>

            @foreach ($order->items as $item)
                <tr class="item">
                    <td>{{ $item->product->name }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($item->price) }}</td>
                    <td class="text-right">Rp {{ number_format($item->price * $item->quantity) }}</td>
                </tr>
            @endforeach

            <tr class="total">
                <td colspan="3"></td>
                <td class="text-right">
                    <strong>Total: Rp {{ number_format($order->total_amount) }}</strong>
                </td>
            </tr>
        </table>

        <div style="text-align: right; margin-top: 50px;">
            <strong>TANDATANGAN TOKO</strong>
        </div>
    </div>
</body>

</html>
