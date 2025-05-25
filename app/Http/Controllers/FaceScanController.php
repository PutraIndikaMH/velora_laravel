<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\ProductRecommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FaceScanController extends Controller
{
    public function index()
    {
        return view('scanning');
    }

    public function showRecommendations(Request $request)
    {
        // Ambil history_id dari query parameter
        $historyId = $request->query('history_id');

        // Ambil history berdasarkan id yang diberikan
        $history = History::where('id', $historyId)->where('user_id', Auth::id())->first();

        $recommendedProducts = [];
        if ($history) {
            $recommendedProducts = ProductRecommendation::where('history_id', $history->id)->get();
        }

        // Kirimkan data ke view
        return view('template.afterScan', compact('recommendedProducts', 'history'));
    }


    public function upload(Request $request)
    {
        // Validasi input
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Simpan gambar dan ambil path
        $imagePath = $request->file('image')->store('scans', 'public');

        // Tentukan tipe kulit
        $skinTypes = ['Kering', 'Berminyak', 'Kombinasi', 'Normal'];
        $skinType = $skinTypes[array_rand($skinTypes)];

        // Buat entri history
        $history = History::create([
            'user_id' => Auth::id(),
            'image_path' => $imagePath,
            'skin_type' => $skinType,
        ]);

        // Simpan rekomendasi produk ke database
        $productRecommendations = $this->getDummyProductRecommendations($skinType);
        foreach ($productRecommendations as $product) {
            ProductRecommendation::create([
                'history_id' => $history->id,
                'product_name' => $product['nama'],
                'product_category' => $product['brand'],
                'product_description' => $product['deskripsi'],
                'product_price' => $product['harga'],
                'product_image' => $product['image'],
                'recommendation_links' => $product['link'],
            ]);
        }

        // Redirect ke halaman rekomendasi dengan menambahkan history_id
        return redirect()->route('scan', ['history_id' => $history->id])
            ->with('message', 'Analysis complete, recommendations updated!');
    }



    private function getDummyProductRecommendations($skinType)
    {
        $recommendations = [
            'Kering' => [
                [
                    'nama' => 'Hydrating Cleanser',
                    'brand' => 'CleanCare',
                    'harga' => 150000,
                    'deskripsi' => 'Pembersih lembut untuk kulit kering',
                    'image' => 'images/products/hydrating_cleanser.jpeg',
                    'link' => 'https://www.googleadservices.com/pagead/aclk?sa=L&ai=DChcSEwi48dKi3b2NAxUBqmYCHToiKUwYABAMGgJzbQ&co=1&gclid=CjwKCAjw3MXBBhAzEiwA0vLXQYIe2Q4M9r7WosS3WyVsSIqZP59w4_95lOxNguq3r1TEoUR6Y80MKBoCjBkQAvD_BwE&ohost=www.google.com&cid=CAESeeD2KhGPalqzOVHKUoTYpwshhjxntF8qPvgAXLft82we6GMsq9LO3MOK44zrliQuVDyPDreef4Y8_20A82J7h6ou9RAt0wC8Iz8pIrNX0kR6DQ8vF6-D7RtiTbTDnpDvoKt-QZuMZBfH39Nr7cz8NDiYezReDx9GYsI&category=acrcp_v1_0&sig=AOD64_0JIEJ8yOMvdWWrs6KacfsWdxykqw&ctype=5&q=&ved=2ahUKEwjl2s2i3b2NAxWBwjgGHalvL1gQ9aACKAB6BAgFEB4&adurl=',
                ],
                [
                    'nama' => 'Moisture Boost Serum',
                    'brand' => 'DermaCare',
                    'harga' => 250000,
                    'deskripsi' => 'Serum intensif dengan hyaluronic acid',
                    'image' => 'images/products/moisture_boost_serum.png',
                    'link' => 'https://example.com/moisture-boost-serum',
                ]
            ],
            'Berminyak' => [
                [
                    'nama' => 'Oil Control Toner',
                    'brand' => 'PureClean',
                    'harga' => 120000,
                    'deskripsi' => 'Toner untuk mengurangi minyak berlebih',
                    'image' => 'images/products/oil_control_toner.jpeg',
                    'link' => 'https://example.com/oil-control-toner',
                ]
            ],
            'Kombinasi' => [
                [
                    'nama' => 'Balanced Moisturizer',
                    'brand' => 'SkinBalance',
                    'harga' => 180000,
                    'deskripsi' => 'Pelembab seimbang untuk kulit kombinasi',
                    'image' => 'images/products/balanced_moisturizer.jpeg',
                    'link' => 'https://example.com/balanced-moisturizer',
                ]
            ],
            'Normal' => [
                [
                    'nama' => 'Gentle Daily Cream',
                    'brand' => 'NaturalGlow',
                    'harga' => 200000,
                    'deskripsi' => 'Krim harian untuk kulit normal',
                    'image' => 'images/products/gentle_daily_cream.jpeg',
                    'link' => 'https://example.com/gentle-daily-cream',
                ]
            ]
        ];

        return $recommendations[$skinType] ?? [];
    }
}
