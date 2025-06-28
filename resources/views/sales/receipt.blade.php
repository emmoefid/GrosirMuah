@extends('layouts.app')

@section('content')
<style>
    #print-area {
        max-width: 350px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        padding: 24px 18px 16px 18px;
        font-size: 14px;
        font-family: 'Courier New', Courier, monospace;
    }
    #print-area h5 {
        letter-spacing: 2px;
        font-weight: bold;
        margin-bottom: 2px;
    }
    #print-area hr {
        margin: 8px 0;
        border-top: 1px dashed #bbb;
    }
    #print-area table {
        margin-bottom: 0;
    }
    #print-area th, #print-area td {
        padding: 2px 4px;
    }
    #print-area .totals p {
        margin-bottom: 4px;
        font-size: 15px;
    }
    #print-area .totals strong {
        min-width: 70px;
        display: inline-block;
    }
    @media print {
        body * { visibility: hidden; }
        #print-area, #print-area * { visibility: visible; }
        #print-area { box-shadow: none; }
        #print-area .btn, #print-area a { display: none !important; }
    }
</style>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div id="print-area">
        <div class="text-center mb-2">
            <h5>GROSIR MUAH</h5>
            <small>{{ now()->format('d-m-Y H:i') }}</small>
            <hr>
        </div>

        <p><strong>Kasir:</strong> {{ $sale->user->name }}</p>

        <table class="table table-sm table-borderless">
            <thead>
                <tr>
                    <th style="width: 40%;">Item</th>
                    <th class="text-end" style="width: 15%;">Qty</th>
                    <th class="text-end" style="width: 20%;">Harga</th>
                    <th class="text-end" style="width: 25%;">Sub</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td class="text-end">{{ $item->quantity }}</td>
                    <td class="text-end">Rp{{ number_format($item->price_per_unit, 0, ',', '.') }}</td>
                    <td class="text-end">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <hr>
        <div class="totals">
            <p><strong>Total</strong> <span class="float-end">Rp{{ number_format($sale->total_price, 0, ',', '.') }}</span></p>
            <p><strong>Bayar</strong> <span class="float-end">Rp{{ number_format($sale->paid_amount, 0, ',', '.') }}</span></p>
            <p><strong>Kembali</strong> <span class="float-end">Rp{{ number_format($sale->change, 0, ',', '.') }}</span></p>
        </div>
        <hr>

        <p class="text-center" style="margin-bottom: 0; font-size: 15px;">Terima Kasih! <br>Semoga Hari Anda Menyenangkan</p>
        <div class="text-center mt-3 no-print">
            <button class="btn btn-sm btn-primary" onclick="window.print()">🖨️ Cetak Struk</button>
            <a href="{{ route('sales.create') }}" class="btn btn-sm btn-secondary">Transaksi Baru</a>
        </div>
    </div>
</div>
@endsection
