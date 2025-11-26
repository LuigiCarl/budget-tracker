<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = \App\Models\Transaction::where('user_id', Auth::id())
            ->with(['account', 'category'])
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'transactions' => $transactions
            ]);
        }
            
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accounts = \App\Models\Account::where('user_id', Auth::id())->get();
        $categories = \App\Models\Category::where('user_id', Auth::id())->get();
        
        if ($accounts->isEmpty()) {
            if (request()->expectsJson() || request()->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'You need to create at least one account before adding transactions.',
                    'errors' => [
                        'account_id' => ['You need to create at least one account before adding transactions.']
                    ]
                ], 422);
            }
            return redirect()->route('accounts.create')
                ->with('error', 'You need to create at least one account before adding transactions.');
        }
        
        if ($categories->isEmpty()) {
            if (request()->expectsJson() || request()->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'You need to create at least one category before adding transactions.',
                    'errors' => [
                        'category_id' => ['You need to create at least one category before adding transactions.']
                    ]
                ], 422);
            }
            return redirect()->route('categories.create')
                ->with('error', 'You need to create at least one category before adding transactions.');
        }
        
        // Get default categories for both income and expense
        $defaultIncomeCategory = \App\Models\Category::getDefaultForUser(Auth::id(), 'income');
        $defaultExpenseCategory = \App\Models\Category::getDefaultForUser(Auth::id(), 'expense');
        
        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'accounts' => $accounts,
                'categories' => $categories,
                'default_income_category' => $defaultIncomeCategory,
                'default_expense_category' => $defaultExpenseCategory
            ]);
        }
        
        return view('transactions.create', compact('accounts', 'categories', 'defaultIncomeCategory', 'defaultExpenseCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:1000',
        ]);

        // Verify that the account and category belong to the authenticated user
        $account = \App\Models\Account::where('user_id', Auth::id())->findOrFail($request->account_id);
        $category = \App\Models\Category::where('user_id', Auth::id())->findOrFail($request->category_id);

        // Verify category type matches transaction type
        if ($category->type !== $request->type) {
            if (request()->expectsJson() || request()->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category type must match transaction type.',
                    'errors' => [
                        'category_id' => ['Category type must match transaction type.']
                    ]
                ], 422);
            }
            return back()->withErrors(['category_id' => 'Category type must match transaction type.']);
        }

        // Check budget constraints for expenses
        if ($request->type === 'expense') {
            $activeBudget = $category->budgets()
                ->where('start_date', '<=', $request->date)
                ->where('end_date', '>=', $request->date)
                ->first();

            $budgetWarning = null;
            $isLimiterBudget = false;

            if ($activeBudget) {
                $isLimiterBudget = $activeBudget->is_limiter;
                
                if ($activeBudget->wouldExceedWith($request->amount)) {
                    $remaining = max($activeBudget->remaining_amount, 0);
                    $overspendAmount = $request->amount - $remaining;
                    
                    if ($isLimiterBudget) {
                        // Hard limit - prevent the transaction
                        $errorMessage = "This expense exceeds your budget limit for {$category->name}. Remaining budget: $" . number_format($remaining, 2);
                        if (request()->expectsJson() || request()->is('api/*')) {
                            return response()->json([
                                'success' => false,
                                'message' => $errorMessage,
                                'errors' => [
                                    'amount' => [$errorMessage]
                                ]
                            ], 422);
                        }
                        return back()->withErrors([
                            'amount' => $errorMessage
                        ]);
                    } else {
                        // Soft limit - allow but warn
                        $budgetWarning = "This expense will exceed your budget for {$category->name} by $" . number_format($overspendAmount, 2);
                    }
                }
            }
        }

        $transaction = null;
        DB::transaction(function () use ($request, $account, &$transaction) {
            // Create the transaction
            $transaction = \App\Models\Transaction::create([
                'user_id' => Auth::id(),
                'account_id' => $request->account_id,
                'category_id' => $request->category_id,
                'type' => $request->type,
                'amount' => $request->amount,
                'date' => $request->date,
                'description' => $request->description,
            ]);

            // Update account balance
            if ($request->type === 'income') {
                $account->increment('balance', $request->amount);
            } else {
                $account->decrement('balance', $request->amount);
            }
        });

        $successMessage = 'Transaction created successfully.';
        if (isset($budgetWarning)) {
            $successMessage .= ' Warning: ' . $budgetWarning;
        }

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'transaction' => $transaction,
                'message' => $successMessage
            ], 201);
        }

        return redirect()->route('transactions.index')->with('success', $successMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaction = \App\Models\Transaction::where('user_id', Auth::id())
            ->with(['account', 'category'])
            ->findOrFail($id);

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'transaction' => $transaction
            ]);
        }
        
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $transaction = \App\Models\Transaction::where('user_id', Auth::id())->findOrFail($id);
        
        $accounts = \App\Models\Account::where('user_id', Auth::id())->get();
        $categories = \App\Models\Category::where('user_id', Auth::id())->get();
        
        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'transaction' => $transaction,
                'accounts' => $accounts,
                'categories' => $categories
            ]);
        }
        
        return view('transactions.edit', compact('transaction', 'accounts', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $transaction = \App\Models\Transaction::where('user_id', Auth::id())->findOrFail($id);
        
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        // Verify that the account and category belong to the authenticated user
        $account = \App\Models\Account::where('user_id', Auth::id())->findOrFail($request->account_id);
        $category = \App\Models\Category::where('user_id', Auth::id())->findOrFail($request->category_id);

        // Verify category type matches transaction type
        if ($category->type !== $request->type) {
            if (request()->expectsJson() || request()->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category type must match transaction type.',
                    'errors' => [
                        'category_id' => ['Category type must match transaction type.']
                    ]
                ], 422);
            }
            return back()->withErrors(['category_id' => 'Category type must match transaction type.']);
        }

        DB::transaction(function () use ($request, $account, $transaction) {
            // Reverse the old transaction's effect on account balance
            $oldAccount = $transaction->account;
            if ($transaction->type === 'income') {
                $oldAccount->decrement('balance', $transaction->amount);
            } else {
                $oldAccount->increment('balance', $transaction->amount);
            }

            // Update the transaction
            $transaction->update([
                'account_id' => $request->account_id,
                'category_id' => $request->category_id,
                'type' => $request->type,
                'amount' => $request->amount,
                'date' => $request->date,
                'description' => $request->description,
            ]);

            // Apply the new transaction's effect on account balance
            if ($request->type === 'income') {
                $account->increment('balance', $request->amount);
            } else {
                $account->decrement('balance', $request->amount);
            }
        });

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'transaction' => $transaction->fresh(),
                'message' => 'Transaction updated successfully.'
            ]);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaction = \App\Models\Transaction::where('user_id', Auth::id())->findOrFail($id);
        
        DB::transaction(function () use ($transaction) {
            // Reverse the transaction's effect on account balance
            $account = $transaction->account;
            if ($transaction->type === 'income') {
                $account->decrement('balance', $transaction->amount);
            } else {
                $account->increment('balance', $transaction->amount);
            }

            $transaction->delete();
        });

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Transaction deleted successfully.'
            ]);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}
