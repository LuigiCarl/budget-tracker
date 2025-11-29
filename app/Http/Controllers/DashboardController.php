<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Dashboard Overview - Web View
     * Simple view that loads data via API calls
     */
    public function index()
    {
        // For web dashboard, we just return the view
        // All data will be loaded via API endpoints using Alpine.js
        return view('dashboard');
    }

    /**
     * Dashboard Statistics API
     * GET /api/dashboard/stats
     * Returns comprehensive dashboard statistics for frontend
     */
    public function getStats(Request $request)
    {
        $userId = Auth::id();
        
        // Calculate total balance from all user accounts
        $totalBalance = \App\Models\Account::where('user_id', $userId)->sum('balance');
        
        // Calculate all-time totals
        $totalIncome = \App\Models\Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->sum('amount');
            
        $totalExpenses = \App\Models\Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->sum('amount');
        
        // Calculate category spending - if no period specified, use all-time data when total_expenses > 0
        $period = $request->get('period', 'current_month');
        
        // If no period specified and we have expenses but no current month data, use all-time
        if ($period === 'current_month' && $totalExpenses > 0) {
            $currentMonthExpenses = \App\Models\Transaction::where('user_id', $userId)
                ->where('type', 'expense')
                ->whereBetween('date', $this->getDateRange('current_month'))
                ->sum('amount');
            
            if ($currentMonthExpenses == 0) {
                $period = 'all_time'; // Use all-time data if no current month expenses
            }
        }
        
        $dateRange = $period === 'all_time' ? null : $this->getDateRange($period);
        
        $categoryQuery = \App\Models\Category::where('categories.user_id', $userId)
            ->where('categories.type', 'expense')
            ->select('categories.id', 'categories.name', 'categories.color')
            ->selectRaw('COALESCE(SUM(transactions.amount), 0) as value')
            ->selectRaw('COALESCE(budgets.amount, 0) as budget_limit')
            ->leftJoin('transactions', function($join) use ($dateRange, $userId) {
                $join->on('categories.id', '=', 'transactions.category_id')
                     ->where('transactions.type', '=', 'expense')
                     ->where('transactions.user_id', '=', $userId);
                
                // Only apply date filter if not all-time
                if ($dateRange !== null) {
                    $join->whereBetween('transactions.date', $dateRange);
                }
            })
            ->leftJoin('budgets', function($join) use ($userId) {
                $join->on('categories.id', '=', 'budgets.category_id')
                     ->where('budgets.user_id', '=', $userId)
                     ->whereDate('budgets.start_date', '<=', now())
                     ->whereDate('budgets.end_date', '>=', now());
            })
            ->groupBy('categories.id', 'categories.name', 'categories.color', 'budgets.amount')
            ->having('value', '>', 0)
            ->orderBy('value', 'desc');
            
        $categorySpending = $categoryQuery->get()
            ->map(function($category) {
                $percentage = $category->budget_limit > 0 ? ($category->value / $category->budget_limit * 100) : 0;
                return [
                    'name' => $category->name,
                    'value' => (float) $category->value,
                    'color' => $category->color,
                    'budget_limit' => (float) $category->budget_limit,
                    'percentage_used' => round($percentage, 1)
                ];
            });

        return response()->json([
            'total_balance' => (float) $totalBalance,
            'income' => (float) $totalIncome,
            'expenses' => (float) $totalExpenses,
            'category_spending' => $categorySpending ? $categorySpending->values() : [],
            'period' => $period,
            'updated_at' => now()->toISOString()
        ]);
    }

    /**
     * Recent Transactions API  
     * GET /api/dashboard/recent-transactions
     * Returns recent transactions with optional limit
     */
    public function getRecentTransactions(Request $request)
    {
        $request->validate([
            'limit' => 'integer|min:1|max:50'
        ]);
        
        $limit = $request->get('limit', 5);
        $userId = Auth::id();
        
        $transactions = \App\Models\Transaction::where('user_id', $userId)
            ->with(['category:id,name,color,type', 'account:id,name'])
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($transaction) {
                // Make expenses negative for frontend display
                $amount = $transaction->type === 'expense' ? -abs($transaction->amount) : $transaction->amount;
                
                return [
                    'id' => $transaction->id,
                    'name' => $transaction->description ?? $transaction->category->name,
                    'date' => $transaction->date,
                    'amount' => (float) $amount,
                    'type' => $transaction->type,
                    'category' => $transaction->category->name,
                    'account' => $transaction->account->name
                ];
            });

        // Get total transaction count
        $totalCount = \App\Models\Transaction::where('user_id', $userId)->count();

        return response()->json([
            'transactions' => $transactions,
            'total_count' => $totalCount,
            'period' => 'last_30_days'
        ]);
    }

    /**
     * Monthly Analytics API
     * GET /api/dashboard/monthly-analytics
     * Returns monthly breakdown of income vs expenses
     * 
     * Parameters:
     * - months: number of months to show (3-12, default: 6)
     * - start_date: optional start date (YYYY-MM-DD format)
     * - auto_detect: if true, automatically finds date range with actual data
     */
    public function getMonthlyAnalytics(Request $request)
    {
        $request->validate([
            'months' => 'integer|min:3|max:12',
            'start_date' => 'date_format:Y-m-d',
            'auto_detect' => 'boolean'
        ]);
        
        $monthCount = $request->get('months', 6);
        $userId = Auth::id();
        $autoDetect = $request->get('auto_detect', true);
        
        // If auto_detect is enabled or no start_date provided, find the optimal date range
        if ($autoDetect || !$request->has('start_date')) {
            // Get the date range of actual transactions
            $transactionRange = \App\Models\Transaction::where('user_id', $userId)
                ->selectRaw('MIN(date) as earliest, MAX(date) as latest')
                ->first();
            
            if ($transactionRange && $transactionRange->latest) {
                // Start from the latest transaction's month and go back
                $startFromDate = \Carbon\Carbon::parse($transactionRange->latest);
            } else {
                // No transactions found, use current date
                $startFromDate = now();
            }
        } else {
            // Use provided start_date
            $startFromDate = \Carbon\Carbon::parse($request->get('start_date'));
        }
        
        $monthlyData = [];
        
        for ($i = $monthCount - 1; $i >= 0; $i--) {
            $date = $startFromDate->copy()->subMonths($i);
            $startDate = $date->copy()->startOfMonth();
            $endDate = $date->copy()->endOfMonth();
            
            $income = \App\Models\Transaction::where('user_id', $userId)
                ->where('type', 'income')
                ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
                ->sum('amount');
                
            $expenses = \App\Models\Transaction::where('user_id', $userId)
                ->where('type', 'expense')
                ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
                ->sum('amount');
            
            $monthlyData[] = [
                'month' => $date->format('M Y'),
                'month_short' => $date->format('M'),
                'income' => (float) $income,
                'expenses' => (float) $expenses,
                'net' => (float) ($income - $expenses)
            ];
        }
        
        return response()->json([
            'period' => $monthCount . ' months',
            'date_range' => [
                'start' => $startFromDate->copy()->subMonths($monthCount - 1)->startOfMonth()->toDateString(),
                'end' => $startFromDate->copy()->endOfMonth()->toDateString()
            ],
            'auto_detected' => $autoDetect && !$request->has('start_date'),
            'data' => $monthlyData
        ]);
    }

    /**
     * Budget Progress API
     * GET /api/dashboard/budget-progress  
     * Returns current budget progress and status
     */
    public function getBudgetProgress()
    {
        $userId = Auth::id();
        $today = now()->toDateString();
        

        
        $budgets = \App\Models\Budget::where('user_id', $userId)
            ->with('category:id,name,color')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->get()
            ->map(function($budget) {
                $spent = \App\Models\Transaction::where('user_id', $budget->user_id)
                    ->where('category_id', $budget->category_id)
                    ->where('type', 'expense')
                    ->whereBetween('date', [$budget->start_date, $budget->end_date])
                    ->sum('amount');
                
                $percentage = $budget->amount > 0 ? ($spent / $budget->amount) * 100 : 0;
                
                return [
                    'id' => $budget->id,
                    'name' => $budget->name,
                    'category' => $budget->category->name,
                    'color' => $budget->category->color,
                    'amount' => (float) $budget->amount,
                    'spent' => (float) $spent,
                    'remaining' => (float) ($budget->amount - $spent),
                    'percentage' => min(round($percentage, 1), 100),
                    'is_exceeded' => $spent > $budget->amount,
                    'is_limiter' => (bool) $budget->is_limiter,
                    'days_remaining' => now()->diffInDays($budget->end_date, false)
                ];
            });

        return response()->json([
            'active_budgets' => $budgets->values(),
            'total_budgets' => $budgets->count(),
            'exceeded_count' => $budgets->where('is_exceeded', true)->count()
        ]);
    }

    /**
     * Helper method to get date range based on period
     */
    private function getDateRange($period)
    {
        switch ($period) {
            case 'current_week':
                return [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()];
            case 'current_month':
                return [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()];
            case 'current_quarter':
                return [now()->startOfQuarter()->toDateString(), now()->endOfQuarter()->toDateString()];
            case 'current_year':
                return [now()->startOfYear()->toDateString(), now()->endOfYear()->toDateString()];
            case 'last_30_days':
                return [now()->subDays(30)->toDateString(), now()->toDateString()];
            case 'last_90_days':
                return [now()->subDays(90)->toDateString(), now()->toDateString()];
            case 'all_time':
                return null; // No date filtering for all-time
            default:
                return [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()];
        }
    }
}
