<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\FaceScanController;
use App\Http\Controllers\FeedbackContoller;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProductController;

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

Route::get('/produk', [ProductController::class, 'produk'])->name('produk');


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.process');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::middleware(['auth'])->group(function () {
    Route::get('/scanning', [FaceScanController::class, 'index'])->name('scanning');
    Route::post('/upload', [FaceScanController::class, 'upload'])
        ->name('scan.upload');
    Route::get('/scan', [FaceScanController::class, 'showRecommendations'])->name('scan');
    Route::get('/history', [HistoryController::class, 'history'])->name('history');
    Route::post('/postFeedback', [FeedbackContoller::class, 'postFeedback'])->name('postFeedback');
    Route::get('/services', [ChatController::class, 'index'])->name('services');
    Route::post('/services', [ChatController::class, 'handleChat'])->name('chat.handle');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
