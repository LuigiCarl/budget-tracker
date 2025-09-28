<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Accounts
    Route::resource('accounts', AccountController::class);
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Transactions
    Route::resource('transactions', TransactionController::class);
    
    // Budgets
    Route::resource('budgets', BudgetController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Interactive API Documentation route - accessible to authenticated users
Route::get('/api-docs', function () {
    return view('docs.api');
})->middleware(['auth'])->name('api.docs');

require __DIR__.'/auth.php';
