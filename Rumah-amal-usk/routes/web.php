<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;

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

// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
// });
// Route::resource('categories', CategoryController::class);


// Route::get('/berita', function () {
//     return view('berita/berita');
// });

// Route::get('/detail-berita', function () {
//     return view('berita/detail-berita');
// });

Route::get('/admin', function () {
    return view('admin.index');
});

// Route::get('/pengumuman', function () {
//     return view('pengumuman/pengumuman');
// });

// Route::get('/detail-pengumuman', function () {
//     return view('pengumuman/detail-pengumuman');
// });

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

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Route untuk CRUD kategori
    Route::resource('admin/categories', CategoryController::class);
    Route::delete('admin/categories/reset', [CategoryController::class, 'reset'])->name('categories.reset');
    Route::resource('admin/posts', PostController::class);
    // routes/web.php

// Rute untuk menghapus post
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

});

Route::get('/', [PostController::class, 'landingPage'])->name('landing.home');
Route::post('/upload', [App\Http\Controllers\UploadController::class, 'upload'])->name('upload');

// Halaman untuk menampilkan semua berita
Route::get('/berita', [PostController::class, 'showBerita'])->name('posts.berita');
Route::get('/berita/{title}', [PostController::class, 'showByTitle'])->name('posts.showByTitle');

// Halaman untuk menampilkan semua pengumuman
Route::get('/pengumuman', [PostController::class, 'showPengumuman'])->name('posts.pengumuman');
Route::get('/pengumuman/{title}', [PostController::class, 'showByTitle'])->name('posts.showByTitle');

// web.php


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/donasi-infak', function () {
    return view('donation/donasi-infak');
});

Route::get('/donasi-zakat', function () {
    return view('donation/donasi-zakat');
});

Route::get('/detail-campaign', function () {
    return view('campaign/detail-campaign');
});
