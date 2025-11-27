@extends('layouts.base')

@section('title', 'Dashboard - ' . config('app.name'))
@section('app-name', 'Budget Tracker')

@section('content')
<div x-data="dashboardAnalytics()" x-init="init()">
    <!-- Hero Section -->
    <div class="space-y-2 mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="scroll-m-20 text-4xl font-extrabold tracking-tight lg:text-5xl">
                    Dashboard
                </h1>
                <p class="text-xl text-muted-foreground">
                    Welcome back, {{ auth()->user()->name }}! Track your finances and manage your budget.
                </p>
            </div>
            
            <!-- Period Selector -->
            <div class="flex items-center gap-2">
                <label for="period-select" class="text-sm font-medium">Period:</label>
                <select id="period-select" x-model="selectedPeriod" @change="loadDashboardStats()" 
                        class="flex h-10 w-auto min-w-0 rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
                    <option value="current_month">Current Month</option>
                    <option value="current_week">Current Week</option>
                    <option value="current_quarter">Current Quarter</option>
                    <option value="current_year">Current Year</option>
                    <option value="last_30_days">Last 30 Days</option>
                    <option value="last_90_days">Last 90 Days</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Loading State -->
    <div x-show="loading" class="flex items-center justify-center py-12">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
        <span class="ml-2 text-muted-foreground">Loading dashboard data...</span>
    </div>

    <!-- Dashboard Statistics Cards -->
    <div x-show="!loading" class="grid gap-4 sm:gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 mb-6 sm:mb-8">
        <!-- Total Balance -->
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
            <div class="p-4 sm:p-6">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="p-2 sm:p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold">Total Balance</h3>
                        <p class="text-xl sm:text-2xl font-bold text-blue-600 dark:text-blue-400" x-text="formatCurrency(dashboardStats.total_balance)"></p>
                        <p class="text-sm text-muted-foreground" x-text="getPeriodText()"></p>
                    </div>
                </div>
            </div>
        </div>

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
                        <p class="text-xl sm:text-2xl font-bold text-green-600 dark:text-green-400" x-text="formatCurrency(dashboardStats.total_income)"></p>
                        <p class="text-sm text-muted-foreground" x-text="getPeriodText()"></p>
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
                        <p class="text-xl sm:text-2xl font-bold text-red-600 dark:text-red-400" x-text="formatCurrency(dashboardStats.total_expenses)"></p>
                        <p class="text-sm text-muted-foreground" x-text="getPeriodText()"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Net Income -->
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
            <div class="p-4 sm:p-6">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="p-2 sm:p-3" :class="getNetIncomeClass()">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" :class="getNetIncomeTextClass()" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold">Net Income</h3>
                        <p class="text-xl sm:text-2xl font-bold" :class="getNetIncomeTextClass()" x-text="formatCurrency(getNetIncome())"></p>
                        <p class="text-sm text-muted-foreground" x-text="getPeriodText()"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div x-show="!loading" class="mb-6 sm:mb-8">
        <div class="grid gap-4 lg:gap-6 grid-cols-1 lg:grid-cols-2">
            <!-- Category Spending Chart -->
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-4 sm:p-6">
                    <h3 class="text-lg font-semibold mb-4">Spending by Category</h3>
                    <div x-show="dashboardStats.category_spending && dashboardStats.category_spending.length > 0" class="flex justify-center">
                        <canvas id="categorySpendingChart" class="max-w-full h-64"></canvas>
                    </div>
                    <div x-show="!dashboardStats.category_spending || dashboardStats.category_spending.length === 0" class="text-center py-8">
                        <p class="text-muted-foreground">No spending data for this period</p>
                    </div>
                </div>
            </div>
            
            <!-- Monthly Analytics Chart -->
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-4 sm:p-6">
                    <h3 class="text-lg font-semibold mb-4">Income vs Expenses Trend</h3>
                    <div x-show="monthlyData.length > 0" class="flex justify-center">
                        <canvas id="monthlyTrendChart" class="max-w-full h-64"></canvas>
                    </div>
                    <div x-show="monthlyData.length === 0" class="text-center py-8">
                        <p class="text-muted-foreground">Loading trend data...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <div x-show="!loading" class="grid gap-4 sm:gap-6 grid-cols-1 lg:grid-cols-2">
        <!-- Recent Transactions -->
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Recent Transactions</h3>
                    <div class="flex items-center gap-2">
                        <select x-model="transactionLimit" @change="loadRecentTransactions()" 
                                class="text-xs border border-input bg-background px-2 py-1 rounded">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </select>
                        <a href="{{ route('transactions.index') }}" class="text-blue-600 hover:text-blue-700 text-sm">View All</a>
                    </div>
                </div>
                
                <div x-show="recentTransactions.length > 0" class="space-y-3">
                    <template x-for="transaction in recentTransactions" :key="transaction.id">
                        <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 rounded-full" :class="transaction.type === 'income' ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30'">
                                    <div class="w-2 h-2 rounded-full" :style="`background-color: ${transaction.category.color}`"></div>
                                </div>
                                <div>
                                    <p class="font-medium" x-text="transaction.category.name"></p>
                                    <p class="text-sm text-muted-foreground">
                                        <span x-text="transaction.account.name"></span> • 
                                        <span x-text="formatDate(transaction.date)"></span>
                                    </p>
                                    <p x-show="transaction.description" class="text-xs text-muted-foreground" x-text="transaction.description"></p>
                                </div>
                            </div>
                            <p class="font-semibold" :class="transaction.type === 'income' ? 'text-green-600' : 'text-red-600'" 
                               x-text="(transaction.type === 'income' ? '+' : '-') + formatCurrency(Math.abs(parseFloat(transaction.amount)))"></p>
                        </div>
                    </template>
                </div>
                
                <div x-show="recentTransactions.length === 0" class="text-center py-8">
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
            </div>
        </div>

        <!-- Budget Progress -->
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Budget Progress</h3>
                    <a href="{{ route('budgets.index') }}" class="text-blue-600 hover:text-blue-700 text-sm">View All</a>
                </div>
                
                <div x-show="budgetProgress.length > 0" class="space-y-4">
                    <template x-for="budget in budgetProgress.slice(0, 4)" :key="budget.id">
                        <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-base font-semibold" x-text="budget.category.name"></h4>
                                <span class="px-2 py-1 text-xs font-medium rounded-full" 
                                      :class="budget.percentage_used > 100 ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'"
                                      x-text="budget.percentage_used > 100 ? 'Exceeded' : 'On Track'"></span>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span x-text="`Spent: ${formatCurrency(budget.spent_amount)}`"></span>
                                    <span x-text="`Budget: ${formatCurrency(budget.amount)}`"></span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                    <div class="h-2 rounded-full transition-all duration-500" 
                                         :class="budget.percentage_used > 100 ? 'bg-red-600' : 'bg-green-600'"
                                         :style="`width: ${Math.min(budget.percentage_used, 100)}%`"></div>
                                </div>
                                <div class="flex justify-between text-sm text-muted-foreground">
                                    <span x-text="`${budget.percentage_used.toFixed(1)}% used`"></span>
                                    <span x-text="`Remaining: ${formatCurrency(Math.max(budget.remaining_amount, 0))}`"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                
                <div x-show="budgetProgress.length === 0" class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No active budgets</h3>
                    <p class="mt-1 text-sm text-gray-500">Create budgets to track your spending limits.</p>
                    <div class="mt-6">
                        <a href="{{ route('budgets.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Create Budget
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function dashboardAnalytics() {
    return {
        loading: false,
        selectedPeriod: 'current_month',
        transactionLimit: 5,
        dashboardStats: {
            total_balance: 0,
            total_income: 0,
            total_expenses: 0,
            category_spending: []
        },
        recentTransactions: [],
        monthlyData: [],
        budgetProgress: [],
        categoryChart: null,
        trendChart: null,

        async init() {
            console.log('Dashboard analytics initializing...');
            console.log('Alpine.js is working!');
            
            // Test basic API connectivity first
            try {
                const testResponse = await fetch('/test-api');
                const testData = await testResponse.json();
                console.log('Test API response:', testData);
            } catch (error) {
                console.error('Test API failed:', error);
            }
            
            // Set some test data to see if Alpine.js binding is working
            this.dashboardStats = {
                total_balance: 1000,
                total_income: 5000,
                total_expenses: 3000,
                category_spending: [
                    { name: 'Test Category', value: 500, color: '#ef4444' }
                ]
            };
            
            // Load real data
            await this.loadAllData();
        },

        async loadAllData() {
            this.loading = true;
            console.log('Starting to load all dashboard data...');
            
            try {
                // Load data sequentially for easier debugging
                await this.loadDashboardStats();
                await this.loadRecentTransactions();  
                await this.loadMonthlyAnalytics();
                await this.loadBudgetProgress();
                
                console.log('All dashboard data loaded successfully');
            } catch (error) {
                console.error('Error loading dashboard data:', error);
            } finally {
                this.loading = false;
                console.log('Loading completed, loading flag set to false');
            }
        },

        async loadDashboardStats() {
            try {
                console.log('Loading dashboard stats for period:', this.selectedPeriod);
                const response = await fetch(`/api/web/dashboard/stats?period=${this.selectedPeriod}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    }
                });
                
                console.log('Dashboard stats response status:', response.status);
                
                if (response.ok) {
                    const data = await response.json();
                    console.log('Dashboard stats data:', data);
                    this.dashboardStats = data;
                    this.$nextTick(() => this.initCategoryChart());
                } else {
                    const errorText = await response.text();
                    console.error('Dashboard stats error response:', errorText);
                }
            } catch (error) {
                console.error('Error loading dashboard stats:', error);
            }
        },

        async loadRecentTransactions() {
            try {
                console.log('Loading recent transactions, limit:', this.transactionLimit);
                const response = await fetch(`/api/web/dashboard/recent-transactions?limit=${this.transactionLimit}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    }
                });
                
                console.log('Recent transactions response status:', response.status);
                
                if (response.ok) {
                    const data = await response.json();
                    console.log('Recent transactions data:', data);
                    this.recentTransactions = data;
                } else {
                    const errorText = await response.text();
                    console.error('Recent transactions error response:', errorText);
                }
            } catch (error) {
                console.error('Error loading recent transactions:', error);
            }
        },

        async loadMonthlyAnalytics() {
            try {
                console.log('Loading monthly analytics...');
                const response = await fetch('/api/web/dashboard/monthly-analytics', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    }
                });
                
                console.log('Monthly analytics response status:', response.status);
                
                if (response.ok) {
                    const data = await response.json();
                    console.log('Monthly analytics data:', data);
                    this.monthlyData = data;
                    this.$nextTick(() => this.initTrendChart());
                } else {
                    const errorText = await response.text();
                    console.error('Monthly analytics error response:', errorText);
                }
            } catch (error) {
                console.error('Error loading monthly analytics:', error);
            }
        },

        async loadBudgetProgress() {
            try {
                console.log('Loading budget progress...');
                const response = await fetch('/api/web/dashboard/budget-progress', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    }
                });
                
                console.log('Budget progress response status:', response.status);
                
                if (response.ok) {
                    const data = await response.json();
                    console.log('Budget progress data:', data);
                    this.budgetProgress = data;
                } else {
                    const errorText = await response.text();
                    console.error('Budget progress error response:', errorText);
                }
            } catch (error) {
                console.error('Error loading budget progress:', error);
            }
        },

        initCategoryChart() {
            const canvas = document.getElementById('categorySpendingChart');
            if (!canvas || !this.dashboardStats.category_spending?.length) return;

            if (this.categoryChart) {
                this.categoryChart.destroy();
            }

            this.categoryChart = new Chart(canvas, {
                type: 'doughnut',
                data: {
                    labels: this.dashboardStats.category_spending.map(cat => cat.name),
                    datasets: [{
                        data: this.dashboardStats.category_spending.map(cat => cat.value),
                        backgroundColor: this.dashboardStats.category_spending.map(cat => cat.color),
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
                        }
                    },
                    cutout: '50%'
                }
            });
        },

        initTrendChart() {
            const canvas = document.getElementById('monthlyTrendChart');
            if (!canvas || !this.monthlyData?.length) return;

            if (this.trendChart) {
                this.trendChart.destroy();
            }

            this.trendChart = new Chart(canvas, {
                type: 'line',
                data: {
                    labels: this.monthlyData.map(data => data.month_name),
                    datasets: [
                        {
                            label: 'Income',
                            data: this.monthlyData.map(data => data.total_income),
                            borderColor: 'rgb(34, 197, 94)',
                            backgroundColor: 'rgba(34, 197, 94, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Expenses',
                            data: this.monthlyData.map(data => data.total_expenses),
                            borderColor: 'rgb(239, 68, 68)',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.4,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        },

        formatCurrency(amount) {
            return '$' + parseFloat(amount || 0).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        },

        formatDate(dateString) {
            return new Date(dateString).toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
        },

        getPeriodText() {
            const periodNames = {
                'current_month': 'This Month',
                'current_week': 'This Week',
                'current_quarter': 'This Quarter',
                'current_year': 'This Year',
                'last_30_days': 'Last 30 Days',
                'last_90_days': 'Last 90 Days'
            };
            return periodNames[this.selectedPeriod] || 'Current Period';
        },

        getNetIncome() {
            return (this.dashboardStats.total_income || 0) - (this.dashboardStats.total_expenses || 0);
        },

        getNetIncomeClass() {
            const netIncome = this.getNetIncome();
            return netIncome >= 0 
                ? 'bg-blue-100 dark:bg-blue-900/30 rounded-full' 
                : 'bg-orange-100 dark:bg-orange-900/30 rounded-full';
        },

        getNetIncomeTextClass() {
            const netIncome = this.getNetIncome();
            return netIncome >= 0 
                ? 'text-blue-600 dark:text-blue-400' 
                : 'text-orange-600 dark:text-orange-400';
        }
    }
}
</script>
@endpush

