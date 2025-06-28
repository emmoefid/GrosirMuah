<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h3 style="text-align: center;">Laporan Penjualan</h3>
    <p>Periode: {{ $start }} s/d {{ $end }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Total</th>
                <th>Bayar</th>
                <th>Kembali</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
            <tr>
                <td>{{ $sale->created_at->format('d-m-Y H:i') }}</td>
                <td>{{ $sale->user->name }}</td>
                <td>{{ number_format($sale->total_price, 0, ',', '.') }}</td>
                <td>{{ number_format($sale->paid_amount, 0, ',', '.') }}</td>
                <td>{{ number_format($sale->change, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Total Omzet: Rp{{ number_format($total, 0, ',', '.') }}</h4>
</body>
</html>