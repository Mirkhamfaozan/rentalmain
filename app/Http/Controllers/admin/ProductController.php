<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
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
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to access this page.');
        }

        $query = Product::query();

        if (Auth::user()->isRental()) {
            $query->where('user_id', Auth::id());
        }

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

        $products = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to access this page.');
        }

        $rentalUsers = [];
        if (Auth::user()->isAdmin()) {
            $rentalUsers = User::where('role', 'rental')->get();
        }

        return view('admin.products.create', compact('rentalUsers'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to perform this action.');
        }

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
            'gambar_utama.max' => 'Ukuran file gambar utama tidak boleh lebih dari 2MB.',
            'diskon_mingguan.max' => 'Diskon mingguan maksimal 6 hari.',
            'diskon_bulanan.max' => 'Diskon bulanan maksimal 29 hari.',
            'rental_user_id.required_if' => 'Pemilik rental wajib dipilih untuk admin.',
            'rental_user_id.exists' => 'Pemilik rental yang dipilih tidak valid.',
        ];

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
            'is_available' => 'Ketersediaan',
            'diskon_mingguan' => 'Diskon Mingguan',
            'diskon_bulanan' => 'Diskon Bulanan',
            'nomor_stnk' => 'Nomor STNK',
            'nomor_kendaraan' => 'Plat Nomor',
            'foto_stnk' => 'Foto STNK',
            'rental_user_id' => 'Pemilik Rental',
        ];

        $rules = [
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
            'nomor_stnk' => 'required|string|max:50',
            'nomor_kendaraan' => 'required|string|max:20',
            'foto_stnk' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'gambar_utama' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string',
            'is_available' => 'boolean',
            'diskon_mingguan' => 'required|integer|min:0|max:6',
            'diskon_bulanan' => 'required|integer|min:0|max:29',
        ];

        // Add rental user validation for admin
        if (Auth::user()->isAdmin()) {
            $rules['rental_user_id'] = 'required|exists:users,id,role,rental';
        }

        $validated = $request->validate($rules, $messages, $attributes);

        $validated['is_available'] = $request->has('is_available') ? true : false;

        try {
            // Handle file uploads
            if ($request->hasFile('gambar_utama')) {
                $validated['gambar_utama'] = $request->file('gambar_utama')->store('product_images', 'public');
            }

            if ($request->hasFile('foto_stnk')) {
                $validated['foto_stnk'] = $request->file('foto_stnk')->store('stnk_images', 'public');
            }

            // Calculate weekly and monthly prices
            $validated['harga_mingguan'] = $validated['harga_harian'] * (7 - $validated['diskon_mingguan']);
            $validated['harga_bulanan'] = $validated['harga_harian'] * (30 - $validated['diskon_bulanan']);

            // Set the user_id
            if (Auth::user()->isAdmin()) {
                $validated['user_id'] = $validated['rental_user_id'];
            } else {
                $validated['user_id'] = Auth::id();
            }

            Product::create($validated);

            return redirect()->route('dashboard.products.index')
                ->with('success', 'Produk berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Product creation failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            // Clean up uploaded files if creation fails
            if (isset($validated['gambar_utama']) && Storage::disk('public')->exists($validated['gambar_utama'])) {
                Storage::disk('public')->delete($validated['gambar_utama']);
            }
            if (isset($validated['foto_stnk']) && Storage::disk('public')->exists($validated['foto_stnk'])) {
                Storage::disk('public')->delete($validated['foto_stnk']);
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
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to view this product.');
        }

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
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to edit products.');
        }

        if (Auth::user()->isRental() && $product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. You can only edit your own products.');
        }

        $rentalUsers = [];
        if (Auth::user()->isAdmin()) {
            $rentalUsers = User::where('role', 'rental')->get();
        }

        return view('admin.products.edit', compact('product', 'rentalUsers'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
{
    if (!Auth::user()->canAccessDashboard()) {
        abort(403, 'Unauthorized action. You do not have permission to update products.');
    }

    if (Auth::user()->isRental() && $product->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action. You can only update your own products.');
    }

    $messages = [
        // ... pesan validasi yang ada ...
        'rental_user_id.required_if' => 'Pemilik rental wajib dipilih untuk admin.',
        'rental_user_id.exists' => 'Pemilik rental yang dipilih tidak valid.',
    ];

    $attributes = [
        // ... atribut validasi yang ada ...
        'rental_user_id' => 'Pemilik Rental',
    ];

    $rules = [
        // ... rules validasi yang ada ...
    ];

    // Tambahkan validasi untuk rental_user_id jika admin
    if (Auth::user()->isAdmin()) {
        $rules['rental_user_id'] = 'required|exists:users,id,role,rental';
    }

    $validated = $request->validate($rules, $messages, $attributes);

    try {
        $validated['is_available'] = $request->has('is_available') ? true : false;

        // Hitung harga mingguan dan bulanan
        $validated['harga_mingguan'] = $validated['harga_harian'] * (7 - $validated['diskon_mingguan']);
        $validated['harga_bulanan'] = $validated['harga_harian'] * (30 - $validated['diskon_bulanan']);

        // Jika admin, update user_id dari rental_user_id
        if (Auth::user()->isAdmin()) {
            $validated['user_id'] = $validated['rental_user_id'];
        }

        // Handle file uploads
        if ($request->hasFile('gambar_utama')) {
            // Hapus file lama jika ada
            if ($product->gambar_utama && Storage::disk('public')->exists($product->gambar_utama)) {
                Storage::disk('public')->delete($product->gambar_utama);
            }
            $validated['gambar_utama'] = $request->file('gambar_utama')->store('product_images', 'public');
        } else {
            $validated['gambar_utama'] = $product->gambar_utama;
        }

        if ($request->hasFile('foto_stnk')) {
            // Hapus file lama jika ada
            if ($product->foto_stnk && Storage::disk('public')->exists($product->foto_stnk)) {
                Storage::disk('public')->delete($product->foto_stnk);
            }
            $validated['foto_stnk'] = $request->file('foto_stnk')->store('stnk_images', 'public');
        } else {
            $validated['foto_stnk'] = $product->foto_stnk;
        }

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
        if (!Auth::user()->canAccessDashboard()) {
            abort(403, 'Unauthorized action. You do not have permission to delete products.');
        }

        if (Auth::user()->isRental() && $product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. You can only delete your own products.');
        }

        try {
            // Delete associated files
            if ($product->gambar_utama && Storage::disk('public')->exists($product->gambar_utama)) {
                Storage::disk('public')->delete($product->gambar_utama);
            }
            if ($product->foto_stnk && Storage::disk('public')->exists($product->foto_stnk)) {
                Storage::disk('public')->delete($product->foto_stnk);
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
