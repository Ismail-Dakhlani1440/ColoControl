<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\InvitationController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\User\CategorieController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\FlatShareController;

Route::get('/', function () {
    return view('auth.register');
});

Route::middleware('auth')->group(function () {
    Route::resource('flatshares', FlatShareController::class);
    Route::resource('invitations', InvitationController::class);
    Route::resource('categories', CategorieController::class)->except(['show']);
    Route::post('/invitations/{invitation}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::post('/invitations/{invitation}/reject', [InvitationController::class, 'reject'])->name('invitations.reject');
});



Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
