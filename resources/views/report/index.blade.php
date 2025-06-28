@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Laporan Penjualan</h2>

    <form method="GET" class="row mb-4">
        <div class="col-md-4">
            <label>Dari Tanggal</label>
            <input type="date" name="start_date" class="form-control" value="{{ $start }}">
        </div>
        <div class="col-md-4">
            <label>Sampai Tanggal</label>
            <input type="date" name="end_date" class="form-control" value="{{ $end }}">
        </div>
        <div class="col-md-4">
            <label>&nbsp;</label><br>
            <button class="btn btn-primary">Tampilkan</button>
        </div>
    </form>

    <table class="table table-bordered table-sm">
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
            @forelse ($sales as $sale)
                <tr>
                    <td>{{ $sale->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $sale->user->name }}</td>
                    <td>Rp{{ number_format($sale->total_price, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($sale->paid_amount, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($sale->change, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="5">Tidak ada transaksi</td></tr>
            @endforelse
        </tbody>
    </table>

    <h5>Total Omzet: Rp{{ number_format($total, 0, ',', '.') }}</h5>

    <!-- cetak ke pdf -->
    <a href="{{ route('report.pdf', ['start_date' => $start, 'end_date' => $end]) }}" class="btn btn-danger mb-3" target="_blank">
    📄 Export PDF
    </a>
</div>
@endsection