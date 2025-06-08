<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIApiService
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('app.ai_api_url', 'http://localhost:5000');
    }

    public function predictSkinType($imagePath)
    {
        try {
            $response = Http::attach(
                'image', 
                file_get_contents($imagePath), 
                basename($imagePath)
            )->post($this->baseUrl . '/predict-skin-type');

            if ($response->successful()) {
                return $response->json()['skin_type'];
            }

            Log::error('AI API Error: ' . $response->body());
            return 'Normal'; // Fallback
        } catch (\Exception $e) {
            Log::error('AI API Exception: ' . $e->getMessage());
            return 'Normal'; // Fallback
        }
    }

    public function detectObjects($imagePath)
    {
        try {
            $response = Http::attach(
                'image', 
                file_get_contents($imagePath), 
                basename($imagePath)
            )->post($this->baseUrl . '/detect-objects');

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Object Detection API Error: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('Object Detection Exception: ' . $e->getMessage());
            return null;
        }
    }

    public function chatbot($query, $skinType = 'Normal', $skinCondition = 'Normal')
    {
        try {
            $response = Http::post($this->baseUrl . '/chatbot', [
                'query' => $query,
                'skin_type' => $skinType,
                'skin_condition' => $skinCondition
            ]);

            if ($response->successful()) {
                return $response->json()['response'];
            }

            Log::error('Chatbot API Error: ' . $response->body());
            return 'Maaf, sistem sedang bermasalah. Silakan coba lagi nanti.';
        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            return 'Maaf, sistem sedang bermasalah. Silakan coba lagi nanti.';
        }
    }
}