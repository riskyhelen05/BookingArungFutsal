<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookingHistoryController;
use App\Models\Notification;
use App\Http\Controllers\User\NotificationController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('splash');
});

Route::get('/test-login', function () {
    return [
        'auth' => Auth::check(),
        'user' => Auth::user(),
    ];
});

/*
|--------------------------------------------------------------------------
| GUEST (BELUM LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

/*
|--------------------------------------------------------------------------
| AUTH (SUDAH LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | USER
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:user')
        ->prefix('user')
        ->name('user.')
        ->group(function () {

            Route::get('/beranda', fn() => view('user.beranda'))
                ->name('beranda');

            /*
            | BOOKING
            */
            Route::get('/booking-history', [BookingHistoryController::class, 'index'])
                ->name('booking.history');

            Route::get('/booking-history/{booking}', [BookingHistoryController::class, 'show'])
                ->name('booking.show');

            Route::get('/booking-history/{booking}/qr', [BookingHistoryController::class, 'qr'])
                ->name('booking.qr');

            Route::get('/booking-history/{booking}/cancel', [BookingHistoryController::class, 'cancelForm'])
                ->name('booking.cancel.form');

            Route::post('/booking-history/{booking}/cancel', [BookingHistoryController::class, 'cancel'])
                ->name('booking.cancel');


/*
| 🔔 GET NOTIFICATIONS
*/
Route::get('/notifications', [NotificationController::class, 'getNotifications'])
    ->name('notifications.get'); // ✅ TANPA 'user.'

Route::get('/notifications/{id}', [NotificationController::class, 'show'])
    ->name('notifications.show');

/*
| ✅ MARK AS READ
*/
Route::post('/notifications/read/{id}', [NotificationController::class, 'read'])
    ->name('notifications.read');
    
});
    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', fn() => view('admin.dashboard'))
                ->name('dashboard');
        });

    /*
    |--------------------------------------------------------------------------
    | DEBUG
    |--------------------------------------------------------------------------
    */
    Route::get('/debug-login', function () {
        return [
            'auth' => Auth::check(),
            'user' => Auth::user(),
            'role' => Auth::user()?->role,
        ];
    });
});