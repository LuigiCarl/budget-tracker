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
        $totalIncome = $user->transactions()
            ->where('type', 'income')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
            
        $totalExpenses = $user->transactions()
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
            
        $netIncome = $totalIncome - $totalExpenses;
        
        // Account balances
        $accounts = $user->accounts()->withCount('transactions')->get();
        
        // Recent transactions
        $recentTransactions = $user->transactions()
            ->with(['account', 'category'])
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        // Expenses by category for current month
        $expensesByCategory = $user->transactions()
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->with('category')
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->get();
            
        // Active budgets with progress
        $activeBudgets = $user->budgets()
            ->with('category')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();
            
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
