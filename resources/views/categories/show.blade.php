@extends('layouts.base')

@section('title', $category->name . ' - ' . config('app.name'))
@section('app-name', 'Budget Tracker')

@section('content')
    <div class="space-y-4 sm:space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-4 h-4 rounded-full" style="background-color: {{ $category->color ?? '#6366f1' }}"></div>
                    <h1 class="scroll-m-20 text-2xl sm:text-4xl font-extrabold tracking-tight">
                        {{ $category->name }}
                    </h1>
                </div>
                <p class="text-base sm:text-xl text-muted-foreground">
                    {{ ucfirst($category->type) }} Category Details
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <a href="{{ route('categories.edit', $category) }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Category
                </a>
                <a href="{{ route('categories.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-border rounded-lg hover:bg-accent transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Categories
                </a>
            </div>
        </div>

        <!-- Category Info Cards -->
        <div class="grid gap-4 sm:gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Type Card -->
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 {{ $category->type === 'income' ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} rounded-full">
                            @if($category->type === 'income')
                                <svg class="h-5 w-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            @else
                                <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-semibold">Type</h3>
                            <p class="text-sm {{ $category->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                {{ ucfirst($category->type) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Transactions -->
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                            <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">Total Transactions</h3>
                            <p class="text-xl font-bold text-blue-600 dark:text-blue-400">
                                {{ $category->transactions_count }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Amount -->
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-full">
                            <svg class="h-5 w-5 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">Total Amount</h3>
                            <p class="text-xl font-bold text-purple-600 dark:text-purple-400">
                                ${{ number_format($totalAmount, 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Budgets -->
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-orange-100 dark:bg-orange-900/30 rounded-full">
                            <svg class="h-5 w-5 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">Active Budgets</h3>
                            <p class="text-xl font-bold text-orange-600 dark:text-orange-400">
                                {{ $activeBudgets }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        @if($category->description)
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
            <div class="p-4 sm:p-6">
                <h3 class="text-lg font-semibold mb-2">Description</h3>
                <p class="text-muted-foreground">{{ $category->description }}</p>
            </div>
        </div>
        @endif

        <!-- Recent Transactions -->
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
            <div class="p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                    <h3 class="text-lg font-semibold">Recent Transactions</h3>
                    <a href="{{ route('transactions.create', ['category' => $category->id]) }}" class="inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Transaction
                    </a>
                </div>
                
                @if($recentTransactions->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentTransactions as $transaction)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg gap-2">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <p class="font-medium">{{ $transaction->account->name }}</p>
                                        <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 rounded-full">
                                            {{ ucwords(str_replace('_', ' ', $transaction->account->type)) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-muted-foreground">{{ $transaction->date->format('M j, Y') }}</p>
                                    @if($transaction->description)
                                        <p class="text-xs text-muted-foreground mt-1">{{ $transaction->description }}</p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                    </p>
                                    <div class="flex gap-1 mt-1 justify-end">
                                        <a href="{{ route('transactions.edit', $transaction) }}" class="text-blue-600 hover:text-blue-700 text-xs">
                                            Edit
                                        </a>
                                        <span class="text-gray-300 text-xs">|</span>
                                        <form method="POST" action="{{ route('transactions.destroy', $transaction) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this transaction?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700 text-xs">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($category->transactions_count > 10)
                        <div class="mt-4 text-center">
                            <a href="{{ route('transactions.index', ['category' => $category->id]) }}" class="text-blue-600 hover:text-blue-700 text-sm">
                                View all {{ $category->transactions_count }} transactions →
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No transactions</h3>
                        <p class="mt-1 text-sm text-gray-500">This category doesn't have any transactions yet.</p>
                        <div class="mt-6">
                            <a href="{{ route('transactions.create', ['category' => $category->id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Add Transaction
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Delete Category -->
        <div class="rounded-lg border border-red-200 bg-red-50 dark:bg-red-900/10 dark:border-red-800">
            <div class="p-4 sm:p-6">
                <h3 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-2">Danger Zone</h3>
                <p class="text-sm text-red-600 dark:text-red-300 mb-4">
                    Once you delete this category, there is no going back. This action cannot be undone.
                    @if($category->transactions_count > 0)
                        <br><strong>Warning:</strong> This category has {{ $category->transactions_count }} transaction(s). Deleting it will also remove all associated transactions.
                    @endif
                </p>
                <form method="POST" action="{{ route('categories.destroy', $category) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone and will remove all associated transactions.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete Category
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection