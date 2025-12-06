@extends('layouts.docs')

@section('title', 'Categories')

@section('sidebar')
    <x-docs.navigation />
@endsection

@section('content')
<h1>Categories</h1>

<p class="text-xl text-muted-foreground">
    Organize your transactions with customizable categories for better financial insights.
</p>

<div class="my-6 rounded-lg border overflow-hidden">
    <div class="bg-gradient-to-r from-[#EC4899] to-[#F472B6] p-4">
        <h3 class="text-white font-semibold">Category Organization</h3>
    </div>
    <div class="p-4 bg-card">
        <div class="flex flex-wrap gap-2">
            <span class="px-3 py-1 rounded-full bg-[#10B981]/10 text-[#10B981] text-sm">💰 Salary</span>
            <span class="px-3 py-1 rounded-full bg-[#EF4444]/10 text-[#EF4444] text-sm">🍔 Food</span>
            <span class="px-3 py-1 rounded-full bg-[#EF4444]/10 text-[#EF4444] text-sm">🚗 Transport</span>
            <span class="px-3 py-1 rounded-full bg-[#EF4444]/10 text-[#EF4444] text-sm">🛒 Shopping</span>
            <span class="px-3 py-1 rounded-full bg-[#10B981]/10 text-[#10B981] text-sm">💻 Freelance</span>
        </div>
    </div>
</div>

## Category Types

FinanEase supports two types of categories:

<div class="my-6 grid md:grid-cols-2 gap-4">
    <!-- Income Categories -->
    <div class="rounded-lg border overflow-hidden">
        <div class="bg-[#10B981] px-4 py-2">
            <span class="text-white font-medium">Income Categories</span>
        </div>
        <div class="p-4 space-y-2">
            <div class="flex items-center gap-3 p-2 rounded hover:bg-muted/50">
                <span class="text-xl">💰</span>
                <span>Salary</span>
            </div>
            <div class="flex items-center gap-3 p-2 rounded hover:bg-muted/50">
                <span class="text-xl">💻</span>
                <span>Freelance</span>
            </div>
            <div class="flex items-center gap-3 p-2 rounded hover:bg-muted/50">
                <span class="text-xl">🎁</span>
                <span>Gifts</span>
            </div>
            <div class="flex items-center gap-3 p-2 rounded hover:bg-muted/50">
                <span class="text-xl">💹</span>
                <span>Investments</span>
            </div>
            <div class="flex items-center gap-3 p-2 rounded hover:bg-muted/50">
                <span class="text-xl">🏠</span>
                <span>Rental Income</span>
            </div>
        </div>
    </div>
    
    <!-- Expense Categories -->
    <div class="rounded-lg border overflow-hidden">
        <div class="bg-[#EF4444] px-4 py-2">
            <span class="text-white font-medium">Expense Categories</span>
        </div>
        <div class="p-4 space-y-2">
            <div class="flex items-center gap-3 p-2 rounded hover:bg-muted/50">
                <span class="text-xl">🍔</span>
                <span>Food & Dining</span>
            </div>
            <div class="flex items-center gap-3 p-2 rounded hover:bg-muted/50">
                <span class="text-xl">🚗</span>
                <span>Transportation</span>
            </div>
            <div class="flex items-center gap-3 p-2 rounded hover:bg-muted/50">
                <span class="text-xl">🛒</span>
                <span>Shopping</span>
            </div>
            <div class="flex items-center gap-3 p-2 rounded hover:bg-muted/50">
                <span class="text-xl">📱</span>
                <span>Bills & Utilities</span>
            </div>
            <div class="flex items-center gap-3 p-2 rounded hover:bg-muted/50">
                <span class="text-xl">🎬</span>
                <span>Entertainment</span>
            </div>
        </div>
    </div>
</div>

## Creating Categories

<div class="my-6" x-data="{ 
    name: '',
    icon: '📦',
    type: 'expense',
    showIconPicker: false,
    icons: ['🍔', '🚗', '🛒', '📱', '🎬', '💊', '✈️', '🎓', '🏠', '💰', '💻', '🎁', '💹', '📦', '🎯', '💪']
}">
    <div class="rounded-lg border overflow-hidden">
        <div class="bg-muted px-4 py-2 border-b">
            <span class="font-medium">New Category</span>
        </div>
        <div class="p-4 space-y-4">
            <!-- Category Type -->
            <div>
                <label class="text-sm font-medium mb-2 block">Category Type</label>
                <div class="flex gap-2">
                    <button @click="type = 'income'" 
                            :class="type === 'income' ? 'bg-[#10B981] text-white' : 'bg-muted'"
                            class="flex-1 py-2 px-4 rounded-lg font-medium transition-colors">
                        Income
                    </button>
                    <button @click="type = 'expense'" 
                            :class="type === 'expense' ? 'bg-[#EF4444] text-white' : 'bg-muted'"
                            class="flex-1 py-2 px-4 rounded-lg font-medium transition-colors">
                        Expense
                    </button>
                </div>
            </div>
            
            <!-- Icon & Name -->
            <div class="flex gap-3">
                <div class="relative">
                    <label class="text-sm font-medium mb-1 block">Icon</label>
                    <button @click="showIconPicker = !showIconPicker" 
                            class="w-14 h-12 rounded-lg border-2 border-dashed flex items-center justify-center text-2xl hover:border-primary transition-colors">
                        <span x-text="icon"></span>
                    </button>
                    <div x-show="showIconPicker" @click.outside="showIconPicker = false"
                         class="absolute top-full left-0 mt-2 p-2 bg-card border rounded-lg shadow-lg z-10 grid grid-cols-4 gap-1 w-48">
                        <template x-for="i in icons" :key="i">
                            <button @click="icon = i; showIconPicker = false" 
                                    class="w-10 h-10 rounded hover:bg-muted flex items-center justify-center text-xl"
                                    x-text="i">
                            </button>
                        </template>
                    </div>
                </div>
                <div class="flex-1">
                    <label class="text-sm font-medium mb-1 block">Category Name</label>
                    <input type="text" x-model="name" placeholder="e.g., Healthcare" 
                           class="w-full px-4 py-2 rounded-lg border bg-background focus:ring-2 focus:ring-primary outline-none">
                </div>
            </div>

            <!-- Submit -->
            <button class="w-full py-3 rounded-lg font-medium text-white transition-colors"
                    :class="type === 'income' ? 'bg-[#10B981] hover:bg-[#059669]' : 'bg-[#EF4444] hover:bg-[#DC2626]'">
                Create Category
            </button>
        </div>
    </div>
</div>

## Category Management

### Category List View

<div class="my-6 rounded-lg border overflow-hidden" x-data="{
    categories: [
        { id: 1, name: 'Food & Dining', icon: '🍔', type: 'expense', transactions: 15, total: 8500 },
        { id: 2, name: 'Transportation', icon: '🚗', type: 'expense', transactions: 8, total: 3200 },
        { id: 3, name: 'Salary', icon: '💰', type: 'income', transactions: 2, total: 50000 },
        { id: 4, name: 'Shopping', icon: '🛒', type: 'expense', transactions: 5, total: 4800 },
        { id: 5, name: 'Freelance', icon: '💻', type: 'income', transactions: 3, total: 15000 }
    ],
    filter: 'all',
    editingId: null
}">
    <!-- Filter -->
    <div class="bg-muted px-4 py-2 border-b flex items-center justify-between">
        <div class="flex gap-2">
            <button @click="filter = 'all'" 
                    :class="filter === 'all' ? 'bg-primary text-white' : 'bg-background'"
                    class="px-3 py-1 rounded-full text-sm font-medium transition-colors">
                All
            </button>
            <button @click="filter = 'income'" 
                    :class="filter === 'income' ? 'bg-[#10B981] text-white' : 'bg-background'"
                    class="px-3 py-1 rounded-full text-sm font-medium transition-colors">
                Income
            </button>
            <button @click="filter = 'expense'" 
                    :class="filter === 'expense' ? 'bg-[#EF4444] text-white' : 'bg-background'"
                    class="px-3 py-1 rounded-full text-sm font-medium transition-colors">
                Expense
            </button>
        </div>
        <span class="text-sm text-muted-foreground" 
              x-text="categories.filter(c => filter === 'all' || c.type === filter).length + ' categories'"></span>
    </div>
    
    <!-- Category Items -->
    <div class="divide-y">
        <template x-for="cat in categories.filter(c => filter === 'all' || c.type === filter)" :key="cat.id">
            <div class="p-4 flex items-center gap-4 hover:bg-muted/50 transition-colors">
                <div class="w-12 h-12 rounded-full flex items-center justify-center text-2xl"
                     :class="cat.type === 'income' ? 'bg-[#10B981]/10' : 'bg-[#EF4444]/10'"
                     x-text="cat.icon">
                </div>
                <div class="flex-1">
                    <div class="font-medium" x-text="cat.name"></div>
                    <div class="text-sm text-muted-foreground" x-text="cat.transactions + ' transactions'"></div>
                </div>
                <div class="text-right">
                    <div class="font-semibold"
                         :class="cat.type === 'income' ? 'text-[#10B981]' : 'text-[#EF4444]'"
                         x-text="(cat.type === 'income' ? '+' : '-') + '₱' + cat.total.toLocaleString()">
                    </div>
                    <div class="text-xs px-2 py-0.5 rounded-full inline-block mt-1"
                         :class="cat.type === 'income' ? 'bg-[#10B981]/10 text-[#10B981]' : 'bg-[#EF4444]/10 text-[#EF4444]'"
                         x-text="cat.type">
                    </div>
                </div>
                <div class="flex gap-1">
                    <button class="p-2 rounded hover:bg-muted">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                    <button class="p-2 rounded hover:bg-muted text-[#EF4444]">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>

## Category Analytics

See how your spending is distributed across categories:

<div class="my-6 p-4 rounded-lg border" x-data="{
    data: [
        { name: 'Food & Dining', percentage: 35, amount: 8500, color: '#EF4444' },
        { name: 'Transportation', percentage: 20, amount: 4800, color: '#F59E0B' },
        { name: 'Shopping', percentage: 25, amount: 6000, color: '#6366F1' },
        { name: 'Bills', percentage: 15, amount: 3600, color: '#10B981' },
        { name: 'Entertainment', percentage: 5, amount: 1200, color: '#EC4899' }
    ]
}">
    <h3 class="font-medium mb-4">Expense Breakdown This Month</h3>
    
    <!-- Bar Chart -->
    <div class="space-y-3">
        <template x-for="item in data" :key="item.name">
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span x-text="item.name"></span>
                    <span class="text-muted-foreground" x-text="'₱' + item.amount.toLocaleString() + ' (' + item.percentage + '%)'"></span>
                </div>
                <div class="h-4 bg-muted rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-500"
                         :style="'width: ' + item.percentage + '%; background-color: ' + item.color"></div>
                </div>
            </div>
        </template>
    </div>
    
    <!-- Total -->
    <div class="mt-4 pt-4 border-t flex justify-between font-medium">
        <span>Total Expenses</span>
        <span class="text-[#EF4444]" x-text="'-₱' + data.reduce((sum, d) => sum + d.amount, 0).toLocaleString()"></span>
    </div>
</div>

## Default Categories

FinanEase comes with pre-configured categories to get you started:

### Income Categories (Default)
| Icon | Name | Description |
|------|------|-------------|
| 💰 | Salary | Regular employment income |
| 💻 | Freelance | Contract/gig work income |
| 🎁 | Gifts | Money received as gifts |
| 💹 | Investments | Returns from investments |
| 🏠 | Rental | Rental property income |

### Expense Categories (Default)
| Icon | Name | Description |
|------|------|-------------|
| 🍔 | Food & Dining | Groceries, restaurants, delivery |
| 🚗 | Transportation | Fuel, fares, vehicle expenses |
| 🛒 | Shopping | Retail purchases, online shopping |
| 📱 | Bills & Utilities | Phone, internet, electricity |
| 🎬 | Entertainment | Movies, games, subscriptions |
| 💊 | Healthcare | Medical expenses, pharmacy |
| ✈️ | Travel | Vacations, trips |
| 🎓 | Education | Courses, books, supplies |

## API Endpoints

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/api/categories` | GET | List all categories |
| `/api/categories` | POST | Create a new category |
| `/api/categories/{id}` | GET | Get category details |
| `/api/categories/{id}` | PUT | Update a category |
| `/api/categories/{id}` | DELETE | Delete a category |

<x-docs.code language="json" title="POST /api/categories Request">
{
    "name": "Healthcare",
    "icon": "💊",
    "type": "expense"
}
</x-docs.code>

<x-docs.code language="json" title="GET /api/categories Response">
{
    "data": [
        {
            "id": 1,
            "name": "Food & Dining",
            "icon": "🍔",
            "type": "expense",
            "transactions_count": 15,
            "total_amount": 8500
        },
        {
            "id": 2,
            "name": "Salary",
            "icon": "💰",
            "type": "income",
            "transactions_count": 2,
            "total_amount": 50000
        }
    ]
}
</x-docs.code>

<x-docs.callout type="warning" title="Deleting Categories">
    You cannot delete a category that has transactions. Either reassign the transactions to another category first, or archive the category.
</x-docs.callout>

<x-docs.callout type="success" title="Category Budget Link">
    Each expense category can have an associated budget. When you create a budget, you select which category it tracks.
</x-docs.callout>
@endsection
