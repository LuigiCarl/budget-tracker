@extends('layouts.base')

@section('title', 'Dashboard - ' . config('app.name'))
@section('app-name', 'Budget Tracker')

@section('content')
    <!-- Hero Section -->
    <div class="space-y-2 mb-8">
        <h1 class="scroll-m-20 text-4xl font-extrabold tracking-tight lg:text-5xl">
            Dashboard
        </h1>
        <p class="text-xl text-muted-foreground">
            Welcome back, {{ auth()->user()->name }}! Track your finances and manage your budget.
        </p>
    </div>

    <!-- Monthly Summary Cards -->
    <div class="grid gap-4 sm:gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mb-6 sm:mb-8">
        <!-- Total Income -->
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
            <div class="p-4 sm:p-6">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="p-2 sm:p-3 bg-green-100 dark:bg-green-900/30 rounded-full">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold">Total Income</h3>
                        <p class="text-xl sm:text-2xl font-bold text-green-600 dark:text-green-400">${{ number_format($totalIncome, 2) }}</p>
                        <p class="text-sm text-muted-foreground">This month</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Expenses -->
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
            <div class="p-4 sm:p-6">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="p-2 sm:p-3 bg-red-100 dark:bg-red-900/30 rounded-full">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold">Total Expenses</h3>
                        <p class="text-xl sm:text-2xl font-bold text-red-600 dark:text-red-400">${{ number_format($totalExpenses, 2) }}</p>
                        <p class="text-sm text-muted-foreground">This month</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Net Income -->
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
            <div class="p-4 sm:p-6">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="p-2 sm:p-3 {{ $netIncome >= 0 ? 'bg-blue-100 dark:bg-blue-900/30' : 'bg-orange-100 dark:bg-orange-900/30' }} rounded-full">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 {{ $netIncome >= 0 ? 'text-blue-600 dark:text-blue-400' : 'text-orange-600 dark:text-orange-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold">Net Income</h3>
                        <p class="text-xl sm:text-2xl font-bold {{ $netIncome >= 0 ? 'text-blue-600 dark:text-blue-400' : 'text-orange-600 dark:text-orange-400' }}">${{ number_format($netIncome, 2) }}</p>
                        <p class="text-sm text-muted-foreground">This month</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Overview Chart -->
    @if($totalExpenses > 0 || $totalIncome > 0)
    <div class="mb-6 sm:mb-8">
        <div class="grid gap-4 lg:gap-6 grid-cols-1 lg:grid-cols-3">
            <!-- Income vs Expenses Pie Chart -->
            <div class="lg:col-span-1 rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-4 sm:p-6">
                    <h3 class="text-lg font-semibold mb-4">Income vs Expenses</h3>
                    <div class="flex justify-center">
                        <canvas id="incomeExpensesChart" class="max-w-full h-48"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Expenses by Category Chart -->
            <div class="lg:col-span-2 rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-4 sm:p-6">
                    <h3 class="text-lg font-semibold mb-4">Expenses by Category</h3>
                    @if($expensesByCategory && $expensesByCategory->count() > 0)
                        <div class="flex justify-center">
                            <canvas id="categoryExpensesChart" class="max-w-full h-48"></canvas>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-muted-foreground">No expenses recorded this month</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Quick Actions -->
    <div class="mb-6 sm:mb-8">
        <h2 class="text-xl sm:text-2xl font-semibold mb-4">Quick Actions</h2>
        <div class="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4">
            <a href="{{ route('transactions.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm sm:text-base">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Transaction
            </a>
            <a href="{{ route('accounts.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-sm sm:text-base">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h4a1 1 0 011 1v5m-6 0V9a1 1 0 011-1h4a1 1 0 011 1v5"></path>
                </svg>
                Add Account
            </a>
            <a href="{{ route('budgets.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors text-sm sm:text-base">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Create Budget
            </a>
            <a href="{{ route('categories.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors text-sm sm:text-base">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                Add Category
            </a>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid gap-4 sm:gap-6 grid-cols-1 lg:grid-cols-2">
        <!-- Accounts Overview -->
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Accounts</h3>
                    <a href="{{ route('accounts.index') }}" class="text-blue-600 hover:text-blue-700 text-sm">View All</a>
                </div>
                @if($accounts->count() > 0)
                    <div class="space-y-3">
                        @foreach($accounts->take(5) as $account)
                            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div>
                                    <p class="font-medium">{{ $account->name }}</p>
                                    <p class="text-sm text-muted-foreground">{{ ucwords(str_replace('_', ' ', $account->type)) }} • {{ $account->transactions_count }} transactions</p>
                                </div>
                                <p class="font-semibold">${{ number_format($account->balance, 2) }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h4a1 1 0 011 1v5m-6 0V9a1 1 0 011-1h4a1 1 0 011 1v5" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No accounts</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating your first account.</p>
                        <div class="mt-6">
                            <a href="{{ route('accounts.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Add Account
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Recent Transactions</h3>
                    <a href="{{ route('transactions.index') }}" class="text-blue-600 hover:text-blue-700 text-sm">View All</a>
                </div>
                @if($recentTransactions->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentTransactions as $transaction)
                            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <div>
                                    <p class="font-medium">{{ $transaction->category->name }}</p>
                                    <p class="text-sm text-muted-foreground">{{ $transaction->account->name }} • {{ $transaction->date->format('M j, Y') }}</p>
                                    @if($transaction->description)
                                        <p class="text-xs text-muted-foreground">{{ $transaction->description }}</p>
                                    @endif
                                </div>
                                <p class="font-semibold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No transactions</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by recording your first transaction.</p>
                        <div class="mt-6">
                            <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Add Transaction
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Budget Progress Section -->
    @if($activeBudgets->count() > 0)
    <div class="mt-6 sm:mt-8">
        <h2 class="text-xl sm:text-2xl font-semibold mb-4">Active Budgets</h2>
        <div class="grid gap-4 sm:gap-6 grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
            @foreach($activeBudgets as $budget)
                <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold">{{ $budget->category->name }}</h3>
                            @if($budget->is_exceeded)
                                <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 rounded-full">
                                    Exceeded
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-full">
                                    On Track
                                </span>
                            @endif
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span>Spent: ${{ number_format($budget->spent_amount, 2) }}</span>
                                <span>Budget: ${{ number_format($budget->amount, 2) }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                <div class="h-2 rounded-full {{ $budget->is_exceeded ? 'bg-red-600' : 'bg-green-600' }}" style="width: {{ min($budget->percentage_used, 100) }}%"></div>
                            </div>
                            <div class="flex justify-between text-sm text-muted-foreground">
                                <span>{{ number_format($budget->percentage_used, 1) }}% used</span>
                                <span>Remaining: ${{ number_format(max($budget->remaining_amount, 0), 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Income vs Expenses Pie Chart
        const incomeExpensesCtx = document.getElementById('incomeExpensesChart');
        if (incomeExpensesCtx) {
            const totalIncome = {{ $totalIncome }};
            const totalExpenses = {{ $totalExpenses }};
            
            if (totalIncome > 0 || totalExpenses > 0) {
                new Chart(incomeExpensesCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Income', 'Expenses'],
                        datasets: [{
                            data: [totalIncome, totalExpenses],
                            backgroundColor: [
                                'rgb(34, 197, 94)',  // Green for income
                                'rgb(239, 68, 68)'   // Red for expenses
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return `${label}: $${value.toLocaleString()} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }

        // Expenses by Category Pie Chart
        const categoryExpensesCtx = document.getElementById('categoryExpensesChart');
        if (categoryExpensesCtx) {
            @if(isset($expensesByCategory) && $expensesByCategory->count() > 0)
                const categoryData = {!! json_encode($expensesByCategory->map(function($category) {
                    return [
                        'label' => $category->name,
                        'value' => $category->transactions->sum('amount'),
                        'color' => $category->color ?? '#6366f1'
                    ];
                })) !!};

                if (categoryData.length > 0) {
                    new Chart(categoryExpensesCtx, {
                        type: 'doughnut',
                        data: {
                            labels: categoryData.map(item => item.label),
                            datasets: [{
                                data: categoryData.map(item => item.value),
                                backgroundColor: categoryData.map(item => item.color),
                                borderWidth: 2,
                                borderColor: '#ffffff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'right',
                                    labels: {
                                        padding: 15,
                                        usePointStyle: true,
                                        generateLabels: function(chart) {
                                            const data = chart.data;
                                            if (data.labels.length && data.datasets.length) {
                                                const total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                                                return data.labels.map((label, i) => {
                                                    const value = data.datasets[0].data[i];
                                                    const percentage = ((value / total) * 100).toFixed(1);
                                                    return {
                                                        text: `${label}: $${value.toLocaleString()} (${percentage}%)`,
                                                        fillStyle: data.datasets[0].backgroundColor[i],
                                                        pointStyle: 'circle'
                                                    };
                                                });
                                            }
                                            return [];
                                        }
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const label = context.label || '';
                                            const value = context.parsed;
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const percentage = ((value / total) * 100).toFixed(1);
                                            return `${label}: $${value.toLocaleString()} (${percentage}%)`;
                                        }
                                    }
                                }
                            },
                            cutout: '40%'
                        }
                    });
                }
            @endif
        }
    });
</script>
@endpush

