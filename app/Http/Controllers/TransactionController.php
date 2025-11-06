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
            return redirect()->route('accounts.create')
                ->with('error', 'You need to create at least one account before adding transactions.');
        }
        
        if ($categories->isEmpty()) {
            return redirect()->route('categories.create')
                ->with('error', 'You need to create at least one category before adding transactions.');
        }
        
        // Get default categories for both income and expense
        $defaultIncomeCategory = \App\Models\Category::getDefaultForUser(Auth::id(), 'income');
        $defaultExpenseCategory = \App\Models\Category::getDefaultForUser(Auth::id(), 'expense');
        
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
                        return back()->withErrors([
                            'amount' => "This expense exceeds your budget limit for {$category->name}. Remaining budget: $" . number_format($remaining, 2)
                        ]);
                    } else {
                        // Soft limit - allow but warn
                        $budgetWarning = "This expense will exceed your budget for {$category->name} by $" . number_format($overspendAmount, 2);
                    }
                }
            }
        }

        DB::transaction(function () use ($request, $account) {
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

        return redirect()->route('transactions.index')->with('success', $successMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $this->authorize('view', $transaction);
        $transaction = \App\Models\Transaction::where('user_id', Auth::id())
            ->with(['account', 'category'])
            ->findOrFail($id);
        
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // $this->authorize('update', $transaction);
        $transaction = \App\Models\Transaction::where('user_id', Auth::id())->findOrFail($id);
        
        $accounts = \App\Models\Account::where('user_id', Auth::id())->get();
        $categories = \App\Models\Category::where('user_id', Auth::id())->get();
        
        return view('transactions.edit', compact('transaction', 'accounts', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // $this->authorize('update', $transaction);
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
            return back()->withErrors(['category_id' => 'Category type must match transaction type.']);
        }

        DB::transaction(function () use ($request, $transaction, $account) {
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

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // $this->authorize('delete', $transaction);
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

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}
