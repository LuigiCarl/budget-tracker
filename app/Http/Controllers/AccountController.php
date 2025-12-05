<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\CachesApiResponses;

class AccountController extends Controller
{
    use AuthorizesRequests, CachesApiResponses;
    
    /**
     * Display a listing of the resource.
     * Cached for 5 minutes
     */
    public function index(Request $request)
    {
        // Validate year/month parameters to prevent injection
        $request->validate([
            'year' => 'nullable|integer|min:2000|max:2100',
            'month' => 'nullable|integer|min:1|max:12',
        ]);
        
        $query = \App\Models\Account::where('user_id', Auth::id());
        
        // If year and month are provided, include transaction totals for that period
        if ($request->has('year') && $request->has('month')) {
            $year = (int) $request->get('year');
            $month = (int) $request->get('month');
            
            $startOfMonth = sprintf('%04d-%02d-01', $year, $month);
            $endOfMonth = date('Y-m-t', strtotime($startOfMonth));
            $today = date('Y-m-d');
            
            $accounts = $query->get()->map(function($account) use ($startOfMonth, $endOfMonth, $today) {
                // Check if account existed in this month
                // Account exists if it was created on or before the end of the month
                $accountCreatedDate = $account->created_at->format('Y-m-d');
                $accountExistedInMonth = $accountCreatedDate <= $endOfMonth;
                
                if (!$accountExistedInMonth) {
                    // Account didn't exist yet, return with zero balance for this month
                    $account->month_income = 0;
                    $account->month_expenses = 0;
                    $account->month_transaction_count = 0;
                    $account->month_balance = 0;
                    $account->cumulative_balance = 0;
                    $account->account_existed = false;
                    return $account;
                }
                
                // Account existed, get transactions for this month only
                $monthTransactions = $account->transactions()
                    ->whereBetween('date', [$startOfMonth, $endOfMonth])
                    ->get();
                
                $account->month_income = $monthTransactions->where('type', 'income')->sum('amount');
                $account->month_expenses = $monthTransactions->where('type', 'expense')->sum('amount');
                $account->month_transaction_count = $monthTransactions->count();
                
                // Calculate net change for this month only (for display purposes)
                $account->month_balance = $account->month_income - $account->month_expenses;
                
                // Calculate cumulative balance
                // account->balance is the CURRENT balance (already includes all transactions)
                $currentBalance = (float) $account->balance;
                
                if ($endOfMonth >= $today) {
                    // Current or future month - use current balance
                    $account->cumulative_balance = $currentBalance;
                } else {
                    // Past month - subtract transactions after end of month to get historical balance
                    $incomeAfterMonth = $account->transactions()
                        ->where('type', 'income')
                        ->whereDate('date', '>', $endOfMonth)
                        ->sum('amount');
                    
                    $expensesAfterMonth = $account->transactions()
                        ->where('type', 'expense')
                        ->whereDate('date', '>', $endOfMonth)
                        ->sum('amount');
                    
                    $account->cumulative_balance = $currentBalance - $incomeAfterMonth + $expensesAfterMonth;
                }
                
                $account->account_existed = true;
                
                return $account;
            });
        } else {
            $accounts = $query->withCount('transactions')->get()->map(function($account) {
                // For non-filtered view, use current balance directly (it already includes all transactions)
                $account->cumulative_balance = (float) $account->balance;
                return $account;
            });
        }

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
        
        // Clear account caches
        $this->clearAccountCaches();

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
    public function show(Request $request, $id)
    {
        $account = \App\Models\Account::where('user_id', Auth::id())
            ->findOrFail($id);
        
        // Build transactions query with optional type filter
        $transactionsQuery = $account->transactions()
            ->with('category')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc');
        
        // Filter by transaction type if provided
        if ($request->has('type') && in_array($request->get('type'), ['income', 'expense'])) {
            $transactionsQuery->where('type', $request->get('type'));
        }
        
        $transactions = $transactionsQuery->paginate($request->get('per_page', 20));
        
        // Calculate account statistics (all-time)
        $totalIncome = $account->transactions()->where('type', 'income')->sum('amount');
        $totalExpenses = $account->transactions()->where('type', 'expense')->sum('amount');
        
        // Calculate initial balance (balance before any transactions)
        // Current balance = initial_balance + income - expenses
        // Therefore: initial_balance = current_balance - income + expenses
        $currentBalance = (float) $account->balance;
        $initialBalance = $currentBalance - $totalIncome + $totalExpenses;

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'account' => $account,
                'transactions' => $transactions,
                'stats' => [
                    'initial_balance' => $initialBalance,
                    'total_income' => $totalIncome,
                    'total_expenses' => $totalExpenses,
                    'current_balance' => $currentBalance,
                ]
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
        
        // Clear account caches
        $this->clearAccountCaches();

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
        
        // Clear account caches
        $this->clearAccountCaches();

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
