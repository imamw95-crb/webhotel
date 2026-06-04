<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\PageSectionController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit')->middleware('throttle:5,10');
Route::post('/booking', [HomeController::class, 'submitBooking'])->name('booking.submit')->middleware('throttle:3,5');
Route::get('/api/check-availability', [HomeController::class, 'checkAvailability'])->name('api.check-availability');

// Track Booking (public)
Route::get('/booking/track', [HomeController::class, 'trackBooking'])->name('booking.track');
Route::post('/booking/track', [HomeController::class, 'lookupBooking'])->name('booking.lookup');

// Booking Confirmation (after submit)
Route::get('/booking/{booking}/confirmation', [HomeController::class, 'bookingConfirmation'])->name('booking.confirmation');

// Payment pages
Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
Route::get('/payment/{booking}', [PaymentController::class, 'pay'])->name('payment.pay');
Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [PaymentController::class, 'failed'])->name('payment.failed');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('room-types', RoomTypeController::class)->except(['show']);
    Route::resource('facilities', FacilityController::class)->except(['show']);
    Route::resource('gallery', GalleryController::class)->parameters(['gallery' => 'gallery'])->except(['show']);

    Route::get('sections', [PageSectionController::class, 'index'])->name('sections.index');
    Route::get('sections/{section}/edit', [PageSectionController::class, 'edit'])->name('sections.edit');
    Route::put('sections/{section}', [PageSectionController::class, 'update'])->name('sections.update');

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::patch('bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::patch('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::delete('bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::get('bookings/{booking}/invoice', [InvoiceController::class, 'view'])->name('bookings.invoice');
    Route::get('bookings/{booking}/invoice/download', [InvoiceController::class, 'download'])->name('bookings.invoice.download');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (simple)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/login', function (Request $request) {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        // Rate limit: 5 attempts per minute
        $key = 'login:'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            return back()->withErrors(['login' => "Too many attempts. Try again in {$seconds} seconds."])->onlyInput('login');
        }

        $login = $request->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$field => $login, 'password' => $request->input('password')], $request->boolean('remember'))) {
            RateLimiter::clear($key);
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        RateLimiter::hit($key, 60);

        return back()->withErrors(['login' => 'Invalid credentials.'])->onlyInput('login');
    });
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout')->middleware('auth');
