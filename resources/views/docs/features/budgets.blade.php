@extends('layouts.docs')

@section('title', 'Budgets')

@section('sidebar')
    <x-docs.navigation />
@endsection

@section('content')
<h1>Budgets</h1>

<p class="text-xl text-muted-foreground">
    Set spending limits and track your progress to achieve your financial goals.
</p>

<div class="my-6 rounded-lg border overflow-hidden">
    <div class="bg-gradient-to-r from-[#F59E0B] to-[#D97706] p-4">
        <h3 class="text-white font-semibold">Budget Management</h3>
    </div>
    <div class="p-4 bg-card">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-[#F59E0B]/10 flex items-center justify-center">
                <svg class="w-8 h-8 text-[#F59E0B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold">₱15,000</div>
                <div class="text-muted-foreground">Total Budget This Month</div>
            </div>
        </div>
    </div>
</div>

## How Budgets Work

Budgets in FinanEase help you control spending by:

1. **Setting Limits** - Define maximum spending for each category
2. **Tracking Progress** - Real-time updates as you spend
3. **Getting Alerts** - Warnings when approaching or exceeding limits
4. **Analyzing Trends** - See spending patterns over time

## Creating a Budget

<div class="my-6" x-data="{ 
    category: '',
    amount: '',
    period: 'monthly',
    step: 1
}">
    <div class="rounded-lg border overflow-hidden">
        <div class="bg-muted px-4 py-2 border-b">
            <span class="font-medium">New Budget</span>
        </div>
        <div class="p-4 space-y-4">
            <!-- Step Indicator -->
            <div class="flex items-center gap-2 mb-6">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium"
                         :class="step >= 1 ? 'bg-primary text-white' : 'bg-muted'">1</div>
                    <div class="w-12 h-1" :class="step >= 2 ? 'bg-primary' : 'bg-muted'"></div>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium"
                         :class="step >= 2 ? 'bg-primary text-white' : 'bg-muted'">2</div>
                    <div class="w-12 h-1" :class="step >= 3 ? 'bg-primary' : 'bg-muted'"></div>
                </div>
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium"
                     :class="step >= 3 ? 'bg-primary text-white' : 'bg-muted'">3</div>
            </div>

            <!-- Step 1: Category -->
            <div x-show="step === 1" x-transition>
                <label class="text-sm font-medium mb-3 block">Select Category</label>
                <div class="grid grid-cols-2 gap-2">
                    <button @click="category = 'food'; step = 2" 
                            class="p-3 rounded-lg border hover:border-primary hover:bg-primary/5 text-left transition-colors">
                        <span class="text-xl">🍔</span>
                        <span class="ml-2 font-medium">Food & Dining</span>
                    </button>
                    <button @click="category = 'transport'; step = 2" 
                            class="p-3 rounded-lg border hover:border-primary hover:bg-primary/5 text-left transition-colors">
                        <span class="text-xl">🚗</span>
                        <span class="ml-2 font-medium">Transportation</span>
                    </button>
                    <button @click="category = 'shopping'; step = 2" 
                            class="p-3 rounded-lg border hover:border-primary hover:bg-primary/5 text-left transition-colors">
                        <span class="text-xl">🛒</span>
                        <span class="ml-2 font-medium">Shopping</span>
                    </button>
                    <button @click="category = 'entertainment'; step = 2" 
                            class="p-3 rounded-lg border hover:border-primary hover:bg-primary/5 text-left transition-colors">
                        <span class="text-xl">🎬</span>
                        <span class="ml-2 font-medium">Entertainment</span>
                    </button>
                </div>
            </div>

            <!-- Step 2: Amount -->
            <div x-show="step === 2" x-transition>
                <label class="text-sm font-medium mb-3 block">Set Budget Amount</label>
                <div class="relative mb-4">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground text-lg">₱</span>
                    <input type="number" x-model="amount" placeholder="5,000" 
                           class="w-full pl-10 pr-4 py-3 text-2xl rounded-lg border bg-background focus:ring-2 focus:ring-primary outline-none">
                </div>
                
                <!-- Quick Amount Buttons -->
                <div class="flex gap-2 mb-4">
                    <button @click="amount = 3000" class="px-4 py-2 rounded-lg bg-muted hover:bg-muted/80 text-sm">₱3,000</button>
                    <button @click="amount = 5000" class="px-4 py-2 rounded-lg bg-muted hover:bg-muted/80 text-sm">₱5,000</button>
                    <button @click="amount = 10000" class="px-4 py-2 rounded-lg bg-muted hover:bg-muted/80 text-sm">₱10,000</button>
                </div>
                
                <div class="flex gap-2">
                    <button @click="step = 1" class="px-4 py-2 rounded-lg bg-muted hover:bg-muted/80">Back</button>
                    <button @click="step = 3" class="flex-1 px-4 py-2 rounded-lg bg-primary text-white hover:bg-primary/90">Continue</button>
                </div>
            </div>

            <!-- Step 3: Period -->
            <div x-show="step === 3" x-transition>
                <label class="text-sm font-medium mb-3 block">Budget Period</label>
                <div class="space-y-2 mb-4">
                    <button @click="period = 'weekly'" 
                            :class="period === 'weekly' ? 'border-primary bg-primary/5' : ''"
                            class="w-full p-3 rounded-lg border hover:border-primary text-left transition-colors">
                        <div class="font-medium">Weekly</div>
                        <div class="text-sm text-muted-foreground">Resets every week</div>
                    </button>
                    <button @click="period = 'monthly'" 
                            :class="period === 'monthly' ? 'border-primary bg-primary/5' : ''"
                            class="w-full p-3 rounded-lg border hover:border-primary text-left transition-colors">
                        <div class="font-medium">Monthly</div>
                        <div class="text-sm text-muted-foreground">Resets every month</div>
                    </button>
                    <button @click="period = 'yearly'" 
                            :class="period === 'yearly' ? 'border-primary bg-primary/5' : ''"
                            class="w-full p-3 rounded-lg border hover:border-primary text-left transition-colors">
                        <div class="font-medium">Yearly</div>
                        <div class="text-sm text-muted-foreground">Annual budget</div>
                    </button>
                </div>
                
                <div class="flex gap-2">
                    <button @click="step = 2" class="px-4 py-2 rounded-lg bg-muted hover:bg-muted/80">Back</button>
                    <button @click="step = 1; category = ''; amount = ''" class="flex-1 px-4 py-2 rounded-lg bg-[#10B981] text-white hover:bg-[#059669]">
                        Create Budget
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

## Budget Progress Indicators

Visual indicators help you understand your spending status at a glance:

<div class="my-6 space-y-4">
    <!-- Under Budget (Green) -->
    <div class="p-4 rounded-lg border" x-data="{ spent: 2000, budget: 5000 }">
        <div class="flex justify-between items-start mb-2">
            <div>
                <span class="text-xl mr-2">🍔</span>
                <span class="font-medium">Food & Dining</span>
            </div>
            <span class="px-2 py-1 rounded text-xs font-medium bg-[#10B981]/10 text-[#10B981]">On Track</span>
        </div>
        <div class="flex justify-between text-sm mb-2">
            <span class="text-muted-foreground" x-text="'₱' + spent.toLocaleString() + ' spent'"></span>
            <span class="text-muted-foreground" x-text="'₱' + (budget - spent).toLocaleString() + ' remaining'"></span>
        </div>
        <div class="h-3 bg-muted rounded-full overflow-hidden">
            <div class="h-full bg-[#10B981] rounded-full transition-all duration-500" :style="'width: ' + (spent/budget*100) + '%'"></div>
        </div>
        <div class="mt-2 text-sm text-[#10B981]" x-text="Math.round(spent/budget*100) + '% of budget used'"></div>
    </div>

    <!-- Approaching Limit (Yellow) -->
    <div class="p-4 rounded-lg border border-[#F59E0B]" x-data="{ spent: 4200, budget: 5000 }">
        <div class="flex justify-between items-start mb-2">
            <div>
                <span class="text-xl mr-2">🚗</span>
                <span class="font-medium">Transportation</span>
            </div>
            <span class="px-2 py-1 rounded text-xs font-medium bg-[#F59E0B]/10 text-[#F59E0B]">Almost Full</span>
        </div>
        <div class="flex justify-between text-sm mb-2">
            <span class="text-muted-foreground" x-text="'₱' + spent.toLocaleString() + ' spent'"></span>
            <span class="text-[#F59E0B] font-medium" x-text="'₱' + (budget - spent).toLocaleString() + ' remaining'"></span>
        </div>
        <div class="h-3 bg-muted rounded-full overflow-hidden">
            <div class="h-full bg-[#F59E0B] rounded-full transition-all duration-500" :style="'width: ' + (spent/budget*100) + '%'"></div>
        </div>
        <div class="mt-2 text-sm text-[#F59E0B]" x-text="Math.round(spent/budget*100) + '% of budget used - Slow down!'"></div>
    </div>

    <!-- Over Budget (Red) -->
    <div class="p-4 rounded-lg border border-[#EF4444]" x-data="{ spent: 6500, budget: 5000 }">
        <div class="flex justify-between items-start mb-2">
            <div>
                <span class="text-xl mr-2">🛒</span>
                <span class="font-medium">Shopping</span>
            </div>
            <span class="px-2 py-1 rounded text-xs font-medium bg-[#EF4444]/10 text-[#EF4444]">Over Budget</span>
        </div>
        <div class="flex justify-between text-sm mb-2">
            <span class="text-muted-foreground" x-text="'₱' + spent.toLocaleString() + ' spent'"></span>
            <span class="text-[#EF4444] font-medium" x-text="'₱' + (spent - budget).toLocaleString() + ' over!'"></span>
        </div>
        <div class="h-3 bg-muted rounded-full overflow-hidden">
            <div class="h-full bg-[#EF4444] rounded-full" style="width: 100%"></div>
        </div>
        <div class="mt-2 text-sm text-[#EF4444]" x-text="Math.round(spent/budget*100) + '% - Exceeded by ₱' + (spent - budget).toLocaleString()"></div>
    </div>
</div>

## Budget Status Colors

| Status | Color | Threshold |
|--------|-------|-----------|
| 🟢 On Track | Green | 0% - 70% spent |
| 🟡 Almost Full | Yellow | 70% - 100% spent |
| 🔴 Over Budget | Red | > 100% spent |

## API Endpoints

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/api/budgets` | GET | List all budgets |
| `/api/budgets` | POST | Create a new budget |
| `/api/budgets/{id}` | GET | Get budget details with spending |
| `/api/budgets/{id}` | PUT | Update a budget |
| `/api/budgets/{id}` | DELETE | Delete a budget |
| `/api/dashboard/budget-progress` | GET | Get all budgets with progress |

<x-docs.code language="json" title="POST /api/budgets Request">
{
    "category_id": 3,
    "amount": 5000,
    "period": "monthly",
    "start_date": "2025-01-01",
    "end_date": "2025-01-31"
}
</x-docs.code>

<x-docs.code language="json" title="GET /api/budgets/{id} Response">
{
    "id": 1,
    "category": {
        "id": 3,
        "name": "Food & Dining",
        "icon": "🍔"
    },
    "amount": 5000,
    "spent": 3200,
    "remaining": 1800,
    "percentage": 64,
    "period": "monthly",
    "status": "on_track"
}
</x-docs.code>

<x-docs.callout type="warning" title="Budget Rollover">
    Currently, budgets don't roll over unused amounts. Each period starts fresh with the full budget amount.
</x-docs.callout>

<x-docs.callout type="success" title="Multiple Budgets">
    You can create multiple budgets for the same category with different periods (e.g., a monthly food budget and a yearly vacation budget).
</x-docs.callout>
@endsection
