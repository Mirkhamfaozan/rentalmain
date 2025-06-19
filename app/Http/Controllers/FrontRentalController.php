<?php

namespace App\Http\Controllers;

use App\Models\RentalBiodata;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontRentalController extends Controller
{
    /**
     * Display a listing of rentals.
     *
     * @return \Illuminate\View\View
     */
    public function rentalList()
    {
        // Ambil semua data rental yang memiliki role 'rental' dengan pagination
        $rentals = RentalBiodata::forRental()->paginate(12);

        // Kirim data ke view
        return view('frontend.rental_list', compact('rentals'));
    }

    /**
     * Display products for a specific rental.
     *
     * @param  int  $rentalId
     * @return \Illuminate\View\View
     */
    public function rentalProfile($id)
    {
        $rentalProfile = RentalBiodata::forRental()->findOrFail($id);
        // Fetch products for the user associated with this rental profile
        $products = Product::where('user_id', $rentalProfile->user_id)
            ->where('is_available', true)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
        return view('frontend.rental_profile', compact('rentalProfile', 'products'));
    }
}
