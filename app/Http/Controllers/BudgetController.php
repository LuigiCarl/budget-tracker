<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BudgetController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $budgets = \App\Models\Budget::where('user_id', Auth::id())
            ->with('category')
            ->orderBy('start_date', 'desc')
            ->paginate(15);

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'budgets' => $budgets
            ]);
        }
            
        return view('budgets.index', compact('budgets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $expenseCategories = \App\Models\Category::where('user_id', Auth::id())
            ->where('type', 'expense')
            ->get();
            
        if ($expenseCategories->isEmpty()) {
            // Return appropriate response for API or web
            if (request()->expectsJson() || request()->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'You need to create at least one expense category before creating budgets.',
                    'errors' => [
                        'category_id' => ['You need to create at least one expense category before creating budgets.']
                    ]
                ], 422);
            }
            return view('budgets.create', [
                'expenseCategories' => collect(),
                'noCategories' => true
            ]);
        }
        
        // Get default expense category
        $defaultExpenseCategory = \App\Models\Category::getDefaultForUser(Auth::id(), 'expense');
        
        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'expense_categories' => $expenseCategories,
                'default_expense_category' => $defaultExpenseCategory
            ]);
        }
        
        return view('budgets.create', compact('expenseCategories', 'defaultExpenseCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Handle validation for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'amount' => 'required|numeric|min:0.01',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'description' => 'nullable|string|max:500',
                'is_limiter' => 'boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors()
                ], 422);
            }
        } else {
            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'amount' => 'required|numeric|min:0.01',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'description' => 'nullable|string|max:500',
                'is_limiter' => 'boolean',
            ]);
        }

        // Verify that the category belongs to the authenticated user and is an expense category
        $category = \App\Models\Category::where('user_id', Auth::id())
            ->where('id', $request->category_id)
            ->where('type', 'expense')
            ->first();
            
        if (!$category) {
            if (request()->expectsJson() || request()->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid category selected.',
                    'errors' => [
                        'category_id' => ['Invalid category selected.']
                    ]
                ], 422);
            }
            return redirect()->back()->withInput()->with('error', 'Invalid category selected.');
        }

        // Check for overlapping budgets for the same category
        $overlapping = \App\Models\Budget::where('user_id', Auth::id())
            ->where('category_id', $request->category_id)
            ->where(function($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                      ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                      ->orWhere(function($subQuery) use ($request) {
                          $subQuery->where('start_date', '<=', $request->start_date)
                                   ->where('end_date', '>=', $request->end_date);
                      });
            })->exists();
            
        if ($overlapping) {
            if (request()->expectsJson() || request()->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'A budget for this category already exists in the selected time period.',
                    'errors' => [
                        'start_date' => ['A budget for this category already exists in the selected time period.']
                    ]
                ], 422);
            }
            return redirect()->back()->withInput()->with('error', 'A budget for this category already exists in the selected time period.');
        }

        $budget = \App\Models\Budget::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'name' => $request->name,
            'amount' => $request->amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'is_limiter' => $request->boolean('is_limiter', false),
        ]);

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'budget' => $budget,
                'message' => 'Budget created successfully.'
            ], 201);
        }

        return redirect()->route('budgets.index')->with('success', 'Budget created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $budget = Budget::where('user_id', Auth::id())->findOrFail($id);
        
        $transactions = $budget->category->transactions()
            ->where('type', 'expense')
            ->whereBetween('date', [$budget->start_date, $budget->end_date])
            ->with('account')
            ->orderBy('date', 'desc')
            ->paginate(20);

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'budget' => $budget,
                'transactions' => $transactions
            ]);
        }
            
        return view('budgets.show', compact('budget', 'transactions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $budget = \App\Models\Budget::where('user_id', Auth::id())->findOrFail($id);
        
        $expenseCategories = \App\Models\Category::where('user_id', Auth::id())
            ->where('type', 'expense')
            ->get();
            
        // Get default expense category
        $defaultExpenseCategory = \App\Models\Category::getDefaultForUser(Auth::id(), 'expense');
        
        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'budget' => $budget,
                'expense_categories' => $expenseCategories,
                'default_expense_category' => $defaultExpenseCategory
            ]);
        }
            
        return view('budgets.edit', compact('budget', 'expenseCategories', 'defaultExpenseCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $budget = \App\Models\Budget::where('user_id', Auth::id())->findOrFail($id);
        
        // Handle validation for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'amount' => 'required|numeric|min:0.01',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'description' => 'nullable|string|max:500',
                'is_limiter' => 'boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors()
                ], 422);
            }
        } else {
            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'amount' => 'required|numeric|min:0.01',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'description' => 'nullable|string|max:500',
                'is_limiter' => 'boolean',
            ]);
        }

        // Verify that the category belongs to the authenticated user and is an expense category
        $category = \App\Models\Category::where('user_id', Auth::id())
            ->where('id', $request->category_id)
            ->where('type', 'expense')
            ->firstOrFail();

        // Check for overlapping budgets (excluding current budget)
        $overlappingBudget = $category->budgets()
            ->where('id', '!=', $budget->id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                    });
            })
            ->exists();

        if ($overlappingBudget) {
            if (request()->expectsJson() || request()->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'This date range overlaps with an existing budget for this category.',
                    'errors' => [
                        'start_date' => ['This date range overlaps with an existing budget for this category.']
                    ]
                ], 422);
            }
            return back()->withErrors([
                'start_date' => 'This date range overlaps with an existing budget for this category.'
            ]);
        }

        $budget->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'amount' => $request->amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'is_limiter' => $request->boolean('is_limiter', false),
        ]);

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'budget' => $budget->fresh(),
                'message' => 'Budget updated successfully.'
            ]);
        }

        return redirect()->route('budgets.index')->with('success', 'Budget updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $budget = \App\Models\Budget::where('user_id', Auth::id())->findOrFail($id);
        
        $budget->delete();

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Budget deleted successfully.'
            ]);
        }

        return redirect()->route('budgets.index')->with('success', 'Budget deleted successfully.');
    }
}
