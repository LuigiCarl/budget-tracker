@extends('layouts.base')

@section('title', $account->name . ' - Accounts - ' . config('app.name'))
@section('app-name', 'Budget Tracker')

@section('content')
    <div class="space-y-4 sm:space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="scroll-m-20 text-2xl sm:text-4xl font-extrabold tracking-tight">
                    {{ $account->name }}
                </h1>
                <p class="text-base sm:text-xl text-muted-foreground">
                    {{ ucwords(str_replace('_', ' ', $account->type)) }} Account
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <a href="{{ route('accounts.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-border rounded-lg hover:bg-accent transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Accounts
                </a>
                <a href="{{ route('accounts.edit', $account) }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Account
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Account Details Card -->
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
            <div class="p-4 sm:p-6">
                <h2 class="text-xl font-semibold mb-4">Account Details</h2>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-muted-foreground mb-1">Account Name</label>
                        <p class="text-base font-medium">{{ $account->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-muted-foreground mb-1">Account Type</label>
                        <p class="text-base font-medium">{{ ucwords(str_replace('_', ' ', $account->type)) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-muted-foreground mb-1">Starting Balance</label>
                        <p class="text-base font-medium">${{ number_format($account->balance, 2) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-muted-foreground mb-1">Current Balance</label>
                        <p class="text-base font-medium {{ $account->balance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            ${{ number_format($account->balance, 2) }}
                        </p>
                    </div>
                    @if($account->description)
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-muted-foreground mb-1">Description</label>
                            <p class="text-base">{{ $account->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
            <div class="p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <h2 class="text-xl font-semibold">Recent Transactions</h2>
                    <a href="{{ route('transactions.create') }}?account_id={{ $account->id }}" class="inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Transaction
                    </a>
                </div>

                @if($transactions->count() > 0)
                    <div class="space-y-3">
                        @foreach($transactions as $transaction)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 border border-border rounded-lg hover:bg-accent/50 transition-colors">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2 sm:mb-0">
                                        <div class="w-3 h-3 rounded-full" style="background-color: {{ $transaction->category->color ?? '#6b7280' }}"></div>
                                        <div>
                                            <p class="font-medium">{{ $transaction->description }}</p>
                                            <p class="text-sm text-muted-foreground">
                                                {{ $transaction->category->name ?? 'Uncategorized' }} • {{ $transaction->date->format('M j, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between sm:justify-end gap-4">
                                    <span class="font-semibold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                    </span>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('transactions.edit', $transaction) }}" class="text-blue-600 hover:text-blue-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this transaction?')">
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
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($transactions->hasPages())
                        <div class="mt-6">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <svg class="w-12 h-12 mx-auto text-muted-foreground mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium mb-2">No transactions yet</h3>
                        <p class="text-muted-foreground mb-4">This account doesn't have any transactions yet.</p>
                        <a href="{{ route('transactions.create') }}?account_id={{ $account->id }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add First Transaction
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="rounded-lg border border-red-200 bg-red-50 text-red-900 shadow-sm">
            <div class="p-4 sm:p-6">
                <h2 class="text-lg font-semibold mb-2 text-red-900">Danger Zone</h2>
                <p class="text-sm text-red-700 mb-4">Once you delete this account, there is no going back. Please be certain.</p>
                <form action="{{ route('accounts.destroy', $account) }}" method="POST" class="inline" onsubmit="return confirm('Are you absolutely sure you want to delete this account? This will also delete all associated transactions and cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete Account
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection