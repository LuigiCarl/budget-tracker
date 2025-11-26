<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = \App\Models\Account::where('user_id', Auth::id())
            ->withCount('transactions')
            ->get();

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'accounts' => $accounts
            ]);
        }
        
        return view('accounts.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $typeOptions = Account::getTypeOptions();
        return view('accounts.create', compact('typeOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Handle validation for API requests
        if ($request->expectsJson() || $request->is('api/*')) {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'type' => 'required|in:cash,bank,checking,savings,credit_card,investment',
                'balance' => 'required|numeric',
                'description' => 'nullable|string|max:500',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
        } else {
            // Web validation
            $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|in:cash,bank,checking,savings,credit_card,investment',
                'balance' => 'required|numeric',
                'description' => 'nullable|string|max:500',
            ]);
        }

        $account = \App\Models\Account::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'type' => $request->type,
            'balance' => $request->balance,
            'description' => $request->description,
        ]);

        // Return JSON for API requests
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'account' => $account,
                'message' => 'Account created successfully.'
            ]);
        }

        return redirect()->route('accounts.index')->with('success', 'Account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $account = \App\Models\Account::where('user_id', Auth::id())
            ->with('transactions.category')
            ->findOrFail($id);
        
        $transactions = $account->transactions()
            ->with('category')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'account' => $account,
                'transactions' => $transactions
            ]);
        }
            
        return view('accounts.show', compact('account', 'transactions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $account = \App\Models\Account::where('user_id', Auth::id())->findOrFail($id);
        
        $typeOptions = Account::getTypeOptions();
        return view('accounts.edit', compact('account', 'typeOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $account = \App\Models\Account::where('user_id', Auth::id())->findOrFail($id);
        
        // Handle validation for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'type' => 'required|in:cash,bank,checking,savings,credit_card,investment',
                'balance' => 'required|numeric|min:0',
                'description' => 'nullable|string|max:500',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
        } else {
            // Web validation
            $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|in:cash,bank,checking,savings,credit_card,investment',
                'balance' => 'required|numeric|min:0',
                'description' => 'nullable|string|max:500',
            ]);
        }

        $account->update([
            'name' => $request->name,
            'type' => $request->type,
            'balance' => $request->balance,
            'description' => $request->description,
        ]);

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'account' => $account->fresh(),
                'message' => 'Account updated successfully.'
            ]);
        }

        return redirect()->route('accounts.show', $account)->with('success', 'Account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $account = \App\Models\Account::where('user_id', Auth::id())->findOrFail($id);
        
        if ($account->transactions()->count() > 0) {
            if (request()->expectsJson() || request()->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete account with existing transactions.'
                ], 400);
            }
            return redirect()->route('accounts.index')->with('error', 'Cannot delete account with existing transactions.');
        }
        
        $account->delete();

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Account deleted successfully.'
            ]);
        }

        return redirect()->route('accounts.index')->with('success', 'Account deleted successfully.');
    }
}
