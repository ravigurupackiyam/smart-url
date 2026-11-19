<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/urls', [DashboardController::class, 'store'])->middleware('throttle:30,1');
    Route::get('/urls/{url}/analytics', [DashboardController::class, 'analytics']);
});
// keep this LAST so it doesn't swallow other routes
Route::get('/{code}', RedirectController::class)->where('code', '[0-9a-zA-Z]{5,10}');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
