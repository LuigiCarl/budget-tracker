<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\NotificationController;

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

// Public API routes (no authentication required) - with auth rate limiting
Route::middleware('throttle:auth')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    
    // Password Reset Routes (rate limited for security)
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])
        ->name('password.update');
    Route::post('/verify-reset-token', [ForgotPasswordController::class, 'verifyToken'])
        ->name('password.verify');
});

// Protected API routes (require Sanctum authentication + API rate limiting)
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
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
    Route::get('/dashboard/stats', [DashboardController::class, 'getStats']);
    Route::get('/dashboard/recent-transactions', [DashboardController::class, 'getRecentTransactions']);
    Route::get('/dashboard/monthly-analytics', [DashboardController::class, 'getMonthlyAnalytics']);
    Route::get('/dashboard/budget-progress', [DashboardController::class, 'getBudgetProgress']);
    
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
    
    // Check budget before transaction
    Route::post('/transactions/check-budget', [TransactionController::class, 'checkBudget']);
    
    // Budgets API
    Route::apiResource('budgets', BudgetController::class)->names([
        'index' => 'api.budgets.index',
        'store' => 'api.budgets.store',
        'show' => 'api.budgets.show',
        'update' => 'api.budgets.update',
        'destroy' => 'api.budgets.destroy',
    ]);
    
    // Feedback API
    Route::post('/feedback', [FeedbackController::class, 'store']);
    Route::get('/feedback/my', [FeedbackController::class, 'myFeedback']);
    
    // Notifications API (user side)
    Route::get('/notifications/recent', [NotificationController::class, 'recent']);
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);
    
    // Admin routes - protected by admin middleware
    Route::middleware('admin')->prefix('admin')->group(function () {
        // User Management
        Route::get('/users', [UserManagementController::class, 'index']);
        Route::post('/users', [UserManagementController::class, 'store']);
        Route::get('/users/statistics', [UserManagementController::class, 'statistics']);
        Route::get('/users/{id}', [UserManagementController::class, 'show']);
        Route::put('/users/{id}', [UserManagementController::class, 'update']);
        Route::delete('/users/{id}', [UserManagementController::class, 'destroy']);
        Route::post('/users/{id}/block', [UserManagementController::class, 'block']);
        Route::post('/users/{id}/unblock', [UserManagementController::class, 'unblock']);
        
        // Feedback Management
        Route::get('/feedback', [FeedbackController::class, 'index']);
        Route::get('/feedback/{id}', [FeedbackController::class, 'show']);
        Route::patch('/feedback/{id}/status', [FeedbackController::class, 'updateStatus']);
        Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy']);
        
        // Notification Management
        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::post('/notifications', [NotificationController::class, 'store']);
        Route::get('/notifications/{id}', [NotificationController::class, 'show']);
        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);
    });
    
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