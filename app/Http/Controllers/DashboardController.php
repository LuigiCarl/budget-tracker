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
use Illuminate\Support\Facades\Cache;
use App\Http\Traits\CachesApiResponses;

class DashboardController extends Controller
{
    use CachesApiResponses;
    
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
     * 
     * Supports:
     * - period: current_month, current_week, etc.
     * - year & month: specific month (e.g., year=2025&month=11 for November 2025)
     * 
     * Cached for 5 minutes to reduce database load
     */
    public function getStats(Request $request)
    {
        $userId = Auth::id();
        $period = $request->get('period', 'current_month');
        $year = $request->get('year');
        $month = $request->get('month');
        
        // Build cache key with all params
        $cacheParams = ['period' => $period];
        if ($year && $month) {
            $cacheParams['year'] = $year;
            $cacheParams['month'] = $month;
        }
        
        return $this->cachedResponse(
            'dashboard:stats',
            function () use ($userId, $period, $year, $month) {
                return $this->computeStats($userId, $period, $year, $month);
            },
            $this->shortCacheTtl, // Use shorter cache for faster updates
            $cacheParams
        );
    }
    
    /**
     * Compute dashboard stats (extracted for caching)
     * OPTIMIZED: Uses aggregated queries instead of N+1 loops
     */
    private function computeStats($userId, $period, $year = null, $month = null)
    {
        // Determine date range first
        $dateRange = null;
        if ($year && $month) {
            $startDate = \Carbon\Carbon::create($year, $month, 1)->startOfMonth()->toDateString();
            $endDate = \Carbon\Carbon::create($year, $month, 1)->endOfMonth()->toDateString();
            $dateRange = [$startDate, $endDate];
        } elseif ($period !== 'all_time') {
            $dateRange = $this->getDateRange($period);
        }
        
        // OPTIMIZED: Calculate total balance with single aggregated query
        if ($dateRange) {
            $endOfMonth = $dateRange[1];
            $today = now()->format('Y-m-d');
            
            // Get accounts that existed in this month
            $accounts = \App\Models\Account::where('user_id', $userId)
                ->whereDate('created_at', '<=', $endOfMonth)
                ->get();
            
            if ($endOfMonth >= $today) {
                // Current/future month - just sum current balances
                $totalBalance = $accounts->sum('balance');
            } else {
                // Past month - get all adjustments in one query
                $accountIds = $accounts->pluck('id');
                
                $afterMonthStats = \App\Models\Transaction::whereIn('account_id', $accountIds)
                    ->whereDate('date', '>', $endOfMonth)
                    ->select(
                        'account_id',
                        DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as income_after"),
                        DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as expenses_after")
                    )
                    ->groupBy('account_id')
                    ->get()
                    ->keyBy('account_id');
                
                $totalBalance = 0;
                foreach ($accounts as $account) {
                    $currentBalance = (float) $account->balance;
                    $stats = $afterMonthStats->get($account->id);
                    if ($stats) {
                        $totalBalance += $currentBalance - (float)$stats->income_after + (float)$stats->expenses_after;
                    } else {
                        $totalBalance += $currentBalance;
                    }
                }
            }
        } else {
            $totalBalance = \App\Models\Account::where('user_id', $userId)->sum('balance');
        }
        
        // Get transfer category IDs to exclude from income/expense totals
        $transferCategoryIds = \App\Models\Category::where('user_id', $userId)
            ->whereIn('name', ['Transfer In', 'Transfer Out'])
            ->pluck('id');
        
        // OPTIMIZED: Single query for income and expenses (excluding transfers)
        $totals = \App\Models\Transaction::where('user_id', $userId)
            ->whereNotIn('category_id', $transferCategoryIds)
            ->when($dateRange, function($q) use ($dateRange) {
                $q->whereBetween('date', $dateRange);
            })
            ->select(
                DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as total_income"),
                DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as total_expenses")
            )
            ->first();
        
        $totalIncome = (float) ($totals->total_income ?? 0);
        $totalExpenses = (float) ($totals->total_expenses ?? 0);
        
        // Calculate category spending with date range - OPTIMIZED: Single query with aggregation
        $categorySpendingQuery = \App\Models\Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->select('category_id', DB::raw('SUM(amount) as total_spent'))
            ->groupBy('category_id');
        
        if ($dateRange) {
            $categorySpendingQuery->whereBetween('date', $dateRange);
        }
        
        $spendingByCategory = $categorySpendingQuery->pluck('total_spent', 'category_id');
        
        // Get all expense categories with their budgets in one query
        // Exclude transfer categories from spending breakdown
        $categories = \App\Models\Category::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereNotIn('name', ['Transfer Out', 'Transfer In'])
            ->get();
        
        // Get all active budgets for these categories in one query
        $activeBudgets = \App\Models\Budget::where('user_id', $userId)
            ->whereIn('category_id', $categories->pluck('id'))
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->get()
            ->keyBy('category_id');
        
        $categorySpending = collect();
        
        foreach ($categories as $category) {
            $spending = $spendingByCategory->get($category->id, 0);
            
            // Skip categories with no spending
            if ($spending <= 0) {
                continue;
            }
            
            $budget = $activeBudgets->get($category->id);
            $budgetLimit = $budget ? (float) $budget->amount : 0;
            $percentage = $budgetLimit > 0 ? ($spending / $budgetLimit * 100) : 0;
            
            $categorySpending->push([
                'name' => $category->name,
                'value' => (float) $spending,
                'color' => $category->color,
                'budget_limit' => $budgetLimit,
                'percentage_used' => round($percentage, 1)
            ]);
        }
        
        // Sort by spending amount descending
        $categorySpending = $categorySpending->sortByDesc('value')->values();

        return response()->json([
            'total_balance' => (float) $totalBalance,
            'total_income' => (float) $totalIncome,
            'total_expenses' => (float) $totalExpenses,
            'category_spending' => $categorySpending->all(),
            'period' => $period,
            'cached_at' => now()->toISOString(),
            'updated_at' => now()->toISOString()
        ]);
    }

    /**
     * Recent Transactions API  
     * GET /api/dashboard/recent-transactions
     * Returns recent transactions with optional limit
     * 
     * Cached for 1 minute (transactions change often)
     */
    public function getRecentTransactions(Request $request)
    {
        $request->validate([
            'limit' => 'integer|min:1|max:50',
            'year' => 'integer|min:2000|max:2100',
            'month' => 'integer|min:1|max:12'
        ]);
        
        $limit = $request->get('limit', 5);
        $year = $request->get('year');
        $month = $request->get('month');
        $userId = Auth::id();
        
        // Build cache key with all params
        $cacheParams = ['limit' => $limit];
        if ($year && $month) {
            $cacheParams['year'] = $year;
            $cacheParams['month'] = $month;
        }
        
        return $this->cachedResponse(
            'dashboard:recent-transactions',
            function () use ($userId, $limit, $year, $month) {
                $query = \App\Models\Transaction::where('user_id', $userId)
                    ->with(['category:id,name,color,type', 'account:id,name']);
                
                // Apply month filter if specified
                if ($year && $month) {
                    $startDate = \Carbon\Carbon::create($year, $month, 1)->startOfMonth()->toDateString();
                    $endDate = \Carbon\Carbon::create($year, $month, 1)->endOfMonth()->toDateString();
                    $query->whereBetween('date', [$startDate, $endDate]);
                }
                
                $transactions = $query->orderBy('date', 'desc')
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
                            'category' => [
                                'name' => $transaction->category->name,
                                'color' => $transaction->category->color ?? '#6366F1'
                            ],
                            'account' => $transaction->account->name
                        ];
                    });

                // Get total transaction count for the period
                $totalCountQuery = \App\Models\Transaction::where('user_id', $userId);
                if ($year && $month) {
                    $startDate = \Carbon\Carbon::create($year, $month, 1)->startOfMonth()->toDateString();
                    $endDate = \Carbon\Carbon::create($year, $month, 1)->endOfMonth()->toDateString();
                    $totalCountQuery->whereBetween('date', [$startDate, $endDate]);
                }
                $totalCount = $totalCountQuery->count();

                return response()->json([
                    'transactions' => $transactions,
                    'total_count' => $totalCount,
                    'period' => ($year && $month) ? "{$year}-{$month}" : 'all_time',
                    'cached_at' => now()->toISOString()
                ]);
            },
            60, // 1 minute cache for faster updates
            $cacheParams
        );
    }

    /**
     * Monthly Analytics API
     * GET /api/dashboard/monthly-analytics
     * Returns monthly breakdown of income vs expenses
     * 
     * Cached for 10 minutes (analytics don't change often)
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
        $startDate = $request->get('start_date');
        
        return $this->cachedResponse(
            'dashboard:monthly-analytics',
            function () use ($userId, $monthCount, $autoDetect, $startDate) {
                return $this->computeMonthlyAnalytics($userId, $monthCount, $autoDetect, $startDate);
            },
            600, // 10 minutes
            ['months' => $monthCount, 'auto_detect' => $autoDetect, 'start_date' => $startDate]
        );
    }
    
    /**
     * Compute monthly analytics (extracted for caching)
     */
    private function computeMonthlyAnalytics($userId, $monthCount, $autoDetect, $startDate)
    {
        // If auto_detect is enabled or no start_date provided, find the optimal date range
        if ($autoDetect || !$startDate) {
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
            $startFromDate = \Carbon\Carbon::parse($startDate);
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
            'auto_detected' => $autoDetect && !$startDate,
            'data' => $monthlyData,
            'cached_at' => now()->toISOString()
        ]);
    }

    /**
     * Budget Progress API
     * GET /api/dashboard/budget-progress  
     * Returns current budget progress and status
     * 
     * Cached for 5 minutes
     */
    public function getBudgetProgress()
    {
        $userId = Auth::id();
        
        return $this->cachedResponse(
            'dashboard:budget-progress',
            function () use ($userId) {
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
                    'exceeded_count' => $budgets->where('is_exceeded', true)->count(),
                    'cached_at' => now()->toISOString()
                ]);
            },
            $this->defaultCacheTtl
        );
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
