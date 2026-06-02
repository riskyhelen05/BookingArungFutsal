<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;

// Redirect root ke login
Route::get('/', fn() => redirect()->route('login'));

// Guest only (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register'])->name('register.post');
});

// Authenticated
Route::middleware('auth')->group(function () {
    Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

    // User routes
    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        Route::get('/beranda', fn() => view('user.beranda'))->name('beranda');
    });

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    });



// Route debug sementara - taruh paling atas
Route::get('/debug-login', function () {
    return [
        'auth'  => Auth::check(),
        'user'  => Auth::user(),
        'role'  => Auth::user()?->role,
    ];
})->middleware('auth');










});