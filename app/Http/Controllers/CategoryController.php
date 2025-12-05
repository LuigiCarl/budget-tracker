<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\CachesApiResponses;

class CategoryController extends Controller
{
    use AuthorizesRequests, CachesApiResponses;

    /**
     * Display a listing of the resource.
     * Cached for 10 minutes (categories change rarely)
     */
    public function index()
    {
        // Check if we should exclude transfer categories (for transaction forms)
        $excludeTransfer = request()->get('exclude_transfer', false);
        
        $query = \App\Models\Category::where('user_id', Auth::id())
            ->withCount(['transactions', 'budgets']);
        
        // Exclude transfer categories if requested
        if ($excludeTransfer) {
            $query->whereNotIn('name', ['Transfer In', 'Transfer Out']);
        }
        
        $categories = $query->get();

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'categories' => $categories
            ]);
        }
        
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $typeOptions = Category::getTypeOptions();
        $defaultType = $request->get('type', 'expense'); // Default to expense if type parameter is provided
        
        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'type_options' => $typeOptions,
                'default_type' => $defaultType
            ]);
        }
        
        return view('categories.create', compact('typeOptions', 'defaultType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('categories')
                    ->where('user_id', Auth::id())
                    ->where('type', $request->type)
            ],
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
        
        // Clear category caches
        $this->clearCategoryCaches();

        // Return JSON for API requests
        if ($request->expectsJson() || $request->is('api/*')) {
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

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'category' => $category,
                'recent_transactions' => $recentTransactions,
                'total_amount' => $totalAmount,
                'active_budgets' => $activeBudgets
            ]);
        }
            
        return view('categories.show', compact('category', 'recentTransactions', 'totalAmount', 'activeBudgets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::where('user_id', Auth::id())->findOrFail($id);
        
        $typeOptions = Category::getTypeOptions();
        
        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'category' => $category,
                'type_options' => $typeOptions
            ]);
        }
        
        return view('categories.edit', compact('category', 'typeOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::where('user_id', Auth::id())->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string|max:500',
            'color' => 'required|string|regex:/^#?[A-Fa-f0-9]{6}$/',
            'is_default' => 'boolean',
        ]);

        // Prevent type change if category has transactions
        if ($request->type !== $category->type && $category->transactions()->count() > 0) {
            if (request()->expectsJson() || request()->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot change category type when transactions exist. Delete transactions first or create a new category.',
                    'errors' => [
                        'type' => ['Cannot change category type when transactions exist.']
                    ]
                ], 422);
            }
            return back()->withErrors(['type' => 'Cannot change category type when transactions exist.']);
        }

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
        
        // Clear category caches
        $this->clearCategoryCaches();

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'category' => $category->fresh(),
                'message' => 'Category updated successfully.'
            ]);
        }

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::where('user_id', Auth::id())->findOrFail($id);
        
        // Check if category has transactions
        $transactionCount = $category->transactions()->count();
        if ($transactionCount > 0) {
            // Find or create "Uncategorized" category
            $uncategorized = Category::firstOrCreate(
                [
                    'user_id' => Auth::id(),
                    'name' => 'Uncategorized',
                    'type' => $category->type,
                ],
                [
                    'color' => '#9CA3AF',
                    'is_default' => true,
                    'description' => 'Default category for uncategorized transactions',
                ]
            );
            
            // Reassign all transactions to Uncategorized
            $category->transactions()->update(['category_id' => $uncategorized->id]);
        }
        
        // Check if category has budgets
        if ($category->budgets()->count() > 0) {
            if (request()->expectsJson() || request()->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete category with existing budgets. Please delete the budgets first.'
                ], 400);
            }
            return redirect()->route('categories.index')->with('error', 'Cannot delete category with existing budgets.');
        }
        
        $category->delete();
        
        // Clear category caches
        $this->clearCategoryCaches();

        // Return JSON for API requests
        if (request()->expectsJson() || request()->is('api/*')) {
            $message = $transactionCount > 0 
                ? "Category deleted successfully. {$transactionCount} transaction(s) moved to Uncategorized."
                : 'Category deleted successfully.';
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        }

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
