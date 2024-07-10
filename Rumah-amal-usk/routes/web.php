<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landing/home');
});

Route::get('/donate', [DonationController::class, 'index']);
Route::post('/donate', [DonationController::class, 'store']);

Route::get('/success', function () {
    return view('donation/success');
});

Route::get('/failure', function () {
    return view('failure');
});

Route::post('/xendit-callback', [DonationController::class, 'handleXenditCallback']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});


Route::get('/berita', function () {
    return view('berita/berita');
});

Route::get('/detail-berita', function () {
    return view('berita/detail-berita');
});

Route::get('/admin', function () {
    return view('admin/index');
});

Route::get('/pengumuman', function () {
    return view('pengumuman/pengumuman');
});

Route::get('/detail-pengumuman', function () {
    return view('pengumuman/detail-pengumuman');
});

Route::get('/galeri', function () {
    return view('galeri/galeri');
});
