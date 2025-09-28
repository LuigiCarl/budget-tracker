@extends('layouts.base')

@section('title', 'Create Budget - ' . config('app.name'))
@section('app-name', 'Budget Tracker')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold">Create Budget</h1>
                <p class="text-muted-foreground">Set spending limits for your expense categories</p>
            </div>
            <a href="{{ route('budgets.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Budgets
            </a>
        </div>

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif
        
        @if (isset($noCategories) && $noCategories)
            <div class="mb-6 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg">
                <h3 class="font-medium mb-2">No Expense Categories Found</h3>
                <p class="mb-3">You need to create at least one expense category before you can create budgets.</p>
                <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create Expense Category
                </a>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (!isset($noCategories) || !$noCategories)
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
            <div class="p-6">
                <form action="{{ route('budgets.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- Budget Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Budget Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                   placeholder="e.g., Monthly Food Budget"
                                   required>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" 
                                    id="category_id" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                    required>
                                <option value="">Select expense category</option>
                                @foreach($expenseCategories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-sm text-gray-500">Only expense categories can have budgets</p>
                        </div>

                        <!-- Budget Amount -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Budget Amount <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" 
                                       name="amount" 
                                       id="amount" 
                                       value="{{ old('amount') }}"
                                       step="0.01"
                                       min="0.01"
                                       class="block w-full pl-7 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                       placeholder="0.00"
                                       required>
                            </div>
                        </div>

                        <!-- Budget Period -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Start Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="start_date" 
                                       id="start_date" 
                                       value="{{ old('start_date', date('Y-m-01')) }}"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                       required>
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    End Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="end_date" 
                                       id="end_date" 
                                       value="{{ old('end_date', date('Y-m-t')) }}"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                       required>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Description
                            </label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="3"
                                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                      placeholder="Optional description for this budget">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-600">
                        <a href="{{ route('budgets.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Create Budget
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
@endsection