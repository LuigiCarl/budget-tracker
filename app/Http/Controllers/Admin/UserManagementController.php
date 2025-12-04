<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $users = $query->with(['transactions' => function ($q) {
            $q->where('type', 'expense');
        }])
        ->withCount('transactions')
        ->paginate($request->per_page ?? 20);

        // Add computed fields
        $users->getCollection()->transform(function ($user) {
            $user->total_spent = $user->transactions->where('type', 'expense')->sum('amount');
            $user->join_date = $user->created_at->toDateString();
            unset($user->transactions);
            return $user;
        });

        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', Password::min(8)],
            'status' => 'sometimes|in:active,inactive'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status ?? 'active',
            'role' => 'user'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    public function show($id)
    {
        $user = User::with('transactions')
            ->withCount('transactions')
            ->findOrFail($id);

        $user->total_spent = $user->transactions->where('type', 'expense')->sum('amount');
        $user->join_date = $user->created_at->toDateString();

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => ['sometimes', Password::min(8)],
            'status' => 'sometimes|in:active,inactive,blocked',
            'role' => 'sometimes|in:user,admin'
        ]);

        $data = $request->only(['name', 'email', 'status', 'role']);
        
        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    /**
     * Block a user
     */
    public function block($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent blocking yourself
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot block your own account'
            ], 403);
        }

        // Prevent blocking admins
        if ($user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot block admin users'
            ], 403);
        }

        $user->update(['status' => 'blocked']);

        // Revoke all tokens (log out the user from all devices)
        $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'User blocked successfully',
            'user' => $user
        ]);
    }

    /**
     * Unblock a user
     */
    public function unblock($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->status !== 'blocked') {
            return response()->json([
                'success' => false,
                'message' => 'User is not blocked'
            ], 400);
        }

        $user->update(['status' => 'active']);

        return response()->json([
            'success' => true,
            'message' => 'User unblocked successfully',
            'user' => $user
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }

    public function statistics()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $inactiveUsers = User::where('status', 'inactive')->count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)->count();

        return response()->json([
            'success' => true,
            'statistics' => [
                'total_users' => $totalUsers,
                'active_users' => $activeUsers,
                'inactive_users' => $inactiveUsers,
                'new_users_this_month' => $newUsersThisMonth
            ]
        ]);
    }
}
