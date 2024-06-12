<?php

use App\Http\Controllers\{EventController, ProfileController, VenueController};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Events
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
    Route::post('/event/create', [EventController::class, 'store'])->name('event.store');
    Route::get('/event/{event}', [EventController::class, 'edit'])->where('id', '[0-9]+')->name('event.edit');
    Route::patch('/event/{event}', [EventController::class, 'update'])->where('id', '[0-9]+')->name('event.update');
    Route::delete('/event/{event}', [EventController::class, 'destroy'])->where('id', '[0-9]+')->name('event.destroy');

    // Venue
    Route::get('/venue', [VenueController::class, 'index'])->name('venue.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
