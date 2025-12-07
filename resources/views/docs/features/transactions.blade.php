@extends('layouts.docs')

@section('title', 'Transactions')

@section('sidebar')
    <x-docs.navigation />
@endsection

@section('content')
<div class="mb-8">
    <div class="mb-2 inline-block px-3 py-1 rounded-full bg-[#10B981]/10 text-[#10B981] text-xs font-semibold">Feature</div>
    <h1 class="text-4xl font-bold tracking-tight mb-3">Transactions</h1>
    <p class="text-lg text-muted-foreground">Track every peso that flows through your accounts with detailed transaction management.</p>
</div>

<div class="my-6 rounded-lg border overflow-hidden">
    <div class="bg-gradient-to-r from-[#10B981] to-[#059669] p-4">
        <h3 class="text-white font-semibold">Transactions Overview</h3>
    </div>
    <div class="p-4 bg-card">
        <div class="flex gap-2 mb-4">
            <span class="px-3 py-1 rounded-full bg-[#10B981]/10 text-[#10B981] text-sm font-medium">Income</span>
            <span class="px-3 py-1 rounded-full bg-[#EF4444]/10 text-[#EF4444] text-sm font-medium">Expense</span>
            <span class="px-3 py-1 rounded-full bg-[#6366F1]/10 text-[#6366F1] text-sm font-medium">Transfer</span>
        </div>
    </div>
</div>

## Transaction Types

FinanEase supports three types of transactions:

### Income
Money coming into your accounts. Examples:
- 💰 Salary deposits
- 🎁 Gifts received
- 💹 Investment returns
- 🏠 Rental income

### Expense
Money going out of your accounts. Examples:
- 🍔 Food & dining
- 🚗 Transportation
- 🛒 Shopping
- 📱 Bills & utilities

### Transfer
Move money between your own accounts:
- 💳 Bank to Cash
- 🏦 Checking to Savings
- 💵 Emergency Fund allocation

<x-docs.callout type="info" title="About Transfers">
    Transfers create two linked transactions: a "Transfer Out" from the source account and a "Transfer In" to the destination account. They don't affect your overall net worth.
</x-docs.callout>

## Adding Transactions

<div class="my-6" x-data="{ 
    type: 'expense', 
    amount: '', 
    description: '', 
    account: '',
    category: '',
    showForm: true 
}">
    <div class="rounded-lg border overflow-hidden">
        <div class="bg-muted px-4 py-2 border-b flex justify-between items-center">
            <span class="font-medium">New Transaction</span>
            <button @click="showForm = !showForm" class="text-sm text-primary">
                <span x-text="showForm ? 'Collapse' : 'Expand'"></span>
            </button>
        </div>
        <div class="p-4 space-y-4" x-show="showForm" x-transition>
            <!-- Transaction Type Selector -->
            <div>
                <label class="text-sm font-medium mb-2 block">Type</label>
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
                    <button @click="type = 'transfer'" 
                            :class="type === 'transfer' ? 'bg-[#6366F1] text-white' : 'bg-muted'"
                            class="flex-1 py-2 px-4 rounded-lg font-medium transition-colors">
                        Transfer
                    </button>
                </div>
            </div>
            
            <!-- Amount -->
            <div>
                <label class="text-sm font-medium mb-2 block">Amount</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground">₱</span>
                    <input type="number" x-model="amount" placeholder="0.00" 
                           class="w-full pl-8 pr-4 py-2 rounded-lg border bg-background focus:ring-2 focus:ring-primary outline-none">
                </div>
            </div>
            
            <!-- Description -->
            <div>
                <label class="text-sm font-medium mb-2 block">Description</label>
                <input type="text" x-model="description" placeholder="Enter description..." 
                       class="w-full px-4 py-2 rounded-lg border bg-background focus:ring-2 focus:ring-primary outline-none">
            </div>
            
            <!-- Account Selection -->
            <div>
                <label class="text-sm font-medium mb-2 block" x-text="type === 'transfer' ? 'From Account' : 'Account'"></label>
                <select x-model="account" class="w-full px-4 py-2 rounded-lg border bg-background focus:ring-2 focus:ring-primary outline-none">
                    <option value="">Select account...</option>
                    <option value="cash">💵 Cash</option>
                    <option value="bank">🏦 Bank Account</option>
                    <option value="gcash">📱 GCash</option>
                </select>
            </div>
            
            <!-- To Account (Transfer only) -->
            <div x-show="type === 'transfer'" x-transition>
                <label class="text-sm font-medium mb-2 block">To Account</label>
                <select class="w-full px-4 py-2 rounded-lg border bg-background focus:ring-2 focus:ring-primary outline-none">
                    <option value="">Select account...</option>
                    <option value="cash">💵 Cash</option>
                    <option value="bank">🏦 Bank Account</option>
                    <option value="gcash">📱 GCash</option>
                </select>
            </div>
            
            <!-- Category (not for transfers) -->
            <div x-show="type !== 'transfer'" x-transition>
                <label class="text-sm font-medium mb-2 block">Category</label>
                <select x-model="category" class="w-full px-4 py-2 rounded-lg border bg-background focus:ring-2 focus:ring-primary outline-none">
                    <option value="">Select category...</option>
                    <template x-if="type === 'expense'">
                        <optgroup label="Expense Categories">
                            <option value="food">🍔 Food & Dining</option>
                            <option value="transport">🚗 Transportation</option>
                            <option value="shopping">🛒 Shopping</option>
                            <option value="bills">📱 Bills & Utilities</option>
                        </optgroup>
                    </template>
                    <template x-if="type === 'income'">
                        <optgroup label="Income Categories">
                            <option value="salary">💰 Salary</option>
                            <option value="freelance">💻 Freelance</option>
                            <option value="gift">🎁 Gift</option>
                            <option value="investment">💹 Investment</option>
                        </optgroup>
                    </template>
                </select>
            </div>
            
            <!-- Submit Button -->
            <button class="w-full py-3 rounded-lg font-medium text-white transition-colors"
                    :class="{
                        'bg-[#10B981] hover:bg-[#059669]': type === 'income',
                        'bg-[#EF4444] hover:bg-[#DC2626]': type === 'expense',
                        'bg-[#6366F1] hover:bg-[#4F46E5]': type === 'transfer'
                    }">
                <span x-text="'Add ' + type.charAt(0).toUpperCase() + type.slice(1)"></span>
            </button>
        </div>
    </div>
</div>

## Transaction List

<div class="my-6 rounded-lg border overflow-hidden" x-data="{
    transactions: [
        { id: 1, type: 'expense', description: 'Grocery Shopping', amount: 1500, category: '🛒 Shopping', date: 'Today', account: 'GCash' },
        { id: 2, type: 'income', description: 'Freelance Payment', amount: 5000, category: '💻 Freelance', date: 'Today', account: 'Bank' },
        { id: 3, type: 'transfer', description: 'To Emergency Fund', amount: 2000, category: 'Transfer', date: 'Yesterday', account: 'Bank → Cash' },
        { id: 4, type: 'expense', description: 'Grab Ride', amount: 250, category: '🚗 Transportation', date: 'Yesterday', account: 'GCash' },
        { id: 5, type: 'expense', description: 'Coffee', amount: 180, category: '🍔 Food & Dining', date: '2 days ago', account: 'Cash' }
    ],
    filter: 'all'
}">
    <!-- Filter Tabs -->
    <div class="bg-muted px-4 py-2 border-b flex gap-2">
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
        <button @click="filter = 'transfer'" 
                :class="filter === 'transfer' ? 'bg-[#6366F1] text-white' : 'bg-background'"
                class="px-3 py-1 rounded-full text-sm font-medium transition-colors">
            Transfer
        </button>
    </div>
    
    <!-- Transaction Items -->
    <div class="divide-y">
        <template x-for="txn in transactions.filter(t => filter === 'all' || t.type === filter)" :key="txn.id">
            <div class="p-4 flex items-center gap-4 hover:bg-muted/50 transition-colors cursor-pointer">
                <div class="w-10 h-10 rounded-full flex items-center justify-center"
                     :class="{
                         'bg-[#10B981]/10': txn.type === 'income',
                         'bg-[#EF4444]/10': txn.type === 'expense',
                         'bg-[#6366F1]/10': txn.type === 'transfer'
                     }">
                    <svg x-show="txn.type === 'income'" class="w-5 h-5 text-[#10B981]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                    <svg x-show="txn.type === 'expense'" class="w-5 h-5 text-[#EF4444]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                    </svg>
                    <svg x-show="txn.type === 'transfer'" class="w-5 h-5 text-[#6366F1]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="font-medium" x-text="txn.description"></div>
                    <div class="text-sm text-muted-foreground">
                        <span x-text="txn.category"></span> • <span x-text="txn.account"></span>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-semibold"
                         :class="{
                             'text-[#10B981]': txn.type === 'income',
                             'text-[#EF4444]': txn.type === 'expense',
                             'text-[#6366F1]': txn.type === 'transfer'
                         }"
                         x-text="(txn.type === 'income' ? '+' : txn.type === 'expense' ? '-' : '') + '₱' + txn.amount.toLocaleString()">
                    </div>
                    <div class="text-xs text-muted-foreground" x-text="txn.date"></div>
                </div>
            </div>
        </template>
    </div>
</div>

## API Endpoints

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/api/transactions` | GET | List all transactions |
| `/api/transactions` | POST | Create a new transaction |
| `/api/transactions/{id}` | GET | Get transaction details |
| `/api/transactions/{id}` | PUT | Update a transaction |
| `/api/transactions/{id}` | DELETE | Delete a transaction |
| `/api/transactions/check-budget` | POST | Check if expense exceeds budget |
| `/api/accounts/transfer` | POST | Create account-to-account transfer |

<x-docs.code language="json" title="POST /api/transactions Request">
{
    "type": "expense",
    "amount": 500,
    "description": "Lunch with colleagues",
    "account_id": 1,
    "category_id": 3,
    "transaction_date": "2025-01-15"
}
</x-docs.code>

<x-docs.code language="json" title="POST /api/accounts/transfer Request">
{
    "from_account_id": 1,
    "to_account_id": 2,
    "amount": 5000,
    "description": "Transfer to savings"
}
</x-docs.code>

## Budget Warnings

When adding an expense, FinanEase automatically checks if it will exceed your budget:

<div class="my-4 p-4 rounded-lg border border-[#F59E0B] bg-[#F59E0B]/10">
    <div class="flex items-start gap-3">
        <svg class="w-5 h-5 text-[#F59E0B] mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <div>
            <div class="font-medium text-[#F59E0B]">Budget Warning</div>
            <div class="text-sm mt-1">This expense will exceed your "Food & Dining" budget by ₱500. Are you sure you want to continue?</div>
            <div class="flex gap-2 mt-3">
                <button class="px-4 py-1.5 rounded bg-[#F59E0B] text-white text-sm font-medium hover:bg-[#D97706]">Add Anyway</button>
                <button class="px-4 py-1.5 rounded bg-muted text-sm font-medium hover:bg-muted/80">Cancel</button>
            </div>
        </div>
    </div>
</div>

<x-docs.callout type="success" title="Smart Categorization">
    FinanEase remembers your previous transactions and suggests categories based on the description you enter.
</x-docs.callout>
@endsection
