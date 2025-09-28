@extends('layouts.base')

@section('title', 'Edit Budget - ' . config('ap                                <button type="button"
                                        onclick="openCategoryModal()"
                                        class="px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-md border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 transition-colors flex items-center"
                                        title="Create new expense category">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>)
@section('app-name', 'Budget Tracker')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold">Edit Budget</h1>
                <p class="text-muted-foreground">Update spending limits for your expense categories</p>
            </div>
            <a href="{{ route('budgets.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Budgets
            </a>
        </div>

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

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
                <form action="{{ route('budgets.update', $budget) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Budget Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Budget Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $budget->name) }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                   placeholder="e.g., Monthly Food Budget"
                                   required>
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
                                    <option value="">Select expense category</option>
                                    @foreach($expenseCategories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ (old('category_id', $budget->category_id) == $category->id) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <a href="{{ route('categories.create') }}?type=expense" 
                                   target="_blank"
                                   class="px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-md border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 transition-colors flex items-center"
                                   title="Create new expense category (opens in new tab)">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </a>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Only expense categories can have budgets</p>
                        </div>

                        <!-- Budget Amount -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Budget Amount <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" 
                                       name="amount" 
                                       id="amount" 
                                       value="{{ old('amount', number_format($budget->amount, 2, '.', '')) }}"
                                       step="0.01"
                                       min="0.01"
                                       class="block w-full pl-7 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                       placeholder="0.00"
                                       required>
                            </div>
                        </div>

                        <!-- Budget Period -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Start Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="start_date" 
                                       id="start_date" 
                                       value="{{ old('start_date', $budget->start_date) }}"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                       required>
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    End Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="end_date" 
                                       id="end_date" 
                                       value="{{ old('end_date', $budget->end_date) }}"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                       required>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Description
                            </label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="3"
                                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                      placeholder="Optional description for this budget">{{ old('description', $budget->description) }}</textarea>
                        </div>

                        <!-- Budget Limiter -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" 
                                       name="is_limiter" 
                                       id="is_limiter" 
                                       value="1"
                                       {{ old('is_limiter', $budget->is_limiter) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600">
                            </div>
                            <div class="ml-3">
                                <label for="is_limiter" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Act as spending limiter
                                </label>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    <p class="mt-1">When enabled, this budget will prevent transactions that would exceed the budget limit.</p>
                                    <p class="mt-1">When disabled, transactions can exceed the budget but you'll see overspending warnings.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t mt-6">
                        <button type="button" onclick="window.history.back()" 
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors">
                            Update Budget
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openCategoryModal() {
            document.getElementById('categoryModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Pre-select expense type since this is for budgets
            const expenseRadio = document.querySelector('#categoryModal input[name="modal_type"][value="expense"]');
            if (expenseRadio) {
                expenseRadio.checked = true;
            }
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
                    // Add new category to dropdown (only if it's expense type)
                    if (data.category.type === 'expense') {
                        const categorySelect = document.getElementById('category_id');
                        const option = document.createElement('option');
                        option.value = data.category.id;
                        option.textContent = data.category.name;
                        categorySelect.appendChild(option);
                        
                        // Select the new category
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
@endsection