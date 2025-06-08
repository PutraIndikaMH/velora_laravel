<?php

namespace App\Http\Controllers;

use App\Services\AIApiService;
use App\Models\History;
use App\Models\Room;
use App\Models\ConsultationChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    protected $aiApiService;

    public function __construct(AIApiService $aiApiService)
    {
        $this->aiApiService = $aiApiService;
    }

    public function index(Request $request)
    {
        $historyId = $request->get('history_id');
        $consultationChats = collect();
        $roomId = null;
        
        if ($historyId) {
            $history = History::where('id', $historyId)
                ->where('user_id', Auth::id())
                ->first();
                
            if ($history) {
                // Cari atau buat room untuk history ini
                $room = Room::firstOrCreate([
                    'history_id' => $historyId,
                    'user_id' => Auth::id()
                ]);
                
                $roomId = $room->id;
                
                // Ambil chat history dari room ini
                $consultationChats = ConsultationChat::where('room_id', $room->id)
                    ->orderBy('created_at', 'asc')
                    ->get();
            }
        }
        
        return view('services', compact('consultationChats', 'historyId', 'roomId'));
    }

   public function handleChat(Request $request)
{
    try {
        $request->validate([
            'message' => 'required|string|max:1000',
            'history_id' => 'nullable|exists:histories,id',
            'room_id' => 'nullable|exists:rooms,id'
        ]);

        $message = $request->input('message');
        $historyId = $request->input('history_id');
        $roomId = $request->input('room_id');
        
        // Get user's latest skin type and skin condition from history
        if ($historyId) {
            $latestHistory = History::where('id', $historyId)
                ->where('user_id', Auth::id())
                ->first();
        } else {
            $latestHistory = History::where('user_id', Auth::id())
                ->latest()
                ->first();
        }
        
        if (!$latestHistory) {
            // KEMBALIKAN TEKS PLAIN BUKAN HTML!
            return response('Tidak ada history scan ditemukan. Silakan lakukan scan terlebih dahulu.', 400)
                ->header('Content-Type', 'text/plain');
        }

        // Cari atau buat room jika belum ada
        if (!$roomId && $historyId) {
            $room = Room::firstOrCreate([
                'history_id' => $historyId,
                'user_id' => Auth::id()
            ]);
            $roomId = $room->id;
        }

        $skinType = $latestHistory->skin_type ?? 'Normal';
        $skinCondition = $latestHistory->skin_condition ?? 'Tidak Berjerawat'; 

        // Simpan pesan user
        if ($roomId) {
            ConsultationChat::create([
                'user_id' => Auth::id(),
                'room_id' => $roomId,
                'message' => $message,
                'is_from_bot' => false,
                'history_id' => $latestHistory->id
            ]);
        }

        // Get response from AI chatbot
        $response = $this->aiApiService->chatbot($message, $skinType, $skinCondition);

        // Simpan respons bot
        if ($roomId) {
            ConsultationChat::create([
                'user_id' => Auth::id(),
                'room_id' => $roomId,
                'message' => $response,
                'is_from_bot' => true,
                'history_id' => $latestHistory->id
            ]);
        }

        // PASTIKAN RESPONSE TETAP TEXT PLAIN
        return response($response, 200, ['Content-Type' => 'text/plain']);
        
    } catch (\Exception $e) {
        // Tangani error dengan response text
        return response('Maaf, terjadi kesalahan internal. Silakan coba lagi nanti.', 500)
            ->header('Content-Type', 'text/plain');
    }
}
}