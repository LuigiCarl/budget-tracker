@extends('layouts.base')

@section('title', 'Edit Category - ' . config('app.name'))
@section('app-name', 'Budget Tracker')

@section('content')
    <div class="space-y-4 sm:space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="scroll-m-20 text-2xl sm:text-4xl font-extrabold tracking-tight">
                    Edit Category
                </h1>
                <p class="text-base sm:text-xl text-muted-foreground">
                    Update category information
                </p>
            </div>
            <a href="{{ route('categories.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-border rounded-lg hover:bg-accent transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Categories
            </a>
        </div>

        <!-- Form Card -->
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
            <form action="{{ route('categories.update', $category) }}" method="POST" class="p-4 sm:p-6">
                @csrf
                @method('PUT')
                
                <div class="space-y-4 sm:space-y-6">
                    <!-- Name Field -->
                    <div class="space-y-2">
                        <label for="name" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name"
                            name="name" 
                            value="{{ old('name', $category->name) }}"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 @error('name') border-red-500 @enderror"
                            placeholder="Enter category name"
                            required
                        >
                        @error('name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type Field -->
                    <div class="space-y-2">
                        <label for="type" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                            Category Type <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="type"
                            name="type"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 @error('type') border-red-500 @enderror"
                            required
                        >
                            <option value="">Select category type</option>
                            <option value="income" {{ old('type', $category->type) == 'income' ? 'selected' : '' }}>Income</option>
                            <option value="expense" {{ old('type', $category->type) == 'expense' ? 'selected' : '' }}>Expense</option>
                        </select>
                        @error('type')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Color Field -->
                    <div class="space-y-2">
                        <label for="color" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                            Category Color
                        </label>
                        <div class="flex items-center space-x-3">
                            <input 
                                type="color" 
                                id="color"
                                name="color" 
                                value="{{ old('color', $category->color ?? '#6366f1') }}"
                                class="h-10 w-16 rounded-md border border-input cursor-pointer disabled:cursor-not-allowed disabled:opacity-50"
                            >
                            <div class="flex-1">
                                <input 
                                    type="text" 
                                    id="color-text"
                                    value="{{ old('color', $category->color ?? '#6366f1') }}"
                                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                    placeholder="#6366f1"
                                    readonly
                                >
                            </div>
                        </div>
                        <p class="text-sm text-muted-foreground">Choose a color to help identify this category</p>
                        @error('color')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description Field -->
                    <div class="space-y-2">
                        <label for="description" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                            Description
                        </label>
                        <textarea 
                            id="description"
                            name="description" 
                            rows="3"
                            class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 @error('description') border-red-500 @enderror"
                            placeholder="Optional description for this category"
                        >{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 sm:justify-end pt-4 border-t">
                        <a href="{{ route('categories.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-border rounded-lg hover:bg-accent transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Category
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Sync color picker with text input
        const colorPicker = document.getElementById('color');
        const colorText = document.getElementById('color-text');
        
        colorPicker.addEventListener('input', function() {
            colorText.value = this.value;
        });
    </script>
@endsection