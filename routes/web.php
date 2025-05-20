<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/history', function () {
    return view('history');
})->name('history');

Route::get('/scanning', function (){
    return view('scanning');
})->name('scanning');

//Route::get('/register', function (){
   // return view('register');
//})->name('register');


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.process');

//Route::get('/login', function (){
    //return view('login');
//})->name('login');

//Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
//Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/services', function (){
    return view('services');
})->name('services');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');


// Rute Home (contoh)
//Route::get('/', function () {
    // Cek apakah user sudah login
   // if (!Session::has('user_id')) {
      //  return redirect()->route('login');
   // }
   // return view('home');
//})->name('home');