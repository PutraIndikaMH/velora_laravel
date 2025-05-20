<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

     public function register(Request $request)
    {
         $input = $request->all();

         User::create([
             'nama' => $input['nama'],
             'email' => $input['email'],
             'jenis_kelamin' => $input['jenis_kelamin'],
             'tanggal_lahir' => $input['tanggal_lahir'],
             'password' => Hash::make($input['password']),
         ]);
         return redirect()->route('login')
             ->with('success', 'Pendaftaran berhasil! Silakan login.');
    }

}
