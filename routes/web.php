<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookingHistoryController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\ScannerController;
use App\Http\Controllers\Admin\BlockedSlotController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\User\UserDashboardController;
/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('splash');
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

            // Beranda
            Route::get('/beranda', [UserDashboardController::class, 'index'])
                ->name('beranda');

            /*
            |------------------------------------------------------------------
            | BOOKING – Pilih lapangan & jadwal
            |------------------------------------------------------------------
            */
            Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
            Route::get('/booking/slots', [BookingController::class, 'slots'])->name('booking.slots');
            Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');

            /*
            |------------------------------------------------------------------
            | PAYMENT – Upload bukti & konfirmasi
            |------------------------------------------------------------------
            */
            Route::get('/payment/{bookingId}', [PaymentController::class, 'show'])->name('payment.show');
            Route::post('/payment/{bookingId}/upload', [PaymentController::class, 'upload'])->name('payment.upload');
            Route::get('/payment/{bookingId}/success', [PaymentController::class, 'success'])->name('payment.success');

            /*
            |------------------------------------------------------------------
            | BOOKING HISTORY – Riwayat & detail
            |------------------------------------------------------------------
            */
            Route::get('/booking-history', [BookingHistoryController::class, 'index'])->name('booking.history');
            Route::get('/booking-history/{booking}', [BookingHistoryController::class, 'show'])->name('booking.show');
            Route::get('/booking-history/{booking}/qr', [BookingHistoryController::class, 'qr'])->name('booking.qr');
            Route::get('/booking-history/{booking}/cancel', [BookingHistoryController::class, 'cancelForm'])->name('booking.cancel.form');
            Route::post('/booking-history/{booking}/cancel', [BookingHistoryController::class, 'cancel'])->name('booking.cancel');
            Route::get('/booking-history/{booking}/cancel-success', [BookingHistoryController::class, 'cancelSuccess'])->name('booking.cancel.success');

            /*
            |------------------------------------------------------------------
            | REVIEW
            |------------------------------------------------------------------
            */
            Route::get('/booking-history/{booking}/review', [ReviewController::class, 'create'])->name('review.create');
            Route::post('/booking-history/{booking}/review', [ReviewController::class, 'store'])->name('review.store');

            /*
            |------------------------------------------------------------------
            | NOTIFIKASI
            |------------------------------------------------------------------
            */
            Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications.get');
            Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
            Route::post('/notifications/read/{id}', [NotificationController::class, 'read'])->name('notifications.read');
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

        Route::get('/dashboard', [AdminBookingController::class, 'index'])
            ->name('dashboard');

        Route::get('/jadwal', [BlockedSlotController::class, 'index'])
            ->name('jadwal');

        Route::post('/blocked-slots/review', [BlockedSlotController::class, 'review'])
            ->name('blocked.review');

        Route::post('/blocked-slots/confirm', [BlockedSlotController::class, 'confirm'])
            ->name('blocked.confirm');

        Route::get('/blocked-slots/manage', [BlockedSlotController::class, 'manage'])
            ->name('blocked.manage');

        Route::delete('/blocked-slots/{id}', [BlockedSlotController::class, 'destroy'])
            ->name('blocked.delete');

        // booking
        Route::get('/booking/{booking}', [AdminBookingController::class, 'show'])
            ->name('booking.show');

        Route::patch('/booking/{booking}/verify', [AdminBookingController::class, 'verify'])
            ->name('booking.verify');

        Route::patch('/booking/{booking}/reject', [AdminBookingController::class, 'reject'])
            ->name('booking.reject');

        // scanner
        Route::get('/scanner', [ScannerController::class, 'index'])
            ->name('scanner');

        Route::get('/scanner/scan/{code}', [ScannerController::class, 'scan'])
            ->name('scanner.scan');

        Route::patch('/scanner/{booking}/checkin', [ScannerController::class, 'checkIn'])
            ->name('scanner.checkin');

        Route::get('/lapangan', fn () => view('admin.soon'))
            ->name('lapangan');

        //Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])
            ->name('laporan');

        Route::get('/laporan/export/csv', [LaporanController::class, 'exportCsv'])
            ->name('laporan.export.csv');

        Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])
            ->name('laporan.export.pdf');

        Route::get('/laporan/export/excel', [LaporanController::class, 'exportExcel'])
            ->name('laporan.export.excel');

        Route::get('/profile', fn () => view('admin.soon'))
            ->name('profile');
    });
        

    /*
    |--------------------------------------------------------------------------
    | DEBUG (hapus di production)
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