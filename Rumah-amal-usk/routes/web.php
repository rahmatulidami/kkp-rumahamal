<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\DocumentController;
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
Route::get('/', [HomeController::class, 'index'])->name('home');

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

Route::get('/berita', [BeritaController::class, 'index'])->name('berita');

Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

Route::get('/admin', function () {
    return view('admin/index');
});

Route::get('pengumuman', [BeritaController::class, 'pengumuman'])->name('pengumuman');

Route::get('/pengumuman/{slug}', [PengumumanController::class, 'show'])->name('pengumuman.show');

Route::get('/galeri', [GalleryController::class, 'showGallery']);

Route::get('/dokumen', [DocumentController::class, 'showDocuments']);

Route::get('/campaign', [CampaignController::class, 'index'])->name('campaign.index');

Route::get('/campaign/{slug}', [CampaignController::class, 'show'])->name('campaign.show');

Route::get('/profil', function () {
    return view('profil/profil');
});

Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home.auth');

Route::get('post', [HomeController::class, 'post'])->middleware(['auth', 'admin']);

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
