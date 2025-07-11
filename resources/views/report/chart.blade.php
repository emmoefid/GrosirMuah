@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Grafik Penjualan</h2>

    <form method="GET" class="mb-4">
        <label for="mode" class="form-label">Lihat grafik berdasarkan:</label>
        <select name="mode" id="mode" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
            <option value="day" {{ $mode === 'day' ? 'selected' : '' }}>Harian (Bulan Ini)</option>
            <option value="week" {{ $mode === 'week' ? 'selected' : '' }}>Mingguan (Tahun Ini)</option>
            <option value="month" {{ $mode === 'month' ? 'selected' : '' }}>Bulanan (Tahun Ini)</option>
        </select>
    </form>

    <canvas id="penjualanChart" height="100"></canvas>
</div>
@endsection

@push('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('penjualanChart').getContext('2d');

    const labels = @json($labels ?? []);
    const dataTransaksi = @json($jumlahTransaksi ?? []);
    const dataOmzet = @json($jumlahOmzet ?? []);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Jumlah Transaksi',
                    data: dataTransaksi,
                    borderColor: 'blue',
                    backgroundColor: 'rgba(0, 0, 255, 0.1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Omzet (Rp)',
                    data: dataOmzet,
                    borderColor: 'green',
                    backgroundColor: 'rgba(0, 255, 0, 0.1)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });
</script>
@endpush