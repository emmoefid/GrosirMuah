@extends('layouts.app')

@section('content')
<style>
    .dashboard-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 32px 24px;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.07);
    }
    .dashboard-title {
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 32px;
        letter-spacing: 1px;
        color: #222;
        text-align: center;
    }
    .dashboard-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        transition: transform 0.15s;
        background: linear-gradient(135deg, #f8fafc 60%, #f1f5f9 100%);
        color: #222;
    }
    .dashboard-card:hover {
        transform: translateY(-4px) scale(1.03);
        box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    }
    .dashboard-card .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #555;
        margin-bottom: 10px;
    }
    .dashboard-card .card-text {
        font-size: 2.2rem;
        font-weight: 700;
        color: #1d4ed8;
        margin-bottom: 0;
    }
    .dashboard-icon {
        font-size: 2.2rem;
        margin-bottom: 12px;
        color: #64748b;
    }
    @media (max-width: 767px) {
        .dashboard-container {
            padding: 16px 4px;
        }
        .dashboard-title {
            font-size: 1.3rem;
        }
    }
</style>

<div class="dashboard-container">
    <div class="dashboard-title">Dashboard Admin</div>
    <div class="row g-4">
        <div class="col-12 col-md-3">
            <div class="card dashboard-card text-center">
                <div class="card-body">
                    <div class="dashboard-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="card-title">Total Produk</div>
                    <div class="card-text">{{ $totalProduk }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card dashboard-card text-center">
                <div class="card-body">
                    <div class="dashboard-icon">
                        <i class="bi bi-tags"></i>
                    </div>
                    <div class="card-title">Total Kategori</div>
                    <div class="card-text">{{ $totalKategori }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card dashboard-card text-center">
                <div class="card-body">
                    <div class="dashboard-icon">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div class="card-title">Total Transaksi</div>
                    <div class="card-text">{{ $totalTransaksi }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card dashboard-card text-center">
                <div class="card-body">
                    <div class="dashboard-icon">
                        <i class="bi bi-stack"></i>
                    </div>
                    <div class="card-title">Total Stok</div>
                    <div class="card-text">{{ $totalStok }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons CDN (add this in your layout if not already included) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
@endsection