<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $products = [
        [
            'id' => 1,
            'name' => 'Honda Beat',
            'vendor' => 'Ale Sewa Motor',
            'price' => 60000,
            'location' => 'Kramat',
            'image' => 'images/beat.jpg',
            'fuel' => 'Bensin',
            'cc' => '110',
            'transmission' => 'Matic',
            'available' => false,
            'description' => 'Honda Beat, motor matic compact dengan konsumsi bahan bakar irit, cocok untuk aktivitas sehari-hari di dalam kota.',
            'detail_route' => 'frontend.detail1',
        ],
        [
            'id' => 2,
            'name' => 'Honda Vario',
            'vendor' => 'Ale Sewa Motor',
            'price' => 90000,
            'location' => 'Kramat',
            'image' => 'images/vario.jpg',
            'fuel' => 'Bensin',
            'cc' => '150',
            'transmission' => 'Matic',
            'available' => true,
            'description' => 'Motor matic Honda Vario dengan performa handal, nyaman untuk perjalanan dalam kota dengan konsumsi bahan bakar irit.',
            'detail_route' => 'frontend.detail2',
        ],
        [
            'id' => 3,
            'name' => 'Honda Scoopy',
            'vendor' => 'Sewa Motor ASRI TIGA',
            'price' => 60000,
            'location' => 'Tegal Timur',
            'image' => 'images/scoopy.jpg',
            'fuel' => 'Bensin',
            'cc' => '110',
            'transmission' => 'Matic',
            'available' => true,
            'description' => 'Honda Scoopy, motor compact dan mudah dikendarai, cocok untuk pemula dan aktivitas sehari-hari.',
            'detail_route' => 'frontend.detail3',
        ],
        [
            'id' => 4,
            'name' => 'Yamaha Aerox 2018',
            'vendor' => 'Lavanya Motor',
            'price' => 80000,
            'location' => 'Tegal Timur',
            'image' => 'images/aerox1.png',
            'fuel' => 'Bensin',
            'cc' => '155',
            'transmission' => 'Matic',
            'available' => true,
            'description' => 'Yamaha Aerox 2018, motor sporty dengan tenaga besar dan desain modern untuk para pecinta kecepatan.',
            'detail_route' => 'frontend.detail4',
        ],
        [
            'id' => 5,
            'name' => 'Yamaha NMAX 2021',
            'vendor' => 'Sewa Motor ASRI TIGA',
            'price' => 100000,
            'location' => 'Tegal Timur',
            'image' => 'images/nmax21.png',
            'fuel' => 'Bensin',
            'cc' => '155',
            'transmission' => 'Matic',
            'available' => true,
            'description' => 'Yamaha NMAX 2021, skuter matic dengan kenyamanan dan performa tinggi, ideal untuk perjalanan jauh.',
            'detail_route' => 'frontend.detail5',
        ],
        [
            'id' => 6,
            'name' => 'Honda PCX 2023',
            'vendor' => 'Sewa Motor ASRI TIGA',
            'price' => 100000,
            'location' => 'Tegal Timur',
            'image' => 'images/pcx23.jpeg',
            'fuel' => 'Bensin',
            'cc' => '160',
            'transmission' => 'Matic',
            'available' => true,
            'description' => 'Honda PCX terbaru tahun 2023 dengan teknologi terbaru dan desain elegan, cocok untuk gaya hidup modern.',
            'detail_route' => 'frontend.detail6',
        ],
    ];

    // Method public untuk mengakses data produk dari controller lain
    public function getProducts()
    {
        return $this->products;
    }

    public function index()
    {
        return view('frontend.product', [
            'products' => $this->products
        ]);
    }

    public function detail($id)
    {
        $product = collect($this->products)->firstWhere('id', $id);
        if (!$product) {
            abort(404);
        }

        // Produk rekomendasi: semua produk selain yang sedang dilihat
        $recommendations = collect($this->products)
            ->where('id', '!=', $id)
            ->take(3)
            ->all();

        return view('frontend.detail', compact('product', 'recommendations'));
    }

    public function order($id)
    {
        $product = collect($this->products)->firstWhere('id', $id);
        if (!$product) {
            abort(404);
        }

        return view('frontend.order', compact('product'));
    }

    public function submitOrder(Request $request)
    {
        // Validasi dummy
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'start_date' => 'required|date',
            'days' => 'required|integer|min:1',
            'product_id' => 'required|integer',
        ]);

        // Ambil data produk dari dummy list
        $product = collect($this->products)->firstWhere('id', $request->product_id);
        if (!$product) {
            abort(404);
        }

        $total = $product['price'] * $validated['days'];

        return view('frontend.order_confirmation', [
            'order' => $validated,
            'product' => $product,
            'total' => $total,
        ]);
    }
}
