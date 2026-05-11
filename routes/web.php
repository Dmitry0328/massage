<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ClientRequestController;
use App\Http\Controllers\ContentOverrideController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookingController::class, 'index'])->name('booking.index');
Route::get('/booking/calendar', [BookingController::class, 'calendar'])->name('booking.calendar');
Route::get('/booking/availability', [BookingController::class, 'availability'])->name('booking.availability');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::post('/client-requests', [ClientRequestController::class, 'store'])->name('client-requests.store');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

Route::middleware('auth')->group(function (): void {
    Route::post('/admin/content-overrides', [ContentOverrideController::class, 'store'])->name('content-overrides.store');
    Route::delete('/admin/content-overrides', [ContentOverrideController::class, 'destroy'])->name('content-overrides.destroy');
});
