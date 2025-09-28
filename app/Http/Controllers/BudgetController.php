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
            // Instead of redirecting, show a message and link to create categories
            return view('budgets.create', [
                'expenseCategories' => collect(),
                'noCategories' => true
            ]);
        }
        
        // Get default expense category
        $defaultExpenseCategory = \App\Models\Category::getDefaultForUser(Auth::id(), 'expense');
        
        return view('budgets.create', compact('expenseCategories', 'defaultExpenseCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string|max:500',
            'is_limiter' => 'boolean',
        ]);

        // Verify that the category belongs to the authenticated user and is an expense category
        $category = \App\Models\Category::where('user_id', Auth::id())
            ->where('id', $request->category_id)
            ->where('type', 'expense')
            ->first();
            
        if (!$category) {
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
            return redirect()->back()->withInput()->with('error', 'A budget for this category already exists in the selected time period.');
        }

        \App\Models\Budget::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'name' => $request->name,
            'amount' => $request->amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'is_limiter' => $request->boolean('is_limiter', false),
        ]);

        return redirect()->route('budgets.index')->with('success', 'Budget created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $this->authorize('view', $budget);
        $budget = Budget::where('user_id', Auth::id())->findOrFail($id);
        
        $transactions = $budget->category->transactions()
            ->where('type', 'expense')
            ->whereBetween('date', [$budget->start_date, $budget->end_date])
            ->with('account')
            ->orderBy('date', 'desc')
            ->paginate(20);
            
        return view('budgets.show', compact('budget', 'transactions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // $this->authorize('update', $budget);
        $budget = \App\Models\Budget::where('user_id', Auth::id())->findOrFail($id);
        
        $expenseCategories = \App\Models\Category::where('user_id', Auth::id())
            ->where('type', 'expense')
            ->get();
            
        // Get default expense category
        $defaultExpenseCategory = \App\Models\Category::getDefaultForUser(Auth::id(), 'expense');
            
        return view('budgets.edit', compact('budget', 'expenseCategories', 'defaultExpenseCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // $this->authorize('update', $budget);
        $budget = \App\Models\Budget::where('user_id', Auth::id())->findOrFail($id);
        
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string|max:500',
            'is_limiter' => 'boolean',
        ]);

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

        return redirect()->route('budgets.index')->with('success', 'Budget updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // $this->authorize('delete', $budget);
        $budget = \App\Models\Budget::where('user_id', Auth::id())->findOrFail($id);
        
        $budget->delete();

        return redirect()->route('budgets.index')->with('success', 'Budget deleted successfully.');
    }
}
