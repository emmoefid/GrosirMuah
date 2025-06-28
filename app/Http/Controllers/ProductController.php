<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'barcode' => 'nullable|unique:products',
        'name' => 'required',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric',
        'stock' => 'required|integer'
    ]);

    // Kalau barcode kosong, generate otomatis
    $barcode = $request->barcode ?: $this->generateUniqueBarcode();

    Product::create([
        'barcode' => $barcode,
        'name' => $request->name,
        'category_id' => $request->category_id,
        'price' => $request->price,
        'stock' => $request->stock,
    ]);

    return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
}
    // untuk membuat barcode unik
    private function generateUniqueBarcode()
    {
        do {
            $barcode = rand(100000000000, 999999999999); // 12 digit angka
        } while (Product::where('barcode', $barcode)->exists());

        return $barcode;
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'barcode' => 'required|unique:products,barcode,' . $product->id,
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer'
        ]);

        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }
}
