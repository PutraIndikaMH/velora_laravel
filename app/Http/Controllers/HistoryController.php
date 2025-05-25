<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function history()
    {
        $history = History::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('history', compact('history'));
    }
}
