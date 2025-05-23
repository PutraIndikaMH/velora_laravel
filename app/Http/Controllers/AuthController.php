<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
       $credentials = $request->validate([
            'email' => 'required','email',
            'password' => 'required',
        ]);

          if (Auth::attempt($credentials)) {
           return redirect()->intended('/');
        } else {
            return redirect()->route('login')
                ->withErrors(['email' => 'Email atau password salah.'])
                ->withInput();
        }

    }

    public function logout() {
        auth()->logout();
        return redirect()->route('home');
    }
}
