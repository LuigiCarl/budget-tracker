@extends('layouts.docs')

@section('title', 'Accounts')

@section('sidebar')
    <x-docs.navigation />
@endsection

@section('content')
<h1>Accounts</h1>

<p class="text-xl text-muted-foreground">
    Manage all your financial accounts in one place - from cash to bank accounts to e-wallets.
</p>

<div class="my-6 rounded-lg border overflow-hidden">
    <div class="bg-gradient-to-r from-[#6366F1] to-[#8B5CF6] p-4">
        <h3 class="text-white font-semibold">Account Overview</h3>
    </div>
    <div class="p-4 bg-card">
        <div class="grid grid-cols-3 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold">3</div>
                <div class="text-sm text-muted-foreground">Active Accounts</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-[#10B981]">₱45,000</div>
                <div class="text-sm text-muted-foreground">Total Balance</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold">47</div>
                <div class="text-sm text-muted-foreground">Transactions</div>
            </div>
        </div>
    </div>
</div>

## Account Types

FinanEase supports various account types with customizable icons:

<div class="my-6 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
    <div class="p-4 rounded-lg border hover:border-primary transition-colors">
        <div class="text-3xl mb-2">💵</div>
        <div class="font-medium">Cash</div>
        <div class="text-sm text-muted-foreground">Physical cash on hand</div>
    </div>
    <div class="p-4 rounded-lg border hover:border-primary transition-colors">
        <div class="text-3xl mb-2">🏦</div>
        <div class="font-medium">Bank Account</div>
        <div class="text-sm text-muted-foreground">Checking, savings accounts</div>
    </div>
    <div class="p-4 rounded-lg border hover:border-primary transition-colors">
        <div class="text-3xl mb-2">💳</div>
        <div class="font-medium">Credit Card</div>
        <div class="text-sm text-muted-foreground">Credit line tracking</div>
    </div>
    <div class="p-4 rounded-lg border hover:border-primary transition-colors">
        <div class="text-3xl mb-2">📱</div>
        <div class="font-medium">E-Wallet</div>
        <div class="text-sm text-muted-foreground">GCash, Maya, PayPal</div>
    </div>
    <div class="p-4 rounded-lg border hover:border-primary transition-colors">
        <div class="text-3xl mb-2">🏠</div>
        <div class="font-medium">Emergency Fund</div>
        <div class="text-sm text-muted-foreground">Rainy day savings</div>
    </div>
    <div class="p-4 rounded-lg border hover:border-primary transition-colors">
        <div class="text-3xl mb-2">💹</div>
        <div class="font-medium">Investment</div>
        <div class="text-sm text-muted-foreground">Stocks, bonds, crypto</div>
    </div>
</div>

## Account Management

### Creating an Account

<div class="my-6" x-data="{ 
    name: '',
    icon: '💵',
    balance: '',
    showIconPicker: false,
    icons: ['💵', '🏦', '💳', '📱', '🏠', '💹', '🎯', '✈️', '🚗', '🎓']
}">
    <div class="rounded-lg border overflow-hidden">
        <div class="bg-muted px-4 py-2 border-b">
            <span class="font-medium">New Account</span>
        </div>
        <div class="p-4 space-y-4">
            <!-- Icon & Name -->
            <div class="flex gap-3">
                <div class="relative">
                    <button @click="showIconPicker = !showIconPicker" 
                            class="w-14 h-14 rounded-lg border-2 border-dashed flex items-center justify-center text-2xl hover:border-primary transition-colors">
                        <span x-text="icon"></span>
                    </button>
                    <div x-show="showIconPicker" @click.outside="showIconPicker = false"
                         class="absolute top-full left-0 mt-2 p-2 bg-card border rounded-lg shadow-lg z-10 grid grid-cols-5 gap-1">
                        <template x-for="i in icons" :key="i">
                            <button @click="icon = i; showIconPicker = false" 
                                    class="w-10 h-10 rounded hover:bg-muted flex items-center justify-center text-xl"
                                    x-text="i">
                            </button>
                        </template>
                    </div>
                </div>
                <div class="flex-1">
                    <label class="text-sm font-medium mb-1 block">Account Name</label>
                    <input type="text" x-model="name" placeholder="e.g., BDO Savings" 
                           class="w-full px-4 py-2 rounded-lg border bg-background focus:ring-2 focus:ring-primary outline-none">
                </div>
            </div>

            <!-- Initial Balance -->
            <div>
                <label class="text-sm font-medium mb-1 block">Initial Balance</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground">₱</span>
                    <input type="number" x-model="balance" placeholder="0.00" 
                           class="w-full pl-8 pr-4 py-2 rounded-lg border bg-background focus:ring-2 focus:ring-primary outline-none">
                </div>
                <p class="text-xs text-muted-foreground mt-1">Enter your current balance for this account</p>
            </div>

            <!-- Submit -->
            <button class="w-full py-3 rounded-lg bg-primary text-white font-medium hover:bg-primary/90 transition-colors">
                Create Account
            </button>
        </div>
    </div>
</div>

### Account Cards

<div class="my-6 space-y-3" x-data="{
    accounts: [
        { id: 1, name: 'Cash on Hand', icon: '💵', balance: 5000, transactions: 12 },
        { id: 2, name: 'BDO Savings', icon: '🏦', balance: 35000, transactions: 28 },
        { id: 3, name: 'GCash', icon: '📱', balance: 5000, transactions: 7 }
    ],
    selectedAccount: null
}">
    <template x-for="account in accounts" :key="account.id">
        <div @click="selectedAccount = account.id" 
             :class="selectedAccount === account.id ? 'border-primary ring-2 ring-primary/20' : ''"
             class="p-4 rounded-lg border hover:border-primary/50 cursor-pointer transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-2xl"
                     x-text="account.icon"></div>
                <div class="flex-1">
                    <div class="font-medium" x-text="account.name"></div>
                    <div class="text-sm text-muted-foreground" x-text="account.transactions + ' transactions'"></div>
                </div>
                <div class="text-right">
                    <div class="text-xl font-bold" x-text="'₱' + account.balance.toLocaleString()"></div>
                </div>
            </div>
        </div>
    </template>
    
    <!-- Total -->
    <div class="p-4 rounded-lg bg-muted/50 border-2 border-dashed">
        <div class="flex justify-between items-center">
            <span class="font-medium">Total Balance</span>
            <span class="text-2xl font-bold text-[#10B981]" 
                  x-text="'₱' + accounts.reduce((sum, a) => sum + a.balance, 0).toLocaleString()"></span>
        </div>
    </div>
</div>

## Account Transfers

Move money between your accounts easily:

<div class="my-6" x-data="{ 
    fromAccount: 'bank',
    toAccount: 'cash',
    amount: 5000,
    description: 'ATM Withdrawal'
}">
    <div class="rounded-lg border overflow-hidden">
        <div class="bg-gradient-to-r from-[#6366F1] to-[#8B5CF6] px-4 py-3">
            <span class="text-white font-medium">Transfer Between Accounts</span>
        </div>
        <div class="p-4 space-y-4">
            <div class="flex items-center gap-4">
                <!-- From Account -->
                <div class="flex-1">
                    <label class="text-sm font-medium mb-1 block">From</label>
                    <select x-model="fromAccount" class="w-full px-4 py-2 rounded-lg border bg-background">
                        <option value="bank">🏦 BDO Savings</option>
                        <option value="cash">💵 Cash</option>
                        <option value="gcash">📱 GCash</option>
                    </select>
                </div>
                
                <!-- Arrow -->
                <div class="pt-6">
                    <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </div>
                
                <!-- To Account -->
                <div class="flex-1">
                    <label class="text-sm font-medium mb-1 block">To</label>
                    <select x-model="toAccount" class="w-full px-4 py-2 rounded-lg border bg-background">
                        <option value="cash">💵 Cash</option>
                        <option value="bank">🏦 BDO Savings</option>
                        <option value="gcash">📱 GCash</option>
                    </select>
                </div>
            </div>
            
            <!-- Amount -->
            <div>
                <label class="text-sm font-medium mb-1 block">Amount</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground">₱</span>
                    <input type="number" x-model="amount" 
                           class="w-full pl-8 pr-4 py-2 rounded-lg border bg-background focus:ring-2 focus:ring-primary outline-none">
                </div>
            </div>
            
            <!-- Description -->
            <div>
                <label class="text-sm font-medium mb-1 block">Note (optional)</label>
                <input type="text" x-model="description" 
                       class="w-full px-4 py-2 rounded-lg border bg-background focus:ring-2 focus:ring-primary outline-none">
            </div>
            
            <!-- Transfer Button -->
            <button class="w-full py-3 rounded-lg bg-[#6366F1] text-white font-medium hover:bg-[#4F46E5] transition-colors">
                Transfer ₱<span x-text="amount.toLocaleString()"></span>
            </button>
        </div>
    </div>
</div>

<x-docs.callout type="info" title="How Transfers Work">
    When you create a transfer, FinanEase automatically creates two linked transactions:
    <ul class="mt-2 space-y-1">
        <li>• <strong>Transfer Out</strong> from the source account (decreases balance)</li>
        <li>• <strong>Transfer In</strong> to the destination account (increases balance)</li>
    </ul>
    These transactions are linked and excluded from income/expense calculations.
</x-docs.callout>

## Account Detail View

Click on any account to see:

- **Transaction History** - All transactions for that account
- **Balance Chart** - Visual balance over time
- **Monthly Summary** - Income vs expenses per month
- **Edit Account** - Update name, icon, or initial balance

<div class="my-4 p-4 rounded-lg border">
    <div class="flex items-center gap-3 mb-4 pb-4 border-b">
        <div class="w-14 h-14 rounded-full bg-[#6366F1]/10 flex items-center justify-center text-3xl">🏦</div>
        <div>
            <div class="text-xl font-bold">BDO Savings</div>
            <div class="text-muted-foreground">28 transactions</div>
        </div>
        <button class="ml-auto p-2 rounded-lg hover:bg-muted">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </button>
    </div>
    
    <div class="grid grid-cols-3 gap-4 text-center">
        <div>
            <div class="text-2xl font-bold">₱35,000</div>
            <div class="text-sm text-muted-foreground">Current Balance</div>
        </div>
        <div>
            <div class="text-2xl font-bold text-[#10B981]">+₱50,000</div>
            <div class="text-sm text-muted-foreground">Total Income</div>
        </div>
        <div>
            <div class="text-2xl font-bold text-[#EF4444]">-₱15,000</div>
            <div class="text-sm text-muted-foreground">Total Expenses</div>
        </div>
    </div>
</div>

## API Endpoints

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/api/accounts` | GET | List all accounts |
| `/api/accounts` | POST | Create a new account |
| `/api/accounts/{id}` | GET | Get account details |
| `/api/accounts/{id}` | PUT | Update an account |
| `/api/accounts/{id}` | DELETE | Delete an account |
| `/api/accounts/transfer` | POST | Transfer between accounts |

<x-docs.code language="json" title="POST /api/accounts Request">
{
    "name": "BDO Savings",
    "icon": "🏦",
    "initial_balance": 35000
}
</x-docs.code>

<x-docs.code language="json" title="POST /api/accounts/transfer Request">
{
    "from_account_id": 1,
    "to_account_id": 2,
    "amount": 5000,
    "description": "ATM Withdrawal"
}
</x-docs.code>

<x-docs.callout type="warning" title="Deleting Accounts">
    When you delete an account, all associated transactions will also be deleted. Consider archiving the account instead if you want to keep the transaction history.
</x-docs.callout>
@endsection
