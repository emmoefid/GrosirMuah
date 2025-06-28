<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $totalProduk = Product::count();
            $totalKategori = Category::count();
            $totalTransaksi = Sale::count();
            $totalStok = Product::sum('stock');

            return view('dashboard.admin', compact(
                'totalProduk',
                'totalKategori',
                'totalTransaksi',
                'totalStok'
            ));
        }

        // kasir
        if (Auth::user()->role === 'kasir') {
        $totalTransaksi = Sale::where('user_id', Auth::id())->count();

        $recentSales = Sale::where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.kasir', compact('totalTransaksi', 'recentSales'));
    }
    
        // jika bukan admin atau kasir, redirect ke halaman home
        return redirect()->route('home')->with('error', 'Akses tidak diizinkan.');

    }
}
