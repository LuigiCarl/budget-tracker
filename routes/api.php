<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\AnalyticsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public API routes (no authentication required)
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Protected API routes (require Sanctum authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Get authenticated user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Update user profile information
    Route::put('/profile', [ProfileController::class, 'updateProfileInformation']);
    
    // Update user password
    Route::put('/password', [ProfileController::class, 'updatePassword']);
    
    // Delete user account
    Route::delete('/account', [ProfileController::class, 'deleteAccount']);
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    // Analytics API
    Route::prefix('analytics')->group(function () {
        Route::get('/monthly', [AnalyticsController::class, 'monthly']);
        Route::get('/trends', [AnalyticsController::class, 'trends']);
        Route::get('/category-breakdown', [AnalyticsController::class, 'categoryBreakdown']);
        Route::get('/budget-performance', [AnalyticsController::class, 'budgetPerformance']);
    });
    
    // Accounts API
    Route::apiResource('accounts', AccountController::class)->names([
        'index' => 'api.accounts.index',
        'store' => 'api.accounts.store',
        'show' => 'api.accounts.show',
        'update' => 'api.accounts.update',
        'destroy' => 'api.accounts.destroy',
    ]);
    
    // Categories API
    Route::apiResource('categories', CategoryController::class)->names([
        'index' => 'api.categories.index',
        'store' => 'api.categories.store',
        'show' => 'api.categories.show',
        'update' => 'api.categories.update',
        'destroy' => 'api.categories.destroy',
    ]);
    
    // Transactions API
    Route::apiResource('transactions', TransactionController::class)->names([
        'index' => 'api.transactions.index',
        'store' => 'api.transactions.store',
        'show' => 'api.transactions.show',
        'update' => 'api.transactions.update',
        'destroy' => 'api.transactions.destroy',
    ]);
    
    // Budgets API
    Route::apiResource('budgets', BudgetController::class)->names([
        'index' => 'api.budgets.index',
        'store' => 'api.budgets.store',
        'show' => 'api.budgets.show',
        'update' => 'api.budgets.update',
        'destroy' => 'api.budgets.destroy',
    ]);
    
    // Create new API token
    Route::post('/tokens', function (Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $token = $request->user()->createToken($request->name);

        return response()->json([
            'token' => $token->plainTextToken,
            'name' => $request->name
        ]);
    });
    
    // Logout (revoke current token)
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    });
});