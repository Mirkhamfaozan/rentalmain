<?php

namespace App\Http\Controllers;

use App\Models\RentalBiodata;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontRentalController extends Controller
{
    /**
     * Display a listing of verified rentals.
     *
     * @return \Illuminate\View\View
     */
    public function rentalList()
    {
        // Ambil hanya data rental yang sudah terverifikasi dengan pagination
        $rentals = RentalBiodata::forRental()
                    ->verified() // Hanya yang status verifikasinya 'terverifikasi'
                    ->paginate(12);

        return view('frontend.rental_list', compact('rentals'));
    }

    /**
     * Display products for a specific verified rental.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function rentalProfile($id)
    {
        // Hanya tampilkan rental profile yang sudah terverifikasi
        $rentalProfile = RentalBiodata::forRental()
                        ->verified()
                        ->findOrFail($id);

        // Fetch products for the user associated with this rental profile
        $products = Product::where('user_id', $rentalProfile->user_id)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('frontend.rental_profile', compact('rentalProfile', 'products'));
    }
}
