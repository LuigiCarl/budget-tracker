@extends('layouts.base')

@section('title', 'Create Transaction - ' . config('app.name'))
@section('app-name', 'Budget Tracker')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold">Create Transaction</h1>
                <p class="text-muted-foreground">Record a new income or expense</p>
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
                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- Transaction Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                Transaction Type <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative">
                                    <input type="radio" name="type" value="income" class="sr-only peer" {{ old('type') === 'income' ? 'checked' : '' }}>
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
                                    <input type="radio" name="type" value="expense" class="sr-only peer" {{ old('type') === 'expense' ? 'checked' : '' }}>
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
                                       value="{{ old('amount') }}"
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
                                        <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                            {{ $account->name }} ({{ ucwords(str_replace('_', ' ', $account->type)) }}) - ${{ number_format($account->balance, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button"
                                        onclick="openAccountModal()"
                                        class="px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-md border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 transition-colors flex items-center"
                                        title="Create new account">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
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
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }} ({{ ucwords($category->type) }})
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button"
                                        onclick="openCategoryModal()"
                                        class="px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-md border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 transition-colors flex items-center"
                                        title="Create new category">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
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
                                   value="{{ old('date', date('Y-m-d')) }}"
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
                                   value="{{ old('description') }}"
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
                                      placeholder="Additional notes (optional)">{{ old('note') }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-600">
                        <a href="{{ route('transactions.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Create Transaction
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Filter categories based on transaction type and set defaults
        document.addEventListener('DOMContentLoaded', function() {
            const typeRadios = document.querySelectorAll('input[name="type"]');
            const categorySelect = document.getElementById('category_id');
            const categoryOptions = Array.from(categorySelect.options);
            
            // Default category IDs
            const defaultIncomeCategory = @json($defaultIncomeCategory ? $defaultIncomeCategory->id : null);
            const defaultExpenseCategory = @json($defaultExpenseCategory ? $defaultExpenseCategory->id : null);

            function filterCategories() {
                const selectedType = document.querySelector('input[name="type"]:checked')?.value;
                
                // Clear current options
                categorySelect.innerHTML = '<option value="">Select category</option>';
                
                if (selectedType) {
                    // Add matching categories
                    categoryOptions.forEach(option => {
                        if (option.value && option.getAttribute('data-type') === selectedType) {
                            categorySelect.appendChild(option.cloneNode(true));
                        }
                    });
                    
                    // Set default category based on type
                    if (selectedType === 'income' && defaultIncomeCategory) {
                        categorySelect.value = defaultIncomeCategory;
                    } else if (selectedType === 'expense' && defaultExpenseCategory) {
                        categorySelect.value = defaultExpenseCategory;
                    }
                } else {
                    // Add all categories
                    categoryOptions.forEach(option => {
                        if (option.value) {
                            categorySelect.appendChild(option.cloneNode(true));
                        }
                    });
                }
            }

            typeRadios.forEach(radio => {
                radio.addEventListener('change', filterCategories);
            });

            // Initial filter
            filterCategories();
        });

        // Modal functions
        function openCategoryModal() {
            document.getElementById('categoryModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Set the category type based on selected transaction type
            const selectedType = document.querySelector('input[name="type"]:checked')?.value;
            if (selectedType) {
                const typeRadios = document.querySelectorAll('#categoryModal input[name="modal_type"]');
                typeRadios.forEach(radio => {
                    if (radio.value === selectedType) {
                        radio.checked = true;
                    }
                });
            }
        }

        function openAccountModal() {
            document.getElementById('accountModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function submitCategoryForm() {
            const form = document.getElementById('categoryForm');
            const formData = new FormData(form);
            
            fetch('{{ route("categories.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add new category to dropdown
                    const categorySelect = document.getElementById('category_id');
                    const option = document.createElement('option');
                    option.value = data.category.id;
                    option.textContent = data.category.name + ' (' + data.category.type.charAt(0).toUpperCase() + data.category.type.slice(1) + ')';
                    option.setAttribute('data-type', data.category.type);
                    categorySelect.appendChild(option);
                    
                    // Select the new category
                    categorySelect.value = data.category.id;
                    
                    // Filter categories based on current type
                    const typeRadios = document.querySelectorAll('input[name="type"]');
                    const categoryOptions = Array.from(categorySelect.options);
                    const selectedType = document.querySelector('input[name="type"]:checked')?.value;
                    
                    if (selectedType) {
                        categorySelect.innerHTML = '<option value="">Select category</option>';
                        categoryOptions.forEach(option => {
                            if (option.value && option.getAttribute('data-type') === selectedType) {
                                categorySelect.appendChild(option.cloneNode(true));
                            }
                        });
                        categorySelect.value = data.category.id;
                    }
                    
                    // Reset form and close modal
                    form.reset();
                    closeModal('categoryModal');
                } else {
                    alert('Error creating category: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error creating category');
            });
        }

        function submitAccountForm() {
            const form = document.getElementById('accountForm');
            const formData = new FormData(form);
            
            fetch('{{ route("accounts.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add new account to dropdown
                    const accountSelect = document.getElementById('account_id');
                    const option = document.createElement('option');
                    option.value = data.account.id;
                    option.textContent = data.account.name + ' (' + data.account.type.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) + ') - $' + parseFloat(data.account.balance).toFixed(2);
                    accountSelect.appendChild(option);
                    
                    // Select the new account
                    accountSelect.value = data.account.id;
                    
                    // Reset form and close modal
                    form.reset();
                    closeModal('accountModal');
                } else {
                    alert('Error creating account: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error creating account');
            });
        }
    </script>

    <!-- Category Modal -->
    <div id="categoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg max-w-md w-full max-h-screen overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Create New Category</h3>
                    <button type="button" onclick="closeModal('categoryModal')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <form id="categoryForm">
                    <div class="space-y-4">
                        <!-- Category Name -->
                        <div>
                            <label for="modal_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="modal_name" 
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   required>
                        </div>

                        <!-- Category Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Type <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="relative">
                                    <input type="radio" name="modal_type" value="income" class="sr-only peer">
                                    <div class="p-3 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20">
                                        <div class="flex items-center space-x-2">
                                            <div class="p-1 bg-green-100 dark:bg-green-900/30 rounded-full">
                                                <svg class="w-3 h-3 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium">Income</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative">
                                    <input type="radio" name="modal_type" value="expense" class="sr-only peer">
                                    <div class="p-3 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/20">
                                        <div class="flex items-center space-x-2">
                                            <div class="p-1 bg-red-100 dark:bg-red-900/30 rounded-full">
                                                <svg class="w-3 h-3 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium">Expense</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Color -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Color
                            </label>
                            <div class="flex space-x-2">
                                <label class="relative">
                                    <input type="radio" name="color" value="#ef4444" class="sr-only peer" checked>
                                    <div class="w-8 h-8 bg-red-500 rounded-full cursor-pointer ring-2 ring-offset-2 peer-checked:ring-red-500"></div>
                                </label>
                                <label class="relative">
                                    <input type="radio" name="color" value="#22c55e" class="sr-only peer">
                                    <div class="w-8 h-8 bg-green-500 rounded-full cursor-pointer ring-2 ring-offset-2 peer-checked:ring-green-500"></div>
                                </label>
                                <label class="relative">
                                    <input type="radio" name="color" value="#3b82f6" class="sr-only peer">
                                    <div class="w-8 h-8 bg-blue-500 rounded-full cursor-pointer ring-2 ring-offset-2 peer-checked:ring-blue-500"></div>
                                </label>
                                <label class="relative">
                                    <input type="radio" name="color" value="#f59e0b" class="sr-only peer">
                                    <div class="w-8 h-8 bg-yellow-500 rounded-full cursor-pointer ring-2 ring-offset-2 peer-checked:ring-yellow-500"></div>
                                </label>
                                <label class="relative">
                                    <input type="radio" name="color" value="#8b5cf6" class="sr-only peer">
                                    <div class="w-8 h-8 bg-purple-500 rounded-full cursor-pointer ring-2 ring-offset-2 peer-checked:ring-purple-500"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                        <button type="button" onclick="closeModal('categoryModal')" class="px-4 py-2 text-sm text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="button" onclick="submitCategoryForm()" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Create Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Account Modal -->
    <div id="accountModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg max-w-md w-full max-h-screen overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Create New Account</h3>
                    <button type="button" onclick="closeModal('accountModal')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <form id="accountForm">
                    <div class="space-y-4">
                        <!-- Account Name -->
                        <div>
                            <label for="modal_account_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Account Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="modal_account_name" 
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   required>
                        </div>

                        <!-- Account Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Type <span class="text-red-500">*</span>
                            </label>
                            <select name="type" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                <option value="checking">Checking</option>
                                <option value="savings">Savings</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="cash">Cash</option>
                                <option value="investment">Investment</option>
                            </select>
                        </div>

                        <!-- Initial Balance -->
                        <div>
                            <label for="modal_balance" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Initial Balance <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" 
                                       name="balance" 
                                       id="modal_balance" 
                                       step="0.01"
                                       class="block w-full pl-7 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                       placeholder="0.00"
                                       required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                        <button type="button" onclick="closeModal('accountModal')" class="px-4 py-2 text-sm text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="button" onclick="submitAccountForm()" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Create Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </script>
@endsection