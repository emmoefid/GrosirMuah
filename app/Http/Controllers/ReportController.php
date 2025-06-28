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
}
