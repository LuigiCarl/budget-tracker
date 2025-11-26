<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Budget;

class AnalyticsController extends Controller
{
    /**
     * Get monthly analytics for a specific year
     * GET /api/analytics/monthly?year={year}
     */
    public function monthly(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $userId = Auth::id();
        
        $monthlyData = [];
        
        for ($month = 1; $month <= 12; $month++) {
            $startDate = sprintf('%04d-%02d-01', $year, $month);
            $endDate = date('Y-m-t', strtotime($startDate));
            
            $income = Transaction::where('user_id', $userId)
                ->where('type', 'income')
                ->whereBetween('date', [$startDate, $endDate])
                ->sum('amount');
                
            $expenses = Transaction::where('user_id', $userId)
                ->where('type', 'expense')
                ->whereBetween('date', [$startDate, $endDate])
                ->sum('amount');
            
            $monthlyData[] = [
                'month' => $month,
                'month_name' => date('F', strtotime($startDate)),
                'income' => (float) $income,
                'expenses' => (float) $expenses,
                'net' => (float) ($income - $expenses),
            ];
        }
        
        return response()->json([
            'year' => (int) $year,
            'data' => $monthlyData,
        ]);
    }
    
    /**
     * Get spending trends over a period
     * GET /api/analytics/trends?period={30|90|365}
     */
    public function trends(Request $request)
    {
        $period = $request->input('period', 30);
        $allowedPeriods = [30, 90, 365];
        
        if (!in_array($period, $allowedPeriods)) {
            return response()->json(['error' => 'Invalid period. Use 30, 90, or 365'], 400);
        }
        
        $userId = Auth::id();
        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime("-{$period} days"));
        
        $income = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');
            
        $expenses = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');
        
        $categoryBreakdown = Category::where('user_id', $userId)
            ->where('type', 'expense')
            ->with(['transactions' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            }])
            ->get()
            ->map(function($category) {
                return [
                    'name' => $category->name,
                    'color' => $category->color,
                    'total' => (float) $category->transactions->sum('amount'),
                ];
            })
            ->filter(function($category) {
                return $category['total'] > 0;
            })
            ->values();
        
        return response()->json([
            'period_days' => (int) $period,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_income' => (float) $income,
            'total_expenses' => (float) $expenses,
            'net_income' => (float) ($income - $expenses),
            'category_breakdown' => $categoryBreakdown,
        ]);
    }
    
    /**
     * Get category breakdown for a specific month
     * GET /api/analytics/category-breakdown?month={YYYY-MM}
     */
    public function categoryBreakdown(Request $request)
    {
        $month = $request->input('month', date('Y-m'));
        $userId = Auth::id();
        
        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
            return response()->json(['error' => 'Invalid month format. Use YYYY-MM'], 400);
        }
        
        $startDate = $month . '-01';
        $endDate = date('Y-m-t', strtotime($startDate));
        
        $incomeCategories = Category::where('user_id', $userId)
            ->where('type', 'income')
            ->with(['transactions' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            }])
            ->get()
            ->map(function($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'color' => $category->color,
                    'total' => (float) $category->transactions->sum('amount'),
                    'count' => $category->transactions->count(),
                ];
            });
        
        $expenseCategories = Category::where('user_id', $userId)
            ->where('type', 'expense')
            ->with(['transactions' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            }])
            ->get()
            ->map(function($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'color' => $category->color,
                    'total' => (float) $category->transactions->sum('amount'),
                    'count' => $category->transactions->count(),
                ];
            });
        
        return response()->json([
            'month' => $month,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'income_categories' => $incomeCategories,
            'expense_categories' => $expenseCategories,
        ]);
    }
    
    /**
     * Get budget performance metrics
     * GET /api/analytics/budget-performance
     */
    public function budgetPerformance()
    {
        $userId = Auth::id();
        $now = date('Y-m-d');
        
        $budgets = Budget::where('user_id', $userId)
            ->with('category')
            ->get()
            ->map(function($budget) use ($now) {
                $spent = Transaction::where('user_id', $budget->user_id)
                    ->where('category_id', $budget->category_id)
                    ->where('type', 'expense')
                    ->whereBetween('date', [$budget->start_date, $budget->end_date])
                    ->sum('amount');
                
                $percentage = $budget->amount > 0 ? ($spent / $budget->amount) * 100 : 0;
                $isActive = $budget->start_date <= $now && $budget->end_date >= $now;
                
                return [
                    'id' => $budget->id,
                    'name' => $budget->name,
                    'category' => [
                        'id' => $budget->category->id,
                        'name' => $budget->category->name,
                        'color' => $budget->category->color,
                    ],
                    'amount' => (float) $budget->amount,
                    'spent' => (float) $spent,
                    'remaining' => (float) ($budget->amount - $spent),
                    'percentage' => round($percentage, 2),
                    'is_exceeded' => $spent > $budget->amount,
                    'is_active' => $isActive,
                    'start_date' => $budget->start_date,
                    'end_date' => $budget->end_date,
                ];
            });
        
        $activeBudgets = $budgets->where('is_active', true)->values();
        $exceededBudgets = $budgets->where('is_exceeded', true)->values();
        
        return response()->json([
            'all_budgets' => $budgets->values(),
            'active_budgets' => $activeBudgets,
            'exceeded_budgets' => $exceededBudgets,
            'summary' => [
                'total_budgets' => $budgets->count(),
                'active_count' => $activeBudgets->count(),
                'exceeded_count' => $exceededBudgets->count(),
            ],
        ]);
    }
}
