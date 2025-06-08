<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {  // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email', // menambahkan validasi email
            'password' => 'required',
        ]);

        // Cek kredensial
        if (Auth::attempt($credentials)) {
            // Mengambil pengguna yang login
            $user = Auth::user();

            // Cek apakah user adalah admin
            if ($user->email === 'admin@admin' && $request->password === 'admin123') {
                // Redirect ke rute admin produk
                return redirect()->route('produk.index');
            }

            // Redirect ke halaman yang diinginkan untuk pengguna biasa
            return redirect()->intended('/'); // Ganti dengan rute yang sesuai untuk pengguna biasa
        }

        // Jika autentikasi gagal, kembali ke halaman login
        return redirect()->route('login')
            ->withErrors(['email' => 'Email atau password salah.'])
            ->withInput();
    }



    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Custom validation messages
        $messages = [
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password harus terdiri dari minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'nama.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'jenis_kelamin.required' => 'Pilih jenis kelamin.',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi.',
            'tanggal_lahir.date' => 'Tanggal lahir tidak valid.',
        ];

        // Validate the request data
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'jenis_kelamin' => 'required|in:pria,wanita',
            'tanggal_lahir' => 'required|date',
            'password' => 'required|string|min:6|confirmed', // confirmed rule for password
        ], $messages);

        // Create the user if validation passes
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Silakan login.');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('home');
    }



    public function edit_profile($id)
    {

        $user = User::find($id);

        if (!$user) {
            return redirect()->route('some.route.name')->with('error', 'User not found.');
        }

        return view('edit_profile', compact('user'));
    }

    public function update_profile(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:pria,wanita',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'tanggal_lahir' => 'required|date',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::find(Auth::id());

        $user->nama = $validatedData['nama'];
        $user->jenis_kelamin = $validatedData['jenis_kelamin'];
        $user->email = $validatedData['email'];
        $user->tanggal_lahir = $validatedData['tanggal_lahir'];

        if (!empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }

        $user->save();

        return redirect()->route('edit_profile', $user->id)->with('success', 'Profil berhasil diperbarui.');
    }
}
