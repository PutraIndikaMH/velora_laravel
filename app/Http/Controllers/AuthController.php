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
            // Jika login berhasil, redirect ke halaman yang diinginkan
           return view('home');
        } else {
            // Jika login gagal, redirect kembali ke halaman login dengan pesan error
            return redirect()->route('login')
                ->withErrors(['email' => 'Email atau password salah.'])
                ->withInput();
        }

    }
}