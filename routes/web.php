<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripPlanController;
use App\Http\Controllers\TripListController;
use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\GuestLoginController;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return redirect()->route('home');
})->middleware('auth');

Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


Route::post('/guest-login', [GuestLoginController::class, 'login'])->name('guest.login');

require __DIR__.'/auth.php';


Route::resource('trip_plans', TripPlanController::class)->middleware('auth');


Route::prefix('trip_plans/{trip_plan}')->group(function () {
    Route::resource('trip_lists', App\Http\Controllers\TripListController::class);
    Route::resource('transportations', App\Http\Controllers\TransportationController::class);
    Route::resource('accommodations', AccommodationController::class);
    Route::resource('checklists', App\Http\Controllers\ChecklistController::class);
    Route::prefix('checklists/{checklist}')->group(function () {
        Route::resource('tasks', App\Http\Controllers\TaskController::class);
    });
});