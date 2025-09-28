<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = \App\Models\Category::where('user_id', Auth::id())
            ->withCount(['transactions', 'budgets'])
            ->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $typeOptions = Category::getTypeOptions();
        $defaultType = $request->get('type', 'expense'); // Default to expense if type parameter is provided
        return view('categories.create', compact('typeOptions', 'defaultType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string|max:500',
            'color' => 'required|string|regex:/^#?[A-Fa-f0-9]{6}$/',
            'is_default' => 'boolean',
        ]);

        // Ensure color starts with #
        $color = $request->color;
        if (!str_starts_with($color, '#')) {
            $color = '#' . $color;
        }

        $category = \App\Models\Category::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'color' => $color,
            'is_default' => $request->boolean('is_default'),
        ]);

        // If this is set as default, remove default from other categories of same type
        if ($request->boolean('is_default')) {
            $category->setAsDefault();
        }

        // Check if this is an AJAX request
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'category' => $category,
                'message' => 'Category created successfully.'
            ]);
        }

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $this->authorize('view', $category);
        $category = Category::where('user_id', Auth::id())->findOrFail($id);
        
        $category->loadCount('transactions');
        
        $recentTransactions = $category->transactions()
            ->with('account')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        $totalAmount = $category->transactions()->sum('amount');
        $activeBudgets = $category->budgets()
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->count();
            
        return view('categories.show', compact('category', 'recentTransactions', 'totalAmount', 'activeBudgets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // $this->authorize('update', $category);
        $category = Category::where('user_id', Auth::id())->findOrFail($id);
        
        $typeOptions = Category::getTypeOptions();
        return view('categories.edit', compact('category', 'typeOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // $this->authorize('update', $category);
        $category = Category::where('user_id', Auth::id())->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string|max:500',
            'color' => 'required|string|regex:/^#?[A-Fa-f0-9]{6}$/',
            'is_default' => 'boolean',
        ]);

        // Ensure color starts with #
        $color = $request->color;
        if (!str_starts_with($color, '#')) {
            $color = '#' . $color;
        }

        $category->update([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'color' => $color,
            'is_default' => $request->boolean('is_default'),
        ]);

        // If this is set as default, remove default from other categories of same type
        if ($request->boolean('is_default')) {
            $category->setAsDefault();
        }

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // $this->authorize('delete', $category);
        $category = Category::where('user_id', Auth::id())->findOrFail($id);
        
        if ($category->transactions()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'Cannot delete category with existing transactions.');
        }
        
        if ($category->budgets()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'Cannot delete category with existing budgets.');
        }
        
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
