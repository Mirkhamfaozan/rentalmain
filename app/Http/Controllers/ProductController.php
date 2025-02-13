<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Tampilkan semua produk
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    // Tampilkan form tambah produk
    public function create()
    {
        return view('admin.products.create');
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_motor' => 'required|string|max:255',
            'cc_motor' => 'required|integer',
            'harga' => 'required|numeric',
            'transmisi_motor' => 'required|string',
        ]);

        Product::create($request->all());
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    // Tampilkan detail produk
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    // Tampilkan form edit produk
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // Update data produk
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama_motor' => 'required|string|max:255',
            'cc_motor' => 'required|integer',
            'harga' => 'required|numeric',
            'transmisi_motor' => 'required|string',
        ]);

        $product->update($request->all());
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate');
    }

    // Hapus produk
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
    }
}