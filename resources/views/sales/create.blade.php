@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Transaksi Penjualan</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form Scan Barcode -->
    <form action="{{ route('sales.scan') }}" method="POST" class="row mb-4">
        @csrf
        <div class="col-md-8">
            <input type="text" name="barcode" class="form-control" placeholder="Scan atau ketik barcode..." required autofocus>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary w-100">Tambah ke Keranjang</button>
        </div>
    </form>

    <!-- Keranjang -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cart as $id => $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>Rp{{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                    <td>
                        <form action="{{ route('sales.item.destroy', $id) }}" method="POST" onsubmit="return confirm('Hapus item ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Keranjang kosong</td></tr>
            @endforelse
        </tbody>
    </table>

    <h4>Total: Rp{{ number_format($total, 0, ',', '.') }}</h4>

    <!-- Form Checkout -->
    @if ($total > 0)
    <form action="{{ route('sales.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Bayar</label>
            <input type="number" name="paid_amount" class="form-control" placeholder="Masukkan jumlah uang" required>
        </div>
        <button class="btn btn-success">Simpan Transaksi</button>
    </form>
    @endif
</div>
@endsection