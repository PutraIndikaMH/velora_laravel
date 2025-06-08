<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HistoryController extends Controller
{
    public function history()
    {
        $history = History::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil data pengguna
        $user = Auth::user();

        // Kirim ke view
        return view('history', compact('history', 'user'));
    }

    public function destroy($id)
    {
        try {
            // Find the history item
            $historyItem = History::findOrFail($id);
            
            // Check if the authenticated user owns this history item
            if ($historyItem->user_id !== Auth::id()) {
                return redirect()->route('history')->with('error', 'Unauthorized action.');
            }
            
            // Delete the associated image file if it exists
            if ($historyItem->image_path && Storage::disk('public')->exists('scans/' . basename($historyItem->image_path))) {
                Storage::disk('public')->delete('scans/' . basename($historyItem->image_path));
            }
            
            // Delete the history record
            $historyItem->delete();
            
            return redirect()->route('history')->with('success', 'History item deleted successfully.');
            
        } catch (\Exception $e) {
            return redirect()->route('history')->with('error', 'Failed to delete history item.');
        }
    }

}
