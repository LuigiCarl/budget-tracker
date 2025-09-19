<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;

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
    Route::put('/user/profile-information', [ProfileController::class, 'updateProfileInformation']);
    
    // Update user password
    Route::put('/user/password', [ProfileController::class, 'updatePassword']);
    
    // Logout (revoke current token)
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    });
});