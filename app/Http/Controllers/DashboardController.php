<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get current month data
        $currentMonth = now()->format('Y-m');
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        
        // Summary statistics
        $totalIncome = \App\Models\Transaction::where('user_id', Auth::id())
            ->where('type', 'income')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
            
        $totalExpenses = \App\Models\Transaction::where('user_id', Auth::id())
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
            
        $netIncome = $totalIncome - $totalExpenses;
        
        // Account balances
        $accounts = \App\Models\Account::where('user_id', Auth::id())->withCount('transactions')->get();
        
        // Recent transactions
        $recentTransactions = \App\Models\Transaction::where('user_id', Auth::id())
            ->with(['account', 'category'])
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        // Expenses by category for current month
        $expensesByCategory = \App\Models\Category::where('user_id', Auth::id())
            ->whereHas('transactions', function($query) use ($startOfMonth, $endOfMonth) {
                $query->where('type', 'expense')
                      ->whereBetween('date', [$startOfMonth, $endOfMonth]);
            })
            ->with(['transactions' => function($query) use ($startOfMonth, $endOfMonth) {
                $query->where('type', 'expense')
                      ->whereBetween('date', [$startOfMonth, $endOfMonth]);
            }])
            ->get();
            
        // Active budgets with progress
        $activeBudgets = \App\Models\Budget::where('user_id', Auth::id())
            ->with('category')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();
            
        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'dashboard' => [
                    'total_income' => $totalIncome,
                    'total_expenses' => $totalExpenses,
                    'net_income' => $netIncome,
                    'accounts' => $accounts,
                    'recent_transactions' => $recentTransactions,
                    'expenses_by_category' => $expensesByCategory,
                    'active_budgets' => $activeBudgets,
                    'current_month' => $currentMonth
                ]
            ]);
        }
        
        return view('dashboard', compact(
            'totalIncome',
            'totalExpenses', 
            'netIncome',
            'accounts',
            'recentTransactions',
            'expensesByCategory',
            'activeBudgets',
            'currentMonth'
        ));
    }
}
