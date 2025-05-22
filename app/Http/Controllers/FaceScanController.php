<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FaceScanController extends Controller
{
     public function index()
    {
        // Jika butuh data riwayat atau informasi tambahan
        $history = History::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('scanning', compact('history'));
    }

     public function upload(Request $request)
    {
        // Validasi input
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Simpan gambar
        $imagePath = $request->file('image')->store('scans', 'public');

        // Dummy analisis
        $skinTypes = ['Kering', 'Berminyak', 'Kombinasi', 'Normal'];
        $skinType = $skinTypes[array_rand($skinTypes)];

        // Dummy produk rekomendasi
        $productRecommendations = $this->getDummyProductRecommendations($skinType);

        // Simpan ke history
        $history = History::create([
            'user_id' => Auth::id(),
            'image_path' => $imagePath,
            'skin_type' => $skinType,
            'analysis_result' => json_encode($productRecommendations)
        ]);

        return response()->json([
            'success' => true,
            'skin_type' => $skinType,
            'recommended_products' => $productRecommendations
        ]);
    }

    private function getDummyProductRecommendations($skinType)
    {
        $recommendations = [
            'Kering' => [
                [
                    'nama' => 'Hydrating Cleanser',
                    'brand' => 'CleanCare',
                    'harga' => 150000,
                    'deskripsi' => 'Pembersih lembut untuk kulit kering'
                ],
                [
                    'nama' => 'Moisture Boost Serum',
                    'brand' => 'DermaCare',
                    'harga' => 250000,
                    'deskripsi' => 'Serum intensif dengan hyaluronic acid'
                ]
            ],
            'Berminyak' => [
                [
                    'nama' => 'Oil Control Toner',
                    'brand' => 'PureClean',
                    'harga' => 120000,
                    'deskripsi' => 'Toner untuk mengurangi minyak berlebih'
                ]
            ],
            'Kombinasi' => [
                [
                    'nama' => 'Balanced Moisturizer',
                    'brand' => 'SkinBalance',
                    'harga' => 180000,
                    'deskripsi' => 'Pelembab seimbang untuk kulit kombinasi'
                ]
            ],
            'Normal' => [
                [
                    'nama' => 'Gentle Daily Cream',
                    'brand' => 'NaturalGlow',
                    'harga' => 200000,
                    'deskripsi' => 'Krim harian untuk kulit normal'
                ]
            ]
        ];

        return $recommendations[$skinType] ?? [];
    }
}
