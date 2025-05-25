<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('services');
    }
    public function handleChat(Request $request)
    {
        try {
            $message = trim(strtolower($request->input('message')));

            if (empty($message)) {
                return "Pesan tidak boleh kosong.";
            }

            $responses = [
                "kulitku sering perih kalau pakai skincare, kenapa ya?" => "Aku lihat kamu punya masalah kulit kering dan agak sensitif, ya? Yuk kita bahas pelan-pelan...",
                "iya, kadang suka merah juga" => "Sebelum kita lanjut, aku mau tanya sedikit ya, kamu merasa kulitmu makin kering di pagi atau malam hari?",
                "biasanya malam sih kak, apalagi kalau habis mandi." => "Noted ya! Itu bisa jadi karena skin barrier kamu sedang lemah. Tapi jangan khawatir, ini masih bisa dibantu dengan perawatan yang tepat.",
            ];

            return $responses[$message] ?? "Maaf, saya tidak mengerti.";
        } catch (\Exception $e) {
            return "Terjadi kesalahan, silakan coba lagi.";
        }
    }
}
