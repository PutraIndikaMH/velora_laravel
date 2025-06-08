<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FeedbackContoller extends Controller
{
    public function postFeedback(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Feedback::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }

    public function show_feedback()
    {
        $feedback = Feedback::with('user')->latest()->paginate(10); // include user relation

        return view('admin.feedback', compact('feedback'));
    }
}
