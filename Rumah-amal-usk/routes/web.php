<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;
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
    return view('success');
});

Route::get('/failure', function () {
    return view('failure');
});
