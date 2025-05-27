<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $productController;

    public function __construct()
    {
        $this->productController = new ProductController();
    }

    public function index()
    {
        // Ambil data produk dari ProductController
        $products = $this->productController->getProducts();

        // Batasi hanya 3 produk untuk ditampilkan di home
        $featuredProducts = collect($products)->take(3)->all();

        return view('frontend.homepage', [
            'products' => $featuredProducts
        ]);
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function detail()
    {
        return view('frontend.detail');
    }

    public function carasewa()
    {
        return view('frontend.carasewa');
    }

    public function tentang()
    {
        return view('frontend.tentang');
    }

    public function detail4()
    {
        return view('frontend.sewa');
    }
}
