<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function create()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['subtotal']);
        return view('sales.create', compact('cart', 'total'));
    }

    public function scanBarcode(Request $request)
    {
        $request->validate(['barcode' => 'required']);
        $product = Product::where('barcode', $request->barcode)->first();

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
            $cart[$product->id]['subtotal'] = $cart[$product->id]['quantity'] * $product->price;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'subtotal' => $product->price,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back();
    }

    public function destroyItem($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return redirect()->back();
    }

    public function store(Request $request)
    {
        $request->validate([
            'paid_amount' => 'required|numeric|min:0',
        ]);

        $cart = session()->get('cart', []);
        if (!$cart) {
            return redirect()->back()->with('error', 'Keranjang kosong');
        }

        DB::beginTransaction();
        try {
            $total = collect($cart)->sum(fn($item) => $item['subtotal']);
            $change = $request->paid_amount - $total;

            $sale = Sale::create([
                'user_id' => auth()->id(),
                'total_price' => $total,
                'paid_amount' => $request->paid_amount,
                'change' => $change,
            ]);

            foreach ($cart as $productId => $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price_per_unit' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);

                Product::where('id', $productId)->decrement('stock', $item['quantity']);
            }

            session()->forget('cart');
            DB::commit();

            return redirect()->route('sales.receipt', $sale->id);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan transaksi');
        }
    }

    public function receipt($id)
    {
        $sale = Sale::with(['items.product', 'user'])->findOrFail($id);
        return view('sales.receipt', compact('sale'));
    }
}
