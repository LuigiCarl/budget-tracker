@extends('layouts.base')

@section('title', 'Budgets - ' . config('app.name'))
@section('app-name', 'Budget Tracker')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold">Budgets</h1>
            <p class="text-muted-foreground">Monitor your spending limits and budget progress</p>
        </div>
        <a href="{{ route('budgets.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Create Budget
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    @if($budgets->count() > 0)
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($budgets as $budget)
                <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold">{{ $budget->name }}</h3>
                                <p class="text-sm text-muted-foreground">
                                    {{ $budget->category->name }}
                                    @if($budget->is_limiter)
                                        <span class="ml-2 px-2 py-0.5 text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded">
                                            Limiter
                                        </span>
                                    @endif
                                </p>
                            </div>
                            @if($budget->is_exceeded)
                                <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 rounded-full">
                                    @if($budget->overspending_amount > 0)
                                        Overspent ${{ number_format($budget->overspending_amount, 2) }}
                                    @else
                                        Exceeded
                                    @endif
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-full">
                                    On Track
                                </span>
                            @endif
                        </div>

                        <div class="space-y-3">
                            <!-- Budget Period -->
                            <div class="flex justify-between text-sm text-muted-foreground">
                                <span>{{ $budget->start_date->format('M j, Y') }} - {{ $budget->end_date->format('M j, Y') }}</span>
                            </div>

                            <!-- Budget Progress -->
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span>Spent: ${{ number_format($budget->spent_amount, 2) }}</span>
                                    <span>Budget: ${{ number_format($budget->amount, 2) }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                    @if($budget->is_exceeded && $budget->overspending_amount > 0)
                                        <!-- Show budget portion -->
                                        <div class="h-2 rounded-full bg-red-600" style="width: 100%"></div>
                                        <!-- Show overspending -->
                                        <div class="h-1 rounded-full bg-red-800 -mt-0.5" style="width: {{ min(($budget->overspending_amount / $budget->amount) * 100, 100) }}%"></div>
                                    @else
                                        <div class="h-2 rounded-full {{ $budget->is_exceeded ? 'bg-red-600' : 'bg-green-600' }}" 
                                             style="width: {{ min($budget->percentage_used, 100) }}%"></div>
                                    @endif
                                </div>
                                <div class="flex justify-between text-sm text-muted-foreground">
                                    <span>{{ number_format($budget->percentage_used, 1) }}% used</span>
                                    @if($budget->is_exceeded && $budget->overspending_amount > 0)
                                        <span class="text-red-600">Overspent: ${{ number_format($budget->overspending_amount, 2) }}</span>
                                    @else
                                        <span>Remaining: ${{ number_format(max($budget->remaining_amount, 0), 2) }}</span>
                                    @endif
                                </div>
                            </div>

                            @if($budget->description)
                                <div class="pt-2 text-sm text-muted-foreground">
                                    {{ $budget->description }}
                                </div>
                            @endif
                        </div>

                        <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200 dark:border-gray-600">
                            <a href="{{ route('budgets.show', $budget) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                View Details
                            </a>
                            <div class="flex space-x-2">
                                <a href="{{ route('budgets.edit', $budget) }}" class="text-blue-600 hover:text-blue-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('budgets.destroy', $budget) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this budget?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($budgets->hasPages())
            <div class="mt-8">
                {{ $budgets->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <h3 class="mt-2 text-xl font-medium text-gray-900 dark:text-gray-100">No budgets found</h3>
            <p class="mt-1 text-gray-500">Get started by creating your first budget to track spending limits.</p>
            <div class="mt-6">
                <a href="{{ route('budgets.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create Budget
                </a>
            </div>
        </div>
    @endif
@endsection