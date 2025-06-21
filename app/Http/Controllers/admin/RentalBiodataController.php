<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\RentalBiodata;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class RentalBiodataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorizeAdmin();

        $query = RentalBiodata::query()->forRental();

        // Apply filters with better search performance
        $this->applyFilters($query, $request);

        $biodatas = $query->with(['user:id,name,email', 'verifiedBy:id,name'])
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.rental_biodata.index', [
            'biodatas' => $biodatas,
            'statusOptions' => RentalBiodata::getStatusOptions(),
            'filters' => $request->only(['search', 'status', 'kota', 'provinsi']),
            'totalCounts' => $this->getStatusCounts()
        ]);
    }

    /**
     * Apply filters to the query.
     */
    private function applyFilters($query, Request $request): void
    {
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_rental', 'like', $searchTerm)
                    ->orWhere('nama_pemilik', 'like', $searchTerm)
                    ->orWhere('email_perusahaan', 'like', $searchTerm)
                    ->orWhere('no_telepon', 'like', $searchTerm)
                    ->orWhere('kota', 'like', $searchTerm)
                    ->orWhere('provinsi', 'like', $searchTerm);
            });
        }

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('kota')) {
            $query->where('kota', 'like', '%' . $request->kota . '%');
        }

        if ($request->filled('provinsi')) {
            $query->where('provinsi', 'like', '%' . $request->provinsi . '%');
        }
    }

    /**
     * Get status counts for dashboard.
     */
    private function getStatusCounts(): array
    {
        return [
            'total' => RentalBiodata::forRental()->count(),
            'pending' => RentalBiodata::forRental()->unverified()->count(),
            'verified' => RentalBiodata::forRental()->verified()->count(),
            'rejected' => RentalBiodata::forRental()->rejected()->count(),
        ];
    }

    public function show($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action. You do not have permission to access this page.');
        }

        $biodata = RentalBiodata::forRental()->findOrFail($id);

        return view('admin.rental_biodata.show', compact('biodata'));
    }

    public function create(): View
    {
        $this->authorizeAdmin();

        $users = User::where('role', 'rental')
            ->whereDoesntHave('rentalBiodata')
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('admin.rental_biodata.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $this->validateRequest($request);

        try {
            DB::transaction(function () use ($request, $validated) {
                // Check if user already has biodata
                $this->checkUserBiodataExists($request->user_id);

                $biodata = new RentalBiodata($validated);
                $biodata->user_id = $request->user_id;
                $biodata->status_verifikasi = RentalBiodata::STATUS_BELUM_VERIFIKASI;

                // Handle file uploads
                $this->handleFileUploads($request, $biodata);

                $biodata->save();

                Log::info('Rental biodata created successfully', [
                    'biodata_id' => $biodata->id,
                    'user_id' => $biodata->user_id,
                    'admin_id' => Auth::id()
                ]);
            });

            return redirect()->route('dashboard.rental_biodata.index')
                ->with('success', 'Biodata rental berhasil dibuat.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'membuat');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RentalBiodata $biodata): View
    {
        $this->authorizeAdmin();

        $biodata->load('user:id,name,email');

        $users = User::where('role', 'rental')
            ->where(function ($query) use ($biodata) {
                $query->whereDoesntHave('rentalBiodata')
                    ->orWhere('id', $biodata->user_id);
            })
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('admin.rental_biodata.edit', [
            'biodata' => $biodata,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RentalBiodata $biodata): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $this->validateRequest($request, $biodata->id);

        try {
            DB::transaction(function () use ($request, $validated, $biodata) {
                // Check if changing user and new user already has biodata
                if ($request->user_id != $biodata->user_id) {
                    $this->checkUserBiodataExists($request->user_id, $biodata->id);
                }

                $biodata->fill($validated);
                $biodata->user_id = $request->user_id;

                // Handle file uploads
                $this->handleFileUploads($request, $biodata, true);

                $biodata->save();

                Log::info('Rental biodata updated successfully', [
                    'biodata_id' => $biodata->id,
                    'admin_id' => Auth::id()
                ]);
            });

            return redirect()->route('dashboard.rental_biodata.index')
                ->with('success', 'Biodata rental berhasil diperbarui.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'memperbarui');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RentalBiodata $biodata): RedirectResponse
    {
        $this->authorizeAdmin();

        try {
            DB::transaction(function () use ($biodata) {
                // Delete associated files
                $this->deleteFiles($biodata);

                $biodata->delete();

                Log::info('Rental biodata deleted successfully', [
                    'biodata_id' => $biodata->id,
                    'admin_id' => Auth::id()
                ]);
            });

            return redirect()->route('dashboard.rental_biodata.index')
                ->with('success', 'Biodata rental berhasil dihapus.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'menghapus');
        }
    }

    /**
     * Verify the rental biodata.
     */
    public function verify(Request $request, RentalBiodata $biodata): RedirectResponse
    {
        $this->authorizeAdmin();

        if (!$biodata->canVerify(Auth::user())) {
            abort(403, 'Biodata tidak dapat diverifikasi saat ini.');
        }

        $validated = $request->validate([
            'catatan_verifikasi' => 'nullable|string|max:1000',
        ]);

        try {
            DB::transaction(function () use ($biodata, $validated) {
                $success = $biodata->verify(Auth::user(), $validated['catatan_verifikasi'] ?? null);

                if (!$success) {
                    throw new \Exception('Gagal memverifikasi biodata rental.');
                }

                Log::info('Rental biodata verified', [
                    'biodata_id' => $biodata->id,
                    'admin_id' => Auth::id()
                ]);
            });

            return redirect()->route('dashboard.rental_biodata.show', $biodata)
                ->with('success', 'Biodata rental berhasil diverifikasi.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'memverifikasi');
        }
    }

    public function showRejectForm(RentalBiodata $biodata)
    {
        $this->authorizeAdmin();

        if (!$biodata->canVerify(Auth::user())) {
            abort(403, 'Biodata tidak dapat ditolak saat ini.');
        }

        return view('admin.rental_biodata.reject', compact('biodata'));
    }

    /**
     * Reject the rental biodata
     */
    public function reject(Request $request, RentalBiodata $biodata)
    {
        $this->authorizeAdmin();

        if (!$biodata->canVerify(Auth::user())) {
            abort(403, 'Biodata tidak dapat ditolak saat ini.');
        }

        $validated = $request->validate([
            'catatan_verifikasi' => 'required|string|max:1000',
        ], [
            'catatan_verifikasi.required' => 'Alasan penolakan wajib diisi',
            'catatan_verifikasi.max' => 'Alasan penolakan maksimal 1000 karakter'
        ]);

        try {
            DB::transaction(function () use ($biodata, $validated) {
                $success = $biodata->reject(Auth::user(), $validated['catatan_verifikasi']);

                if (!$success) {
                    throw new \Exception('Gagal menolak biodata rental.');
                }

                Log::info('Rental biodata rejected', [
                    'biodata_id' => $biodata->id,
                    'admin_id' => Auth::id(),
                    'reason' => $validated['catatan_verifikasi']
                ]);
            });

            return redirect()->route('dashboard.rental_biodata.show', $biodata)
                ->with('success', 'Biodata rental berhasil ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menolak biodata: ' . $e->getMessage());
        }
    }

    /**
     * Reset verification status.
     */
    public function resetVerification(RentalBiodata $biodata): RedirectResponse
    {
        $this->authorizeAdmin();

        try {
            DB::transaction(function () use ($biodata) {
                $biodata->resetVerification();

                Log::info('Rental biodata verification reset', [
                    'biodata_id' => $biodata->id,
                    'admin_id' => Auth::id()
                ]);
            });

            return redirect()->route('dashboard.rental_biodata.show', $biodata)
                ->with('success', 'Status verifikasi biodata rental berhasil direset.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'mereset verifikasi');
        }
    }

    /**
     * Download document file.
     */
    public function downloadDocument(RentalBiodata $biodata, string $type): BinaryFileResponse
    {
        $this->authorizeAdmin();

        $fileInfo = $this->getDocumentFileInfo($biodata, $type);

        if (!$fileInfo['path'] || !Storage::disk('public')->exists($fileInfo['path'])) {
            abort(404, 'File tidak ditemukan.');
        }

        $fileExtension = pathinfo($fileInfo['path'], PATHINFO_EXTENSION);
        $downloadName = $fileInfo['name'] . '.' . $fileExtension;

        Log::info('Document downloaded', [
            'biodata_id' => $biodata->id,
            'document_type' => $type,
            'admin_id' => Auth::id()
        ]);

        return Storage::disk('public')->download($fileInfo['path'], $downloadName);
    }

    /**
     * Get document file information.
     */
    private function getDocumentFileInfo(RentalBiodata $biodata, string $type): array
    {
        return match ($type) {
            'ktp' => [
                'path' => $biodata->foto_ktp,
                'name' => "KTP_{$biodata->nama_pemilik}_{$biodata->id}"
            ],
            'business_license' => [
                'path' => $biodata->foto_surat_izin_usaha,
                'name' => "Surat_Izin_Usaha_{$biodata->nama_rental}_{$biodata->id}"
            ],
            'business_place' => [
                'path' => $biodata->foto_tempat,
                'name' => "Foto_Tempat_{$biodata->nama_rental}_{$biodata->id}"
            ],
            default => throw new \InvalidArgumentException('Tipe dokumen tidak valid.')
        };
    }

    /**
     * Bulk verify multiple biodata.
     */
    public function bulkVerify(Request $request): JsonResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'biodata_ids' => 'required|array|min:1',
            'biodata_ids.*' => 'exists:rental_biodata,id',
            'catatan_verifikasi' => 'nullable|string|max:1000',
        ]);

        try {
            $processed = 0;
            $failed = 0;

            DB::transaction(function () use ($validated, &$processed, &$failed) {
                $biodatas = RentalBiodata::whereIn('id', $validated['biodata_ids'])
                    ->where('status_verifikasi', RentalBiodata::STATUS_BELUM_VERIFIKASI)
                    ->get();

                foreach ($biodatas as $biodata) {
                    if ($biodata->verify(Auth::user(), $validated['catatan_verifikasi'] ?? null)) {
                        $processed++;
                    } else {
                        $failed++;
                    }
                }
            });

            Log::info('Bulk verification completed', [
                'processed' => $processed,
                'failed' => $failed,
                'admin_id' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => "Berhasil memverifikasi {$processed} biodata. {$failed} gagal diproses.",
                'processed' => $processed,
                'failed' => $failed
            ]);
        } catch (\Exception $e) {
            Log::error('Bulk verification failed', [
                'error' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan verifikasi massal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if user already has biodata.
     */
    private function checkUserBiodataExists(int $userId, ?int $excludeId = null): void
    {
        $query = RentalBiodata::where('user_id', $userId);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        if ($query->exists()) {
            throw new \Exception('User sudah memiliki biodata rental.');
        }
    }

    /**
     * Validate request data.
     */
    private function validateRequest(Request $request, ?int $biodataId = null): array
    {
        return $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $user = User::find($value);
                    if (!$user || $user->role !== 'rental') {
                        $fail('User yang dipilih harus memiliki role rental.');
                    }
                }
            ],
            'nama_rental' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255',
            'email_perusahaan' => [
                'required',
                'email',
                'max:255',
                $biodataId ? Rule::unique('rental_biodata')->ignore($biodataId) : 'unique:rental_biodata,email_perusahaan'
            ],
            'alamat' => 'required|string|max:1000',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:10|regex:/^[0-9]+$/',
            'no_telepon' => 'required|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'no_wa' => 'nullable|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'foto_ktp' => $biodataId ? 'nullable|file|mimes:jpg,jpeg,png|max:2048' : 'required|file|mimes:jpg,jpeg,png|max:2048',
            'foto_surat_izin_usaha' => $biodataId ? 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120' : 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'foto_tempat' => 'nullable|file|mimes:jpg,jpeg,png|max:3072',
        ], [
            'user_id.required' => 'User harus dipilih.',
            'user_id.exists' => 'User yang dipilih tidak valid.',
            'nama_rental.required' => 'Nama rental wajib diisi.',
            'nama_pemilik.required' => 'Nama pemilik wajib diisi.',
            'email_perusahaan.required' => 'Email perusahaan wajib diisi.',
            'email_perusahaan.email' => 'Format email tidak valid.',
            'email_perusahaan.unique' => 'Email perusahaan sudah digunakan.',
            'alamat.required' => 'Alamat wajib diisi.',
            'kota.required' => 'Kota wajib diisi.',
            'provinsi.required' => 'Provinsi wajib diisi.',
            'kode_pos.required' => 'Kode pos wajib diisi.',
            'kode_pos.regex' => 'Kode pos hanya boleh berisi angka.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'no_telepon.regex' => 'Format nomor telepon tidak valid.',
            'no_wa.regex' => 'Format nomor WhatsApp tidak valid.',
            'foto_ktp.required' => 'Foto KTP wajib diunggah.',
            'foto_ktp.mimes' => 'Foto KTP harus berformat JPG, JPEG, atau PNG.',
            'foto_ktp.max' => 'Ukuran foto KTP maksimal 2MB.',
            'foto_surat_izin_usaha.required' => 'Surat izin usaha wajib diunggah.',
            'foto_surat_izin_usaha.mimes' => 'Surat izin usaha harus berformat PDF, JPG, JPEG, atau PNG.',
            'foto_surat_izin_usaha.max' => 'Ukuran surat izin usaha maksimal 5MB.',
            'foto_tempat.mimes' => 'Foto tempat harus berformat JPG, JPEG, atau PNG.',
            'foto_tempat.max' => 'Ukuran foto tempat maksimal 3MB.',
        ]);
    }

    /**
     * Handle file uploads.
     */
    private function handleFileUploads(Request $request, RentalBiodata $biodata, bool $isUpdate = false): void
    {
        $fileFields = [
            'foto_ktp' => 'ktp',
            'foto_surat_izin_usaha' => 'business_license',
            'foto_tempat' => 'business_place'
        ];

        foreach ($fileFields as $field => $type) {
            if ($request->hasFile($field)) {
                if ($isUpdate) {
                    $this->deleteFile($biodata->$field);
                }
                $biodata->$field = $this->storeFile($request->file($field), $type);
            }
        }
    }

    /**
     * Store uploaded file with proper naming.
     */
    private function storeFile($file, string $type): string
    {
        $timestamp = now()->format('YmdHis');
        $extension = $file->getClientOriginalExtension();
        $fileName = "{$type}_{$timestamp}_{uniqid()}.{$extension}";

        return $file->storeAs('rental_documents', $fileName, 'public');
    }

    /**
     * Delete existing file.
     */
    private function deleteFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Delete all files associated with biodata.
     */
    private function deleteFiles(RentalBiodata $biodata): void
    {
        $this->deleteFile($biodata->foto_ktp);
        $this->deleteFile($biodata->foto_surat_izin_usaha);
        $this->deleteFile($biodata->foto_tempat);
    }

    /**
     * Check if user is admin.
     */
    private function authorizeAdmin(): void
    {
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action. Admin access required.');
        }
    }

    /**
     * Handle exceptions and return redirect response.
     */
    private function handleException(\Exception $e, string $action): RedirectResponse
    {
        Log::error("Rental biodata {$action} failed", [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'user_id' => Auth::id(),
            'timestamp' => now()
        ]);

        $message = "Gagal {$action} biodata rental";

        // Add specific error message for common exceptions
        if (str_contains($e->getMessage(), 'unique')) {
            $message .= ': Data sudah ada dalam sistem.';
        } elseif (str_contains($e->getMessage(), 'file')) {
            $message .= ': Gagal mengunggah file.';
        } elseif (str_contains($e->getMessage(), 'User sudah memiliki')) {
            $message .= ': ' . $e->getMessage();
        } else {
            $message .= ': ' . $e->getMessage();
        }

        return redirect()->back()
            ->withInput()
            ->with('error', $message);
    }
}
