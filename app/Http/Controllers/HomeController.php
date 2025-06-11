<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\RentalBiodata;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch latest available products
        $products = Product::where('is_available', true)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Fetch rental profiles
        $rentalProfiles = RentalBiodata::forRental()
            ->orderBy('created_at', 'desc')
            ->take(3) // Limit to 3 rental profiles
            ->get();

        return view('frontend.homepage', compact('products', 'rentalProfiles'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function detail($id)
    {
        $product = Product::findOrFail($id);

        // Fetch recommendations (e.g., other available products, excluding the current one)
        $recommendations = Product::where('is_available', true)
            ->where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('frontend.detail', compact('product', 'recommendations'));
    }

    public function carasewa()
    {
        return view('frontend.carasewa');
    }

    public function tentang()
    {
        return view('frontend.rental_tentang');
    }

    public function detail4($id)
    {
        $product = Product::findOrFail($id);
        return view('frontend.rental_sewa', compact('product'));
    }

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
