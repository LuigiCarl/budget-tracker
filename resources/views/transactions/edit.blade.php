@extends('layouts.base')

@section('title', 'Edit Transaction - ' . config('app.name'))
@section('app-name', 'Budget Tracker')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold">Edit Transaction</h1>
                <p class="text-muted-foreground">Update transaction details</p>
            </div>
            <a href="{{ route('transactions.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Transactions
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
            <div class="p-6">
                <form action="{{ route('transactions.update', $transaction) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Transaction Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                Transaction Type <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative">
                                    <input type="radio" name="type" value="income" class="sr-only peer" {{ (old('type', $transaction->type) === 'income') ? 'checked' : '' }}>
                                    <div class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                        <div class="flex items-center space-x-3">
                                            <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-full">
                                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                            </div>
                                            <span class="font-medium">Income</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative">
                                    <input type="radio" name="type" value="expense" class="sr-only peer" {{ (old('type', $transaction->type) === 'expense') ? 'checked' : '' }}>
                                    <div class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/20 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                        <div class="flex items-center space-x-3">
                                            <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-full">
                                                <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                            </div>
                                            <span class="font-medium">Expense</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Amount <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" 
                                       name="amount" 
                                       id="amount" 
                                       value="{{ old('amount', number_format($transaction->amount, 2, '.', '')) }}"
                                       step="0.01"
                                       min="0.01"
                                       class="block w-full pl-7 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                       placeholder="0.00"
                                       required>
                            </div>
                        </div>

                        <!-- Account -->
                        <div>
                            <label for="account_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Account <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-2">
                                <select name="account_id" 
                                        id="account_id" 
                                        class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                        required>
                                    <option value="">Select account</option>
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}" {{ (old('account_id', $transaction->account_id) == $account->id) ? 'selected' : '' }}>
                                            {{ $account->name }} ({{ ucwords(str_replace('_', ' ', $account->type)) }}) - ${{ number_format($account->balance, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                                <a href="{{ route('accounts.create') }}" 
                                   target="_blank"
                                   class="px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-md border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 transition-colors flex items-center"
                                   title="Create new account (opens in new tab)">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-2">
                                <select name="category_id" 
                                        id="category_id" 
                                        class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                        required>
                                    <option value="">Select category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                data-type="{{ $category->type }}"
                                                {{ (old('category_id', $transaction->category_id) == $category->id) ? 'selected' : '' }}>
                                            {{ $category->name }} ({{ ucwords($category->type) }})
                                        </option>
                                    @endforeach
                                </select>
                                <a href="{{ route('categories.create') }}" 
                                   target="_blank"
                                   class="px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-md border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 transition-colors flex items-center"
                                   title="Create new category (opens in new tab)">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Date -->
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   name="date" 
                                   id="date" 
                                   value="{{ old('date', $transaction->date) }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                   required>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Description
                            </label>
                            <input type="text" 
                                   name="description" 
                                   id="description" 
                                   value="{{ old('description', $transaction->description) }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                   placeholder="Brief description">
                        </div>

                        <!-- Note -->
                        <div>
                            <label for="note" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Note
                            </label>
                            <textarea name="note" 
                                      id="note" 
                                      rows="3"
                                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                      placeholder="Additional notes (optional)">{{ old('note', $transaction->note) }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-600">
                        <a href="{{ route('transactions.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Transaction
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Filter categories based on transaction type
        document.addEventListener('DOMContentLoaded', function() {
            const typeRadios = document.querySelectorAll('input[name="type"]');
            const categorySelect = document.getElementById('category_id');
            const categoryOptions = Array.from(categorySelect.options);

            function filterCategories() {
                const selectedType = document.querySelector('input[name="type"]:checked')?.value;
                
                // Store current selection
                const currentSelection = categorySelect.value;
                
                // Clear current options
                categorySelect.innerHTML = '<option value="">Select category</option>';
                
                if (selectedType) {
                    // Add matching categories
                    categoryOptions.forEach(option => {
                        if (option.value && option.getAttribute('data-type') === selectedType) {
                            categorySelect.appendChild(option.cloneNode(true));
                        }
                    });
                } else {
                    // Add all categories
                    categoryOptions.forEach(option => {
                        if (option.value) {
                            categorySelect.appendChild(option.cloneNode(true));
                        }
                    });
                }
                
                // Restore selection if still valid
                if (currentSelection && categorySelect.querySelector(`option[value="${currentSelection}"]`)) {
                    categorySelect.value = currentSelection;
                }
            }

            typeRadios.forEach(radio => {
                radio.addEventListener('change', filterCategories);
            });

            // Initial filter
            filterCategories();
        });
    </script>
@endsection