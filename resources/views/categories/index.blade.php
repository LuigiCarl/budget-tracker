@extends('layouts.base')

@section('title', 'Categories - ' . config('app.name'))
@section('app-name', 'Budget Tracker')

@section('content')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold">Categories</h1>
            <p class="text-muted-foreground">Organize your income and expenses</p>
        </div>
        <a href="{{ route('categories.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Category
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

    @if($categories->count() > 0)
        <!-- Filter Tabs -->
        <div class="mb-6">
            <div class="flex flex-wrap space-x-1 sm:space-x-2 bg-gray-100 dark:bg-gray-800 rounded-lg p-1">
                <button class="category-filter-btn active px-3 py-2 text-sm font-medium rounded-md transition-colors" data-type="all">
                    All Categories
                </button>
                <button class="category-filter-btn px-3 py-2 text-sm font-medium rounded-md transition-colors" data-type="income">
                    Income
                </button>
                <button class="category-filter-btn px-3 py-2 text-sm font-medium rounded-md transition-colors" data-type="expense">
                    Expense
                </button>
            </div>
        </div>

        <div class="grid gap-4 sm:gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($categories as $category)
                <div class="category-card rounded-lg border border-border bg-card text-card-foreground shadow-sm hover:shadow-md transition-shadow" data-type="{{ $category->type }}">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: {{ $category->color }}20;">
                                    <div class="w-4 h-4 rounded-full" style="background-color: {{ $category->color }};"></div>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-base sm:text-lg font-semibold truncate">{{ $category->name }}</h3>
                                    <p class="text-xs sm:text-sm text-muted-foreground">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $category->type === 'income' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                            {{ ucfirst($category->type) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="flex space-x-1">
                                <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 hover:text-blue-700 p-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 p-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-muted-foreground">Transactions:</span>
                                <span class="font-medium">{{ $category->transactions_count }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-muted-foreground">Budgets:</span>
                                <span class="font-medium">{{ $category->budgets_count }}</span>
                            </div>

                            @if($category->description)
                                <div class="pt-2 border-t border-gray-200 dark:border-gray-600">
                                    <p class="text-xs sm:text-sm text-muted-foreground line-clamp-2">{{ $category->description }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('categories.show', $category) }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 text-sm font-medium">
                                View Details
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
            <h3 class="mt-2 text-xl font-medium text-gray-900 dark:text-gray-100">No categories found</h3>
            <p class="mt-1 text-gray-500">Get started by creating your first category to organize transactions.</p>
            <div class="mt-6">
                <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Category
                </a>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterBtns = document.querySelectorAll('.category-filter-btn');
            const categoryCards = document.querySelectorAll('.category-card');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Update active button
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    const filterType = this.getAttribute('data-type');

                    // Filter categories
                    categoryCards.forEach(card => {
                        const cardType = card.getAttribute('data-type');
                        if (filterType === 'all' || cardType === filterType) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>

    <style>
        .category-filter-btn.active {
            background-color: rgb(59 130 246);
            color: white;
        }
        .category-filter-btn:not(.active) {
            color: rgb(107 114 128);
        }
        .category-filter-btn:not(.active):hover {
            background-color: rgb(229 231 235);
            color: rgb(75 85 99);
        }
        .dark .category-filter-btn:not(.active):hover {
            background-color: rgb(55 65 81);
            color: rgb(209 213 219);
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection