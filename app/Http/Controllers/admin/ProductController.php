<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        // Only allow admin and rental users
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to access this page.');
        }

        // Start building the query
        $query = Product::query();

        // Rental users only see their own products
        if (Auth::user()->isRental()) {
            $query->where('user_id', Auth::id());
        }

        // Apply filters
        if ($request->filled('search')) {
            $query->where('nama_motor', 'like', '%' . $request->search . '%');
        }

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

        if ($request->filled('transmission')) {
            $query->where('transmisi_motor', $request->transmission);
        }

        if ($request->filled('price_range')) {
            switch ($request->price_range) {
                case '0-100000':
                    $query->whereBetween('harga_harian', [0, 100000]);
                    break;
                case '100000-200000':
                    $query->whereBetween('harga_harian', [100000, 200000]);
                    break;
                case '200000+':
                    $query->where('harga_harian', '>', 200000);
                    break;
            }
        }

        // Get paginated results
        $products = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        // Only allow admin and rental users
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to access this page.');
        }

        return view('admin.products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        // Only allow admin and rental users
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to perform this action.');
        }

        // Custom validation messages
        $messages = [
            'required' => 'Kolom :attribute wajib diisi.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'max' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
            'image' => 'Kolom :attribute harus berupa gambar.',
            'mimes' => 'Kolom :attribute harus berformat: :values.',
            'unique' => 'Data :attribute sudah digunakan untuk produk lain.',
            'integer' => 'Kolom :attribute harus berupa angka bulat.',
            'numeric' => 'Kolom :attribute harus berupa angka.',
            'min' => 'Kolom :attribute minimal :min.',
            'tahun_produksi.min' => 'Tahun produksi tidak valid (minimal 1900).',
            'tahun_produksi.max' => 'Tahun produksi tidak boleh lebih dari tahun depan.',
            'cc_motor.min' => 'CC motor minimal 50cc.',
            'harga_harian.min' => 'Harga harian tidak boleh negatif.',
            'stok.min' => 'Stok minimal 1 unit.',
            'gambar_utama.max' => 'Ukuran file gambar utama tidak boleh lebih dari 2MB.',
        ];

        // Attribute names
        $attributes = [
            'nama_motor' => 'Nama Motor',
            'brand' => 'Merek',
            'cc_motor' => 'CC Motor',
            'harga_harian' => 'Harga Harian',
            'transmisi_motor' => 'Transmisi Motor',
            'tipe_motor' => 'Tipe Motor',
            'tahun_produksi' => 'Tahun Produksi',
            'warna' => 'Warna',
            'no_mesin' => 'Nomor Mesin',
            'no_rangka' => 'Nomor Rangka',
            'gambar_utama' => 'Gambar Utama',
            'deskripsi' => 'Deskripsi',
            'stok' => 'Stok',
            'is_available' => 'Ketersediaan',
        ];

        $validated = $request->validate([
            'nama_motor' => 'required|string|max:100',
            'brand' => 'required|string|max:50',
            'cc_motor' => 'required|integer|min:50',
            'harga_harian' => 'required|numeric|min:0',
            'transmisi_motor' => 'required|string|max:20',
            'tipe_motor' => 'required|string|max:50',
            'tahun_produksi' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'warna' => 'required|string|max:50',
            'no_mesin' => ['required', 'string', 'max:50', 'unique:products'],
            'no_rangka' => ['required', 'string', 'max:50', 'unique:products'],
            'gambar_utama' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:1',
            'is_available' => 'boolean',
        ], $messages, $attributes);

        // Handle boolean conversion for is_available
        $validated['is_available'] = $request->has('is_available') ? true : false;

        // Calculate harga_mingguan and harga_bulanan with 2-day discount
        $validated['diskon_mingguan'] = 2; // 2 days discount
        $validated['diskon_bulanan'] = 2; // 2 days discount
        $validated['harga_mingguan'] = $validated['harga_harian'] * (7 - $validated['diskon_mingguan']); // 5 days effective
        $validated['harga_bulanan'] = $validated['harga_harian'] * (30 - $validated['diskon_bulanan']); // 28 days effective

        // Handle file upload
        try {
            if ($request->hasFile('gambar_utama')) {
                $validated['gambar_utama'] = $request->file('gambar_utama')->store('product_images', 'public');
            }

            // Add the user_id to the validated data
            $validated['user_id'] = Auth::id();

            // Create the product
            Product::create($validated);

            return redirect()->route('dashboard.products.index')
                ->with('success', 'Produk berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Product creation failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            // Clean up uploaded file if product creation fails
            if (isset($validated['gambar_utama']) && Storage::disk('public')->exists($validated['gambar_utama'])) {
                Storage::disk('public')->delete($validated['gambar_utama']);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan produk. Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        // Only allow admin and rental users
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to view this product.');
        }

        // Rental users can only see their own products
        if (Auth::user()->isRental() && $product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. This product belongs to another rental.');
        }

        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        // Only allow admin and rental users
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to edit products.');
        }

        // Rental users can only edit their own products
        if (Auth::user()->isRental() && $product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. You can only edit your own products.');
        }

        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Only allow admin and rental users
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to update products.');
        }

        // Rental users can only update their own products
        if (Auth::user()->isRental() && $product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. You can only update your own products.');
        }

        // Custom validation messages
        $messages = [
            'required' => 'Kolom :attribute wajib diisi.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'max' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
            'image' => 'Kolom :attribute harus berupa gambar.',
            'mimes' => 'Kolom :attribute harus berformat: :values.',
            'unique' => 'Data :attribute sudah digunakan untuk produk lain.',
            'integer' => 'Kolom :attribute harus berupa angka bulat.',
            'numeric' => 'Kolom :attribute harus berupa angka.',
            'min' => 'Kolom :attribute minimal :min.',
            'tahun_produksi.min' => 'Tahun produksi tidak valid (minimal 1900).',
            'tahun_produksi.max' => 'Tahun produksi tidak boleh lebih dari tahun depan.',
            'cc_motor.min' => 'CC motor minimal 50cc.',
            'harga_harian.min' => 'Harga harian tidak boleh negatif.',
            'stok.min' => 'Stok minimal 1 unit.',
            'gambar_utama.max' => 'Ukuran file gambar utama tidak boleh lebih dari 2MB.',
        ];

        // Attribute names
        $attributes = [
            'nama_motor' => 'Nama Motor',
            'brand' => 'Merek',
            'cc_motor' => 'CC Motor',
            'harga_harian' => 'Harga Harian',
            'transmisi_motor' => 'Transmisi Motor',
            'tipe_motor' => 'Tipe Motor',
            'tahun_produksi' => 'Tahun Produksi',
            'warna' => 'Warna',
            'no_mesin' => 'Nomor Mesin',
            'no_rangka' => 'Nomor Rangka',
            'gambar_utama' => 'Gambar Utama',
            'deskripsi' => 'Deskripsi',
            'stok' => 'Stok',
            'is_available' => 'Ketersediaan',
        ];

        $validated = $request->validate([
            'nama_motor' => 'required|string|max:100',
            'brand' => 'required|string|max:50',
            'cc_motor' => 'required|integer|min:50',
            'harga_harian' => 'required|numeric|min:0',
            'transmisi_motor' => 'required|string|max:20',
            'tipe_motor' => 'required|string|max:50',
            'tahun_produksi' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'warna' => 'required|string|max:50',
            'no_mesin' => [
                'required',
                'string',
                'max:50',
                Rule::unique('products')->ignore($product->id),
            ],
            'no_rangka' => [
                'required',
                'string',
                'max:50',
                Rule::unique('products')->ignore($product->id),
            ],
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:1',
            'is_available' => 'required|boolean',
        ], $messages, $attributes);

        try {
            // Handle boolean conversion for is_available
            $validated['is_available'] = $request->has('is_available') ? true : false;

            // Calculate harga_mingguan and harga_bulanan with 2-day discount
            $validated['diskon_mingguan'] = 2; // 2 days discount
            $validated['diskon_bulanan'] = 2; // 2 days discount
            $validated['harga_mingguan'] = $validated['harga_harian'] * (7 - $validated['diskon_mingguan']); // 5 days effective
            $validated['harga_bulanan'] = $validated['harga_harian'] * (30 - $validated['diskon_bulanan']); // 28 days effective

            // Pertahankan file lama jika tidak ada file baru
            $validated['gambar_utama'] = $product->gambar_utama;

            // Handle file upload
            if ($request->hasFile('gambar_utama')) {
                // Hapus file lama jika ada
                if ($product->gambar_utama && Storage::disk('public')->exists($product->gambar_utama)) {
                    Storage::disk('public')->delete($product->gambar_utama);
                }
                $validated['gambar_utama'] = $request->file('gambar_utama')->store('product_images', 'public');
            }

            // Update produk
            $product->update($validated);

            return redirect()->route('dashboard.products.index')
                ->with('success', 'Produk berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Product update failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui produk. Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Only allow admin and rental users
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to delete products.');
        }

        // Rental users can only delete their own products
        if (Auth::user()->isRental() && $product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. You can only delete your own products.');
        }

        try {
            // Delete associated file
            if ($product->gambar_utama && Storage::disk('public')->exists($product->gambar_utama)) {
                Storage::disk('public')->delete($product->gambar_utama);
            }

            $product->delete();

            return redirect()->route('dashboard.products.index')
                ->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Product deletion failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Gagal menghapus produk. Error: ' . $e->getMessage());
        }
    }
}
