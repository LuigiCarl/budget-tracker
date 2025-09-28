@extends('layouts.base')

@section('title', 'Create Category - ' . config('app.name'))
@section('app-name', 'Budget Tracker')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 space-y-4 sm:space-y-0">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold">Create Category</h1>
                <p class="text-muted-foreground">Add a new category to organize your transactions</p>
            </div>
            <a href="{{ route('categories.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Categories
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
            <div class="p-4 sm:p-6">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- Category Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                   placeholder="e.g., Food & Dining, Salary, Entertainment"
                                   required>
                        </div>

                        <!-- Category Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                Category Type <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <label class="relative">
                                    <input type="radio" name="type" value="income" class="sr-only peer" {{ old('type') === 'income' ? 'checked' : '' }}>
                                    <div class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                        <div class="flex items-center space-x-3">
                                            <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-full">
                                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="font-medium">Income</span>
                                                <p class="text-xs text-muted-foreground">Money coming in</p>
                                            </div>
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
                                            <div>
                                                <span class="font-medium">Expense</span>
                                                <p class="text-xs text-muted-foreground">Money going out</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Color Picker -->
                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                Category Color <span class="text-red-500">*</span>
                            </label>
                            <div class="flex flex-wrap gap-3 mb-4">
                                @php
                                    $colors = ['#ef4444', '#f97316', '#eab308', '#22c55e', '#10b981', '#06b6d4', '#3b82f6', '#6366f1', '#8b5cf6', '#ec4899', '#f43f5e', '#64748b'];
                                @endphp
                                @foreach($colors as $colorOption)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="display_color" value="{{ $colorOption }}" class="sr-only peer" {{ old('color', '#ef4444') === $colorOption ? 'checked' : '' }}>
                                        <div class="w-10 h-10 rounded-full border-2 border-gray-300 peer-checked:border-gray-800 dark:peer-checked:border-gray-200 peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-gray-400 transition-all hover:scale-110" 
                                             style="background-color: {{ $colorOption }};"></div>
                                    </label>
                                @endforeach
                            </div>
                            <div class="flex items-center space-x-2">
                                <label for="color_custom" class="text-sm text-gray-700 dark:text-gray-300">Custom:</label>
                                <input type="color" 
                                       id="color_custom" 
                                       value="{{ old('color', '#ef4444') }}"
                                       class="w-12 h-8 border border-gray-300 rounded cursor-pointer"
                                       onchange="document.querySelector('input[name=display_color][value=\'' + this.value + '\']')?.click() || addCustomColor(this.value)">
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
                                      placeholder="Optional description for this category">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200 dark:border-gray-600">
                        <input type="hidden" id="processed_color" name="color" value="{{ old('color', 'ef4444') }}">
                        <a href="{{ route('categories.index') }}" class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 text-center">
                            Cancel
                        </a>
                        <button type="submit" class="w-full sm:w-auto px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Create Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function addCustomColor(color) {
            // Remove any existing custom color selection
            document.querySelectorAll('input[name="display_color"]').forEach(input => input.checked = false);
            
            // Set the processed color value (removing #)
            document.getElementById('processed_color').value = color.replace('#', '');
            
            // Create a new radio input for the custom color
            const customInput = document.createElement('input');
            customInput.type = 'radio';
            customInput.name = 'display_color';
            customInput.value = color;
            customInput.checked = true;
            customInput.style.display = 'none';
            
            document.querySelector('form').appendChild(customInput);
        }
        
        // Add event listeners for preset color selection
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[name="display_color"]').forEach(input => {
                input.addEventListener('change', function() {
                    if (this.checked) {
                        document.getElementById('processed_color').value = this.value.replace('#', '');
                    }
                });
            });
            
            // Set initial value
            const checkedColor = document.querySelector('input[name="display_color"]:checked');
            if (checkedColor) {
                document.getElementById('processed_color').value = checkedColor.value.replace('#', '');
            }
        });
    </script>
@endsection