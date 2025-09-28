@extends('layouts.base')

@section('title', 'Edit Account - ' . config('app.name'))
@section('app-name', 'Budget Tracker')

@section('content')
    <div class="space-y-4 sm:space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="scroll-m-20 text-2xl sm:text-4xl font-extrabold tracking-tight">
                    Edit Account
                </h1>
                <p class="text-base sm:text-xl text-muted-foreground">
                    Update your account information
                </p>
            </div>
            <a href="{{ route('accounts.show', $account) }}" class="inline-flex items-center justify-center px-4 py-2 border border-border rounded-lg hover:bg-accent transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Account
            </a>
        </div>

        <!-- Form -->
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
            <div class="p-4 sm:p-6">
                <form method="POST" action="{{ route('accounts.update', $account) }}" class="space-y-4 sm:space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Account Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium mb-2">Account Name</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $account->name) }}"
                            class="w-full px-3 py-2 border border-input rounded-lg focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent @error('name') border-red-500 @enderror"
                            placeholder="Enter account name"
                            required
                        >
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Account Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium mb-2">Account Type</label>
                        <select 
                            id="type" 
                            name="type"
                            class="w-full px-3 py-2 border border-input rounded-lg focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent @error('type') border-red-500 @enderror"
                            required
                        >
                            <option value="">Select account type</option>
                            @foreach($typeOptions as $value => $label)
                                <option value="{{ $value }}" {{ old('type', $account->type) === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Balance -->
                    <div>
                        <label for="balance" class="block text-sm font-medium mb-2">Current Balance</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-muted-foreground">$</span>
                            <input 
                                type="number" 
                                id="balance" 
                                name="balance" 
                                value="{{ old('balance', $account->balance) }}"
                                step="0.01" 
                                min="0"
                                class="w-full pl-8 pr-3 py-2 border border-input rounded-lg focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent @error('balance') border-red-500 @enderror"
                                placeholder="0.00"
                                required
                            >
                        </div>
                        <p class="text-sm text-muted-foreground mt-1">
                            Note: Changing this will affect your account balance calculation
                        </p>
                        @error('balance')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium mb-2">Description (Optional)</label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="3"
                            class="w-full px-3 py-2 border border-input rounded-lg focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent @error('description') border-red-500 @enderror"
                            placeholder="Add a description for this account..."
                        >{{ old('description', $account->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">
                        <button 
                            type="submit"
                            class="inline-flex items-center justify-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Account
                        </button>
                        <a 
                            href="{{ route('accounts.show', $account) }}" 
                            class="inline-flex items-center justify-center px-6 py-2 border border-border rounded-lg hover:bg-accent transition-colors"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection