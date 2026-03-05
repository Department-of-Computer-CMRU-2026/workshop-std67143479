<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
            return view('dashboard');
        }
        )->name('dashboard');

        Route::resource('workshops', 'App\Http\Controllers\WorkshopController');
        Route::post('workshops/{workshop}/register', ['App\Http\Controllers\WorkshopController', 'register'])->name('workshops.register');
        Route::post('workshops/{workshop}/unregister', ['App\Http\Controllers\WorkshopController', 'unregister'])->name('workshops.unregister');
        Route::get('admin/dashboard', 'App\Http\Controllers\AdminDashboardController')->name('admin.dashboard');    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', ['App\Http\Controllers\ProfileController', 'edit'])->name('profile.edit');
    Route::patch('/profile', ['App\Http\Controllers\ProfileController', 'update'])->name('profile.update');
    Route::delete('/profile', ['App\Http\Controllers\ProfileController', 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
