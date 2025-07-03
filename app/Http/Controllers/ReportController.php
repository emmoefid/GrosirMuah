<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $end = $request->end_date ?? now()->endOfMonth()->format('Y-m-d');

        $sales = Sale::with('user')
            ->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59'])
            ->latest()
            ->get();

        $total = $sales->sum('total_price');

        return view('report.index', compact('sales', 'start', 'end', 'total'));
    }
    // untuk cetak ke pdf
    public function exportPdf(Request $request)
    {
        $start = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $end = $request->end_date ?? now()->endOfMonth()->format('Y-m-d');

        $sales = Sale::with('user')
            ->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59'])
            ->latest()
            ->get();

        $total = $sales->sum('total_price');

        $pdf = Pdf::loadView('report.pdf', compact('sales', 'start', 'end', 'total'));
        return $pdf->stream('laporan-penjualan.pdf');
    }
    // grafik
    public function chart(Request $request)
    {
        $mode = $request->get('mode', 'day');

        switch ($mode) {
            case 'week':
                $data = Sale::selectRaw("WEEK(created_at, 1) as label, COUNT(*) as total_transaksi, SUM(total_price) as omzet")
                    ->whereYear('created_at', now()->year)
                    ->groupBy('label')
                    ->orderBy('label')
                    ->get();
                $labels = $data->pluck('label')->map(fn($w) => "Minggu-$w")->toArray();
                break;

            case 'month':
                $data = Sale::selectRaw("
                        MONTH(created_at) as bulan,
                        DATE_FORMAT(created_at, '%M') as label,
                        COUNT(*) as total_transaksi,
                        SUM(total_price) as omzet
                    ")
                    ->whereYear('created_at', now()->year)
                    ->groupByRaw('bulan, label')
                    ->orderBy('bulan')
                    ->get();

                $labels = $data->pluck('label')->toArray();
                break;

            case 'day':
            default:
                $data = Sale::selectRaw("DATE(created_at) as label, COUNT(*) as total_transaksi, SUM(total_price) as omzet")
                    ->whereMonth('created_at', now()->month)
                    ->groupBy('label')
                    ->orderBy('label')
                    ->get();
                $labels = $data->pluck('label')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))->toArray();
                break;
        }

        $jumlahTransaksi = $data->pluck('total_transaksi')->toArray();
        $jumlahOmzet = $data->pluck('omzet')->toArray();

        return view('report.chart', compact('labels', 'jumlahTransaksi', 'jumlahOmzet', 'mode'));
    }

}
