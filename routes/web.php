<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\InvitationController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\CategorieController;
use App\Http\Controllers\User\ExpenseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\FlatShareController;
use App\Http\Controllers\DebtController;

Route::get('/', function () {
    return redirect()->route('flatshares.index');
});

Route::middleware('auth')->group(function () {
    Route::delete('/flatshares/leave',              [FlatShareController::class, 'leave'])->name('flatshares.leave');
    Route::delete('/flatshares/cancel',             [FlatShareController::class, 'cancel'])->name('flatshares.cancel');
    Route::delete('/flatshares/members/{member}',   [FlatShareController::class, 'removeMember'])->name('flatshares.removeMember');
    Route::resource('expenses', ExpenseController::class)->except(['edit', 'update']);
    Route::post('/expenses/{expense}/mark-paid', [ExpenseController::class, 'markPaid'])->name('expenses.markPaid');
    Route::resource('flatshares', FlatShareController::class);
    Route::resource('invitations', InvitationController::class);
    Route::resource('categories', CategorieController::class)->except(['show']);
    Route::post('/invitations/{invitation}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::post('/invitations/{invitation}/reject', [InvitationController::class, 'reject'])->name('invitations.reject');
    Route::resource('debts', DebtController::class)->only(['index']);
});



Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::patch('/users/{user}/ban',   [AdminController::class, 'ban'])->name('ban');
    Route::patch('/users/{user}/unban', [AdminController::class, 'unban'])->name('unban');
    Route::patch('/users/{user}/role',  [AdminController::class, 'updateRole'])->name('updateRole');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
