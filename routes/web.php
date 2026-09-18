<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes - PoseBox
|--------------------------------------------------------------------------
*/

// ============================================
// GUEST ROUTES (belum login)
// ============================================
Route::middleware('guest')->group(function () {

    // Root → redirect ke login
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');

    // Login
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ============================================
// AUTH ROUTES (harus login)
// ============================================
Route::middleware('auth')->group(function () {

    // Halaman utama photobooth
    Route::get('/photobooth', function () {
        return view('photobooth');
    })->name('photobooth');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    // Update profile (dari form di profile.blade.php)
    Route::put('/profile/update', [AuthController::class, 'updateProfile'])
        ->name('profile.update');

    // Custom Templates (khusus professional, tapi kita buka dulu)
    Route::get('/custom-templates', function () {
        return view('custom-templates');
    })->name('custom-templates');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Avatar
    Route::post('/profile/avatar', [AuthController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('/profile/avatar', [AuthController::class, 'deleteAvatar'])->name('profile.avatar.delete');
});
