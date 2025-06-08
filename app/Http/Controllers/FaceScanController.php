<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\ProductRecommendation;
use App\Models\Product;
use App\Services\AIApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FaceScanController extends Controller
{
    protected $aiApiService;

    public function __construct(AIApiService $aiApiService)
    {
        $this->aiApiService = $aiApiService;
    }

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
            $recommendedProducts = ProductRecommendation::where('history_id', $history->id)
                ->join('products', 'product_recommendations.product_id', '=', 'products.id')
                ->select('products.*')
                ->get();
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
    $fullImagePath = storage_path('app/public/' . $imagePath);

    try {
        // Predict skin type using AI API
        $skinType = $this->aiApiService->predictSkinType($fullImagePath);

        // Convert English to Indonesian
        $skinTypeMapping = [
            'dry' => 'Kering',
            'oily' => 'Berminyak',
            'normal' => 'Normal'
        ];
        $skinType = $skinTypeMapping[$skinType] ?? 'Normal';
        
        // Detect objects for analysis and get the detected image
        $objectDetection = $this->aiApiService->detectObjects($fullImagePath);

        // Initialize skin condition with default value
        $skinCondition = 'Tidak Berjerawat'; // Default value

        // Extract skin condition from API response
        if ($objectDetection && isset($objectDetection['skin_condition'])) {
            $skinCondition = $objectDetection['skin_condition'];
        }

        // If object detection returns a detected image, replace the original
        if ($objectDetection && isset($objectDetection['image'])) {
            // Decode base64 image
            $detectedImageData = base64_decode($objectDetection['image']);

            // Create new filename for detected image with bounding boxes
            $originalName = pathinfo($imagePath, PATHINFO_FILENAME);
            $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
            $detectedImagePath = 'scans/' . $originalName . '_detected.' . $extension;
            $detectedImageFullPath = storage_path('app/public/' . $detectedImagePath);

            // Save the detected image with bounding boxes
            file_put_contents($detectedImageFullPath, $detectedImageData);

            // Use detected image path for display
            $displayImagePath = $detectedImagePath;
        } else {
            // Use original image if detection failed
            $displayImagePath = $imagePath;
        }

        // Store detection results if needed
        $detectionData = $objectDetection ? json_encode($objectDetection) : null;
    } catch (\Exception $e) {
        Log::error('AI Analysis failed: ' . $e->getMessage());
        $skinType = 'Normal'; // Fallback
        $detectionData = null;
        $displayImagePath = $imagePath; // Use original image on error
    }

    $history = History::create([
        'user_id' => Auth::id(),
        'image_path' => $displayImagePath, // Store the detected image path
        'skin_type' => $skinType,
        'skin_condition' => $skinCondition, // Add skin condition if needed
        'detection_data' => $detectionData,
    ]);

    $matchingProducts = Product::where('skin_type', 'LIKE', '%' . $skinType . '%')->get();

    // Create recommendations for each matching product
    foreach ($matchingProducts as $product) {
        ProductRecommendation::create([
            'history_id' => $history->id,
            'product_id' => $product->id,
        ]);
    }

    // Redirect ke halaman rekomendasi dengan menambahkan history_id
    return redirect()->route('scan', ['history_id' => $history->id])
        ->with('message', 'Analysis complete, recommendations updated!');
}
}
