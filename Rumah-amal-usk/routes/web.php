<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/campaign', function () {
    return view('campaign/campaign');
});

Route::get('/profil', function () {
    return view('profil/profil');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

route::get('post', [HomeController::class, 'post'])->middleware(['auth', 'admin']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
