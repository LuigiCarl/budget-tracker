@extends('layouts.docs')

@section('title', 'Dashboard')

@section('sidebar')
    <x-docs.navigation />
@endsection

@section('content')
<h1>Dashboard</h1>

<p class="text-xl text-muted-foreground">
    Your financial command center - get a complete overview of your finances at a glance.
</p>

<div class="my-6 rounded-lg border overflow-hidden">
    <div class="bg-gradient-to-r from-[#6366F1] to-[#8B5CF6] p-4">
        <h3 class="text-white font-semibold">Dashboard Preview</h3>
    </div>
    <div class="p-6 bg-card">
        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-lg border p-4 text-center">
                <div class="text-2xl font-bold text-[#10B981]">₱25,000</div>
                <div class="text-sm text-muted-foreground">Total Balance</div>
            </div>
            <div class="rounded-lg border p-4 text-center">
                <div class="text-2xl font-bold text-[#6366F1]">₱15,000</div>
                <div class="text-sm text-muted-foreground">Income</div>
            </div>
            <div class="rounded-lg border p-4 text-center">
                <div class="text-2xl font-bold text-[#EF4444]">₱8,000</div>
                <div class="text-sm text-muted-foreground">Expenses</div>
            </div>
        </div>
    </div>
</div>

## Overview

The Dashboard provides a comprehensive view of your financial status including:

- **Total Balance** - Sum of all account balances
- **Monthly Summary** - Income vs expenses for the current month
- **Budget Progress** - Visual indicators for all active budgets
- **Recent Transactions** - Quick view of latest financial activities

## Key Components

### Balance Cards

<div class="my-4 p-4 rounded-lg border bg-muted/50" x-data="{ balance: 25000, income: 15000, expenses: 8000 }">
    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-lg bg-card border p-4">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-[#10B981]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <span class="text-sm font-medium">Total Balance</span>
            </div>
            <div class="text-2xl font-bold" x-text="'₱' + balance.toLocaleString()"></div>
        </div>
        <div class="rounded-lg bg-card border p-4">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-[#6366F1]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                </svg>
                <span class="text-sm font-medium">Income</span>
            </div>
            <div class="text-2xl font-bold text-[#10B981]" x-text="'+₱' + income.toLocaleString()"></div>
        </div>
        <div class="rounded-lg bg-card border p-4">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-[#EF4444]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                </svg>
                <span class="text-sm font-medium">Expenses</span>
            </div>
            <div class="text-2xl font-bold text-[#EF4444]" x-text="'-₱' + expenses.toLocaleString()"></div>
        </div>
    </div>
</div>

### Month Navigation

The dashboard features an interactive month carousel that allows you to:
- View data for any month/year
- Navigate with arrow buttons or swipe gestures
- Quick jump to current month

<div class="my-4 p-4 rounded-lg border bg-muted/50" x-data="{ month: 'December', year: 2025 }">
    <div class="flex items-center justify-center gap-4">
        <button @click="month = 'November'" class="p-2 rounded-full hover:bg-accent">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <div class="text-center">
            <div class="text-lg font-semibold" x-text="month + ' ' + year"></div>
        </div>
        <button @click="month = 'January'; year = 2026" class="p-2 rounded-full hover:bg-accent">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
</div>

### Budget Progress

Visual progress bars show spending against budget limits:

<div class="my-4 space-y-3">
    <div class="p-4 rounded-lg border" x-data="{ spent: 4500, budget: 5000 }">
        <div class="flex justify-between mb-2">
            <span class="font-medium">🍔 Food & Dining</span>
            <span class="text-sm text-muted-foreground" x-text="'₱' + spent + ' / ₱' + budget"></span>
        </div>
        <div class="h-2 bg-muted rounded-full overflow-hidden">
            <div class="h-full bg-[#F59E0B] rounded-full transition-all" :style="'width: ' + (spent/budget*100) + '%'"></div>
        </div>
        <div class="mt-1 text-xs text-muted-foreground" x-text="Math.round(spent/budget*100) + '% used'"></div>
    </div>
    
    <div class="p-4 rounded-lg border" x-data="{ spent: 2000, budget: 3000 }">
        <div class="flex justify-between mb-2">
            <span class="font-medium">🚗 Transportation</span>
            <span class="text-sm text-muted-foreground" x-text="'₱' + spent + ' / ₱' + budget"></span>
        </div>
        <div class="h-2 bg-muted rounded-full overflow-hidden">
            <div class="h-full bg-[#10B981] rounded-full transition-all" :style="'width: ' + (spent/budget*100) + '%'"></div>
        </div>
        <div class="mt-1 text-xs text-muted-foreground" x-text="Math.round(spent/budget*100) + '% used'"></div>
    </div>
    
    <div class="p-4 rounded-lg border" x-data="{ spent: 3500, budget: 3000 }">
        <div class="flex justify-between mb-2">
            <span class="font-medium">🛒 Shopping</span>
            <span class="text-sm text-[#EF4444]" x-text="'₱' + spent + ' / ₱' + budget + ' (Over budget!)'"></span>
        </div>
        <div class="h-2 bg-muted rounded-full overflow-hidden">
            <div class="h-full bg-[#EF4444] rounded-full" style="width: 100%"></div>
        </div>
        <div class="mt-1 text-xs text-[#EF4444]">117% - ₱500 over budget</div>
    </div>
</div>

## API Endpoints

The dashboard uses the following API endpoints:

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/api/dashboard/stats` | GET | Get overall statistics |
| `/api/dashboard/recent-transactions` | GET | Get 5 most recent transactions |
| `/api/dashboard/monthly-analytics` | GET | Get monthly income/expense breakdown |
| `/api/dashboard/budget-progress` | GET | Get all budget progress indicators |

<x-docs.code language="json" title="GET /api/dashboard/stats Response">
{
    "total_balance": 25000,
    "total_income": 15000,
    "total_expenses": 8000,
    "net_savings": 7000,
    "accounts_count": 3,
    "transactions_count": 47
}
</x-docs.code>

## Features

### Real-time Updates
The dashboard automatically refreshes data when:
- A new transaction is added
- A budget is updated
- Account balances change

### Responsive Design
- **Desktop**: Full 3-column layout with detailed charts
- **Tablet**: 2-column layout with condensed information
- **Mobile**: Single column with swipeable sections

<x-docs.callout type="success" title="Pro Tip">
    Click on any budget progress bar to quickly navigate to that budget's detail page and see all related transactions.
</x-docs.callout>
@endsection
