<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Tampilkan semua produk dengan filter
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter berdasarkan pencarian nama motor
        if ($request->filled('search')) {
            $query->where('nama_motor', 'LIKE', '%' . $request->search . '%');
        }

        // Filter berdasarkan range CC
        if ($request->filled('cc_range')) {
            switch ($request->cc_range) {
                case '0-150':
                    $query->whereBetween('cc_motor', [0, 150]);
                    break;
                case '151-250':
                    $query->whereBetween('cc_motor', [151, 250]);
                    break;
                case '251-400':
                    $query->whereBetween('cc_motor', [251, 400]);
                    break;
                case '400+':
                    $query->where('cc_motor', '>', 400);
                    break;
            }
        }

        // Filter berdasarkan transmisi
        if ($request->filled('transmission')) {
            $query->where('transmisi_motor', $request->transmission);
        }

        // Filter berdasarkan range harga
        if ($request->filled('price_range')) {
            switch ($request->price_range) {
                case '0-100000':
                    $query->whereBetween('harga', [0, 20000000]);
                    break;
                case '100000-50000000':
                    $query->whereBetween('harga', [20000000, 50000000]);
                    break;
                case '50000000+':
                    $query->where('harga', '>', 50000000);
                    break;
            }
        }

        // Ambil data dengan urutan nama motor A-Z
        $products = $query->orderBy('nama_motor', 'asc')->get();

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
            'cc_motor' => 'required|integer|min:50|max:2000',
            'harga' => 'required|numeric|min:10000',
            'transmisi_motor' => 'required|string|in:Manual,Automatic,CVT',
        ], [
            'nama_motor.required' => 'Nama motor wajib diisi',
            'cc_motor.required' => 'CC motor wajib diisi',
            'cc_motor.min' => 'CC motor minimal 50cc',
            'cc_motor.max' => 'CC motor maksimal 2000cc',
            'harga.required' => 'Harga wajib diisi',
            'harga.min' => 'Harga minimal Rp 100.000',
            'transmisi_motor.required' => 'Transmisi motor wajib dipilih',
            'transmisi_motor.in' => 'Transmisi motor harus Manual, Automatic, atau CVT',
        ]);

        Product::create($request->all());
        return redirect()->route('admin.products.index')->with('success', 'Motor berhasil ditambahkan');
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
            'cc_motor' => 'required|integer|min:50|max:2000',
            'harga' => 'required|numeric|min:100000',
            'transmisi_motor' => 'required|string|in:Manual,Automatic,CVT',
        ], [
            'nama_motor.required' => 'Nama motor wajib diisi',
            'cc_motor.required' => 'CC motor wajib diisi',
            'cc_motor.min' => 'CC motor minimal 50cc',
            'cc_motor.max' => 'CC motor maksimal 2000cc',
            'harga.required' => 'Harga wajib diisi',
            'harga.min' => 'Harga minimal Rp 100.000',
            'transmisi_motor.required' => 'Transmisi motor wajib dipilih',
            'transmisi_motor.in' => 'Transmisi motor harus Manual, Automatic, atau CVT',
        ]);

        $product->update($request->all());
        return redirect()->route('admin.products.index')->with('success', 'Motor berhasil diupdate');
    }

    // Hapus produk
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Motor berhasil dihapus');
    }

    // Method tambahan untuk reset filter
    public function resetFilters()
    {
        return redirect()->route('admin.products.index');
    }
}
