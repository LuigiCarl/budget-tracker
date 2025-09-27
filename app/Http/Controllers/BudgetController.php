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
        $budgets = Auth::user()->budgets()
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
        $expenseCategories = Auth::user()->categories()
            ->where('type', 'expense')
            ->get();
            
        if ($expenseCategories->isEmpty()) {
            return redirect()->route('categories.create')
                ->with('error', 'You need to create at least one expense category before creating budgets.');
        }
        
        return view('budgets.create', compact('expenseCategories'));
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
        ]);

        // Verify that the category belongs to the authenticated user and is an expense category
        $category = Auth::user()->categories()
            ->where('id', $request->category_id)
            ->where('type', 'expense')
            ->firstOrFail();

        // Check for overlapping budgets
        $overlappingBudget = $category->budgets()
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

        Auth::user()->budgets()->create($request->all());

        return redirect()->route('budgets.index')->with('success', 'Budget created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget)
    {
        $this->authorize('view', $budget);
        
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
    public function edit(Budget $budget)
    {
        $this->authorize('update', $budget);
        
        $expenseCategories = Auth::user()->categories()
            ->where('type', 'expense')
            ->get();
            
        return view('budgets.edit', compact('budget', 'expenseCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget)
    {
        $this->authorize('update', $budget);
        
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string|max:500',
        ]);

        // Verify that the category belongs to the authenticated user and is an expense category
        $category = Auth::user()->categories()
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

        $budget->update($request->all());

        return redirect()->route('budgets.index')->with('success', 'Budget updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        $this->authorize('delete', $budget);
        
        $budget->delete();

        return redirect()->route('budgets.index')->with('success', 'Budget deleted successfully.');
    }
}
