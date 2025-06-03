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
        $skinType = $skinTypes[0];

        $history = History::create([
            'user_id' => Auth::id(),
            'image_path' => $imagePath,
            'skin_type' => $skinType,
        ]);

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
                    'link' => 'https://shorturl.at/6xrrM'
                ],
                [
                    'nama' => 'Moisture Boost Serum',
                    'brand' => 'DermaCare',
                    'harga' => 250000,
                    'deskripsi' => 'Serum intensif dengan hyaluronic acid',
                    'image' => 'images/products/moisture_boost_serum.png',
                    'link' => 'https://www.tokopedia.com/rekomendasi/16547506847',
                ]
            ],
            'Berminyak' => [
                [
                    'nama' => 'Oil Control Toner',
                    'brand' => 'PureClean',
                    'harga' => 120000,
                    'deskripsi' => 'Toner untuk mengurangi minyak berlebih',
                    'image' => 'images/products/oil_control_toner.jpeg',
                    'link' => 'https://shorturl.at/6xrrM',
                ]
            ],
            'Kombinasi' => [
                [
                    'nama' => 'Balanced Moisturizer',
                    'brand' => 'SkinBalance',
                    'harga' => 180000,
                    'deskripsi' => 'Pelembab seimbang untuk kulit kombinasi',
                    'image' => 'images/products/balanced_moisturizer.jpeg',
                    'link' => 'https://shorturl.at/6xrrM',
                ]
            ],
            'Normal' => [
                [
                    'nama' => 'Gentle Daily Cream',
                    'brand' => 'NaturalGlow',
                    'harga' => 200000,
                    'deskripsi' => 'Krim harian untuk kulit normal',
                    'image' => 'images/products/gentle_daily_cream.jpeg',
                    'link' => 'https://shorturl.at/6xrrM',
                ]
            ]
        ];

        return $recommendations[$skinType] ?? [];
    }
}
