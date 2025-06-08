<?php

namespace App\Http\Controllers;

use App\Services\AIApiService;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    protected $aiApiService;

    public function __construct(AIApiService $aiApiService)
    {
        $this->aiApiService = $aiApiService;
    }

    public function index()
    {
        return view('services');
    }

 public function handleChat(Request $request)
{
    $request->validate([
        'message' => 'required|string|max:1000'
    ]);

    $message = $request->input('message');
    
    // Get user's latest skin type and skin condition from history
    $latestHistory = History::where('user_id', Auth::id())
        ->latest()
        ->first();
    
    $skinType = $latestHistory ? $latestHistory->skin_type : 'Normal';
    $skinCondition = $latestHistory ? $latestHistory->skin_condition : 'Tidak Berjerawat'; 

    // Get response from AI chatbot
    $response = $this->aiApiService->chatbot($message, $skinType, $skinCondition);

    return response($response, 200, ['Content-Type' => 'text/plain']);
}
}