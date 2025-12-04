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
use App\Http\Traits\CachesApiResponses;

class TransactionController extends Controller
{
    use AuthorizesRequests, CachesApiResponses;

    /**
     * Display a listing of the resource.
     * Cached for 2 minutes (transactions change often)
     */
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 20);
        $type = $request->get('type');
        $categoryId = $request->get('category_id');
        $accountId = $request->get('account_id');
        $year = $request->get('year');
        $month = $request->get('month');
        
        $query = \App\Models\Transaction::where('user_id', Auth::id())
            ->with(['account', 'category'])
            ->when($type && $type !== 'all', fn($q) => $q->where('type', $type))
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->when($accountId, fn($q) => $q->where('account_id', $accountId));
        
        // Filter by year and month if provided
        if ($year && $month) {
            $startOfMonth = sprintf('%04d-%02d-01', $year, $month);
            $endOfMonth = date('Y-m-t', strtotime($startOfMonth));
            $query->whereBetween('date', [$startOfMonth, $endOfMonth]);
        }
        
        $transactions = $query->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

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
     * Check budget status before creating a transaction.
     * Returns warning if budget will be exceeded.
     */
    public function checkBudget(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
        ]);

        // Only check budget for expenses
        if ($request->type !== 'expense') {
            return response()->json([
                'success' => true,
                'has_budget' => false,
                'message' => 'No budget check needed for income'
            ]);
        }

        $category = \App\Models\Category::where('user_id', Auth::id())->findOrFail($request->category_id);
        
        $activeBudget = $category->budgets()
            ->where('start_date', '<=', $request->date)
            ->where('end_date', '>=', $request->date)
            ->first();

        if (!$activeBudget) {
            return response()->json([
                'success' => true,
                'has_budget' => false,
                'message' => 'No budget set for this category'
            ]);
        }

        $remaining = max($activeBudget->remaining_amount, 0);
        $spent = $activeBudget->spent_amount;
        $budgetAmount = $activeBudget->amount;
        $percentUsed = $budgetAmount > 0 ? ($spent / $budgetAmount) * 100 : 0;
        $percentAfterTransaction = $budgetAmount > 0 ? (($spent + $request->amount) / $budgetAmount) * 100 : 0;
        $wouldExceed = $activeBudget->wouldExceedWith($request->amount);
        $overspendAmount = max($request->amount - $remaining, 0);

        $budgetInfo = [
            'budget_id' => $activeBudget->id,
            'budget_amount' => $budgetAmount,
            'spent' => $spent,
            'remaining' => $remaining,
            'percent_used' => round($percentUsed, 1),
            'percent_after_transaction' => round($percentAfterTransaction, 1),
            'is_limiter' => $activeBudget->is_limiter,
            'category_name' => $category->name,
            'would_exceed' => $wouldExceed,
            'overspend_amount' => $overspendAmount,
        ];

        $warningLevel = 'none';
        $warningMessage = null;

        if ($wouldExceed) {
            if ($activeBudget->is_limiter) {
                $warningLevel = 'error';
                $warningMessage = "This expense exceeds your budget limit for {$category->name}. Remaining: ₱" . number_format($remaining, 2);
            } else {
                $warningLevel = 'warning';
                $warningMessage = "This expense will exceed your budget for {$category->name} by ₱" . number_format($overspendAmount, 2);
            }
        } else if ($percentAfterTransaction >= 90) {
            $warningLevel = 'warning';
            $warningMessage = "This will use " . round($percentAfterTransaction, 1) . "% of your {$category->name} budget.";
        } else if ($percentAfterTransaction >= 75) {
            $warningLevel = 'info';
            $warningMessage = "After this, you'll have used " . round($percentAfterTransaction, 1) . "% of your {$category->name} budget.";
        }

        return response()->json([
            'success' => true,
            'has_budget' => true,
            'budget_info' => $budgetInfo,
            'warning_level' => $warningLevel,
            'warning_message' => $warningMessage,
            'can_proceed' => !($wouldExceed && $activeBudget->is_limiter),
        ]);
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

        // Initialize budget tracking variables
        $budgetWarning = null;
        $budgetInfo = null;

        // Check budget constraints for expenses
        if ($request->type === 'expense') {
            $activeBudget = $category->budgets()
                ->where('start_date', '<=', $request->date)
                ->where('end_date', '>=', $request->date)
                ->first();

            $isLimiterBudget = false;

            if ($activeBudget) {
                $isLimiterBudget = $activeBudget->is_limiter;
                $remaining = max($activeBudget->remaining_amount, 0);
                $spent = $activeBudget->spent_amount;
                $budgetAmount = $activeBudget->amount;
                $percentUsed = $budgetAmount > 0 ? ($spent / $budgetAmount) * 100 : 0;
                
                $budgetInfo = [
                    'budget_id' => $activeBudget->id,
                    'budget_amount' => $budgetAmount,
                    'spent' => $spent,
                    'remaining' => $remaining,
                    'percent_used' => round($percentUsed, 1),
                    'is_limiter' => $isLimiterBudget,
                    'category_name' => $category->name,
                ];
                
                if ($activeBudget->wouldExceedWith($request->amount)) {
                    $overspendAmount = $request->amount - $remaining;
                    
                    if ($isLimiterBudget) {
                        // Hard limit - prevent the transaction
                        $errorMessage = "This expense exceeds your budget limit for {$category->name}. Remaining budget: $" . number_format($remaining, 2);
                        if (request()->expectsJson() || request()->is('api/*')) {
                            return response()->json([
                                'success' => false,
                                'message' => $errorMessage,
                                'budget_exceeded' => true,
                                'is_hard_limit' => true,
                                'budget_info' => $budgetInfo,
                                'overspend_amount' => $overspendAmount,
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
                } else if ($percentUsed >= 80) {
                    // Warn when approaching budget limit (80%+)
                    $budgetWarning = "After this transaction, you'll have used " . round($percentUsed + (($request->amount / $budgetAmount) * 100), 1) . "% of your {$category->name} budget.";
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
        
        // Clear related caches
        $this->clearTransactionCaches();

        $successMessage = 'Transaction created successfully.';
        $hasWarning = false;
        if (isset($budgetWarning)) {
            $hasWarning = true;
        }

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'transaction' => $transaction,
                'message' => $successMessage,
                'budget_warning' => $budgetWarning,
                'budget_info' => $budgetInfo ?? null,
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
        
        // Clear related caches
        $this->clearTransactionCaches();

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
        
        // Clear related caches
        $this->clearTransactionCaches();

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
