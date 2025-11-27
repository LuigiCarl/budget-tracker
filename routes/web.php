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

// Simple test to check if API works without authentication
Route::get('/test-api', function () {
    return response()->json([
        'message' => 'API is working',
        'timestamp' => now(),
        'users_count' => \App\Models\User::count()
    ]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Dashboard API endpoints for web (using session auth)
    Route::prefix('api/web/dashboard')->group(function () {
        Route::get('/stats', [DashboardController::class, 'getStats'])->name('dashboard.api.stats');
        Route::get('/recent-transactions', [DashboardController::class, 'getRecentTransactions'])->name('dashboard.api.transactions');
        Route::get('/monthly-analytics', [DashboardController::class, 'getMonthlyAnalytics'])->name('dashboard.api.monthly');
        Route::get('/budget-progress', [DashboardController::class, 'getBudgetProgress'])->name('dashboard.api.budgets');
    });
    
    // Debug route to test if dashboard controller works
    Route::get('/debug/dashboard', function () {
        $controller = new \App\Http\Controllers\DashboardController();
        try {
            $result = $controller->getStats(request());
            return response()->json(['success' => true, 'data' => $result]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    });
    
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
