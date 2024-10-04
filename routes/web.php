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


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/guest-login', [GuestLoginController::class, 'login'])->name('guest.login');

require __DIR__.'/auth.php';

Route::resource('trip_plans', TripPlanController::class)->middleware('auth');

// trip_plans 内の trip_lists リソースルート（ネストされたリソース）
Route::prefix('trip_plans/{trip_plan}')->group(function () {
    Route::resource('trip_lists', App\Http\Controllers\TripListController::class);
    // transportation のリソースルートを trip_plans 内にネスト
    Route::resource('transportations', App\Http\Controllers\TransportationController::class);
    // accommodation のリソースルートを trip_plans 内にネスト
    Route::resource('accommodations', AccommodationController::class);
    // checklists のリソースルート
    Route::resource('checklists', App\Http\Controllers\ChecklistController::class);
    // tasks のリソースルートを checklists 内にネスト
    Route::prefix('checklists/{checklist}')->group(function () {
        Route::resource('tasks', App\Http\Controllers\TaskController::class);
    });

});