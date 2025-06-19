<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\RentalBiodata;

class HomeController extends Controller
{
    public function index()
    {
        // Tampilkan produk terbaru (baik tersedia maupun tidak)
        $products = Product::orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Fetch rental profiles
        $rentalProfiles = RentalBiodata::forRental()
            ->orderBy('created_at', 'desc')
            ->take(3)
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

        // Rekomendasi produk lain (termasuk yang tidak tersedia)
        $recommendations = Product::where('id', '!=', $id)
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

        // Tampilkan semua produk rental (baik tersedia maupun tidak)
        $products = Product::where('user_id', $rentalProfile->user_id)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('frontend.rental_profile', compact('rentalProfile', 'products'));
    }
}
