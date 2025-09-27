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
        $transactions = Auth::user()->transactions()
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
        $accounts = Auth::user()->accounts()->get();
        $categories = Auth::user()->categories()->get();
        
        if ($accounts->isEmpty()) {
            return redirect()->route('accounts.create')
                ->with('error', 'You need to create at least one account before adding transactions.');
        }
        
        if ($categories->isEmpty()) {
            return redirect()->route('categories.create')
                ->with('error', 'You need to create at least one category before adding transactions.');
        }
        
        return view('transactions.create', compact('accounts', 'categories'));
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
        $account = Auth::user()->accounts()->findOrFail($request->account_id);
        $category = Auth::user()->categories()->findOrFail($request->category_id);

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

            if ($activeBudget && $activeBudget->wouldExceedWith($request->amount)) {
                $remaining = max($activeBudget->remaining_amount, 0);
                return back()->withErrors([
                    'amount' => "This expense would exceed your budget for {$category->name}. Remaining budget: $" . number_format($remaining, 2)
                ]);
            }
        }

        DB::transaction(function () use ($request, $account) {
            // Create the transaction
            $transaction = Auth::user()->transactions()->create($request->all());

            // Update account balance
            if ($request->type === 'income') {
                $account->increment('balance', $request->amount);
            } else {
                $account->decrement('balance', $request->amount);
            }
        });

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);
        
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        $this->authorize('update', $transaction);
        
        $accounts = Auth::user()->accounts()->get();
        $categories = Auth::user()->categories()->get();
        
        return view('transactions.edit', compact('transaction', 'accounts', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);
        
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
        $account = Auth::user()->accounts()->findOrFail($request->account_id);
        $category = Auth::user()->categories()->findOrFail($request->category_id);

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
            $transaction->update($request->all());

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
    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);
        
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
