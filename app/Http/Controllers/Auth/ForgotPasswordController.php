<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    /**
     * Send a password reset link to the given user.
     *
     * Best practices implemented:
     * - Rate limiting (applied via route middleware)
     * - Only registered emails can request password reset
     * - Input validation
     * - Secure token generation (handled by Laravel)
     */
    public function sendResetLinkEmail(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        // Check if user exists - return error if not registered
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'No account found with this email address. Please check your email or create a new account.',
            ], 404);
        }

        // Check if user is blocked
        if ($user->status === 'blocked') {
            return response()->json([
                'status' => 'error',
                'message' => 'This account has been blocked. Please contact support.',
            ], 403);
        }

        // Attempt to send the password reset link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'status' => 'success',
                'message' => 'We have emailed your password reset link to ' . $request->email,
            ]);
        }

        // For throttling, inform user to wait
        if ($status === Password::RESET_THROTTLED) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please wait before requesting another reset link. Try again in a minute.',
            ], 429);
        }

        // Generic error for other cases
        return response()->json([
            'status' => 'error',
            'message' => 'Unable to send reset link. Please try again later.',
        ], 500);
    }

    /**
     * Reset the user's password.
     *
     * Best practices implemented:
     * - Strong password validation
     * - Token verification (handled by Laravel)
     * - Password hashing (handled by Laravel)
     * - Token invalidation after use
     * - Session invalidation for security
     */
    public function reset(Request $request): JsonResponse
    {
        $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255'],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults()
                    ->min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.letters' => 'Password must contain at least one letter.',
            'password.mixed' => 'Password must contain both uppercase and lowercase letters.',
            'password.numbers' => 'Password must contain at least one number.',
            'password.symbols' => 'Password must contain at least one special character.',
            'password.uncompromised' => 'This password has appeared in a data breach. Please choose a different password.',
        ]);

        // Attempt to reset the password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                // Update password and regenerate remember token
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                // Revoke all existing API tokens for security
                $user->tokens()->delete();

                // Fire password reset event
                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'status' => 'success',
                'message' => __('passwords.reset'),
            ]);
        }

        // Handle specific error cases
        $errorMessages = [
            Password::INVALID_TOKEN => 'This password reset link is invalid or has expired.',
            Password::INVALID_USER => 'We could not find a user with that email address.',
            Password::RESET_THROTTLED => 'Please wait before retrying.',
        ];

        return response()->json([
            'status' => 'error',
            'message' => $errorMessages[$status] ?? 'Unable to reset password. Please try again.',
        ], $status === Password::RESET_THROTTLED ? 429 : 400);
    }

    /**
     * Verify that a password reset token is valid.
     * 
     * This allows the frontend to check if a token is valid
     * before showing the reset password form.
     */
    public function verifyToken(Request $request): JsonResponse
    {
        $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid reset link.',
            ], 400);
        }

        $tokenValid = Password::tokenExists($user, $request->token);

        if ($tokenValid) {
            return response()->json([
                'valid' => true,
                'message' => 'Token is valid.',
            ]);
        }

        return response()->json([
            'valid' => false,
            'message' => 'This password reset link is invalid or has expired.',
        ], 400);
    }
}
