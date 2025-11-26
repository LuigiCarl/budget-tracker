@extends('layouts.base')

@section('title', 'API Documentation - ' . config('app.name'))
@section('app-name', 'API Documentation')

@section('sidebar')
<div class="w-full" x-data="{ 
    authSection: true,
    featuresSection: true,
    userSection: true,
    accountSection: false,
    categorySection: false,
    transactionSection: false,
    budgetSection: false,
    testingSection: false 
}">
    <!-- Authentication Section -->
    <div class="pb-4">
        <button @click="authSection = !authSection" 
                class="flex w-full items-center justify-between rounded-md border border-transparent px-2 py-1 text-sm font-semibold hover:bg-accent hover:text-accent-foreground">
            <span>🔐 Authentication</span>
            <svg class="h-3 w-3 transition-transform duration-200" :class="{ 'rotate-90': authSection }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <div x-show="authSection" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="ml-4 mt-2 space-y-1 border-l border-border pl-4">
            <a href="#token-auth" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                Token Setup
            </a>
        </div>
    </div>

    <!-- New Features Section -->
    <div class="pb-4">
        <button @click="featuresSection = !featuresSection" 
                class="flex w-full items-center justify-between rounded-md border border-transparent px-2 py-1 text-sm font-semibold hover:bg-accent hover:text-accent-foreground">
            <span>🎉 New Features</span>
            <svg class="h-3 w-3 transition-transform duration-200" :class="{ 'rotate-90': featuresSection }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <div x-show="featuresSection" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="ml-4 mt-2 space-y-1 border-l border-border pl-4">
            <a href="#new-features" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                Latest Updates (v1.3)
            </a>
        </div>
    </div>

    <!-- User Management Section -->
    <div class="pb-4">
        <button @click="userSection = !userSection" 
                class="flex w-full items-center justify-between rounded-md border border-transparent px-2 py-1 text-sm font-semibold hover:bg-accent hover:text-accent-foreground">
            <span>👤 User Management</span>
            <svg class="h-3 w-3 transition-transform duration-200" :class="{ 'rotate-90': userSection }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <div x-show="userSection" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="ml-4 mt-2 space-y-1 border-l border-border pl-4">
            <a href="#register" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                User Registration
            </a>
            <a href="#login" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                User Login
            </a>
            <a href="#get-user" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                Get User Profile
            </a>
            <a href="#update-profile" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                Update Profile
            </a>
            <a href="#update-password" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                Update Password
            </a>
            <a href="#logout" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                Logout
            </a>
            <a href="#delete-account" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                Delete Account
            </a>
        </div>
    </div>

    <!-- Account Management Section -->
    <div class="pb-4">
        <button @click="accountSection = !accountSection" 
                class="flex w-full items-center justify-between rounded-md border border-transparent px-2 py-1 text-sm font-semibold hover:bg-accent hover:text-accent-foreground">
            <span>💳 Account Management</span>
            <svg class="h-3 w-3 transition-transform duration-200" :class="{ 'rotate-90': accountSection }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <div x-show="accountSection" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="ml-4 mt-2 space-y-1 border-l border-border pl-4">
            <a href="#account-management" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                List All Accounts
            </a>
            <a href="#account-management" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                Create New Account
            </a>
            <a href="#account-management" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                Get Account Details
            </a>
            <a href="#account-management" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                Update Account
            </a>
            <a href="#account-management" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                Delete Account
            </a>
        </div>
    </div>

    <!-- Category Management Section -->
    <div class="pb-4">
        <button @click="categorySection = !categorySection" 
                class="flex w-full items-center justify-between rounded-md border border-transparent px-2 py-1 text-sm font-semibold hover:bg-accent hover:text-accent-foreground">
            <span>🏷️ Category Management</span>
            <svg class="h-3 w-3 transition-transform duration-200" :class="{ 'rotate-90': categorySection }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <div x-show="categorySection" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="ml-4 mt-2 space-y-1 border-l border-border pl-4">
            <a href="#category-management" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                List All Categories
            </a>
            <a href="#category-management" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                Create New Category
            </a>
            <a href="#category-management" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                Get Category Analytics
            </a>
        </div>
    </div>

    <!-- Transaction Management Section -->
    <div class="pb-4">
        <button @click="transactionSection = !transactionSection" 
                class="flex w-full items-center justify-between rounded-md border border-transparent px-2 py-1 text-sm font-semibold hover:bg-accent hover:text-accent-foreground">
            <span>💸 Transaction Management</span>
            <svg class="h-3 w-3 transition-transform duration-200" :class="{ 'rotate-90': transactionSection }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <div x-show="transactionSection" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="ml-4 mt-2 space-y-1 border-l border-border pl-4">
            <a href="#transaction-management" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                List All Transactions
            </a>
            <a href="#transaction-management" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                Create New Transaction
            </a>
        </div>
    </div>

    <!-- Budget Management Section -->
    <div class="pb-4">
        <button @click="budgetSection = !budgetSection" 
                class="flex w-full items-center justify-between rounded-md border border-transparent px-2 py-1 text-sm font-semibold hover:bg-accent hover:text-accent-foreground">
            <span>📊 Budget Management</span>
            <svg class="h-3 w-3 transition-transform duration-200" :class="{ 'rotate-90': budgetSection }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <div x-show="budgetSection" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="ml-4 mt-2 space-y-1 border-l border-border pl-4">
            <a href="#budget-management" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                List All Budgets
            </a>
            <a href="#budget-create" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                Create New Budget
            </a>
            <a href="#budget-update" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                Update Budget
            </a>
            <a href="#budget-delete" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                Delete Budget
            </a>
        </div>
    </div>

    <!-- Interactive Testing Section -->
    <div class="pb-4">
        <button @click="testingSection = !testingSection" 
                class="flex w-full items-center justify-between rounded-md border border-transparent px-2 py-1 text-sm font-semibold hover:bg-accent hover:text-accent-foreground">
            <span>🧪 Interactive Testing</span>
            <svg class="h-3 w-3 transition-transform duration-200" :class="{ 'rotate-90': testingSection }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <div x-show="testingSection" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="ml-4 mt-2 space-y-1 border-l border-border pl-4">
            <a href="#testing-guide" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                Testing Guide
            </a>
            <a href="#examples" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                Code Examples
            </a>
        </div>
    </div>

    <!-- Future Development Section -->
    <div class="pb-4">
        <a href="#future-development" class="nav-link flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm font-semibold hover:bg-accent hover:text-accent-foreground">
            <span>🚧 Future Development</span>
        </a>
    </div>
</div>
@endsection

@section('toc')
<div class="pb-4">
    <div class="flex items-center gap-2 mb-3">
        <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
        </svg>
        <p class="font-semibold text-foreground">On This Page</p>
    </div>
    <div id="toc-container" class="border-l border-border"></div>
</div>
@endsection

@push('styles')
<style>
    /* Method badges */
    .method-badge {
        font-weight: bold;
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        text-transform: uppercase;
    }
    .method-get { background-color: #10b981; color: white; }
    .method-post { background-color: #3b82f6; color: white; }
    .method-put { background-color: #f59e0b; color: white; }
    .method-delete { background-color: #ef4444; color: white; }

    /* Response containers */
    pre {
        background-color: hsl(var(--muted));
        color: hsl(var(--foreground));
        padding: 1rem;
        border-radius: 0.375rem;
        overflow-x: auto;
        white-space: pre-wrap;
    }
    .response-container {
        max-height: 300px;
        overflow-y: auto;
    }

    /* TOC Styles */
    .toc-link {
        display: block;
        padding: 0.25rem 0;
        font-size: 0.875rem;
        transition: all 0.2s;
        border-left: 2px solid transparent;
        padding-left: 1rem;
    }
    .toc-link:hover {
        color: hsl(var(--foreground));
        border-left-color: hsl(var(--border));
    }
    .toc-link.active {
        color: hsl(var(--primary));
        font-weight: 500;
        border-left-color: hsl(var(--primary));
    }

    /* Navigation active states */
    .nav-link {
        position: relative;
        transition: all 0.2s ease-in-out;
    }
    
    .nav-link.active {
        background: hsl(var(--accent));
        color: hsl(var(--accent-foreground));
        font-weight: 500;
    }
    
    .nav-link.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 2px;
        background: hsl(var(--primary));
        border-radius: 0 1px 1px 0;
    }
    
    .section-button-active {
        background: hsl(var(--accent)) !important;
        color: hsl(var(--accent-foreground)) !important;
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <div class="space-y-2 mb-8">
        <h1 class="scroll-m-20 text-4xl font-extrabold tracking-tight lg:text-5xl">
            API Documentation
        </h1>
        <p class="text-xl text-muted-foreground">
            Complete reference for the Budget Tracker API with interactive testing capabilities.
        </p>
    </div>

    <!-- Authentication Overview -->
    <div class="mb-12">
        <h2 id="token-auth" class="scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight mb-6">
            🔐 Authentication
        </h2>
        
        <div class="space-y-6">
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-6 pt-0 space-y-4 mt-6">
                    <div class="flex items-center space-x-3 p-4 bg-blue-50 dark:bg-blue-950/30 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-blue-900 dark:text-blue-100">
                                Currently authenticated as: <strong>{{ auth()->user()->name }}</strong>
                            </p>
                            <p class="text-xs text-blue-700 dark:text-blue-300">
                                Email: {{ auth()->user()->email }}
                            </p>
                        </div>
                    </div>

                    <div class="prose prose-sm max-w-none dark:prose-invert">
                        <p>This API uses <strong>Laravel Sanctum</strong> for authentication. You'll need to create an API token to access protected endpoints.</p>
                        <p>Include your token in the <code>Authorization</code> header:</p>
                        <pre><code>Authorization: Bearer {your-token-here}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Create Token Form -->
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Create New API Token</h3>
                    <form id="create-token-form" class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none">Token Name</label>
                            <input type="text" id="token-name" 
                                   class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                                   placeholder="My API Token" required>
                        </div>
                        <button type="submit" 
                                class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                            Create Token
                        </button>
                    </form>
                    
                    <!-- Token Display -->
                    <div id="new-token-display" class="mt-6 hidden">
                        <div class="rounded-lg border border-green-200 bg-green-50 dark:border-green-800 dark:bg-green-950/30 p-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-600 dark:text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-green-900 dark:text-green-100 mb-3">Token created successfully!</p>
                                    <div class="rounded border bg-background p-3">
                                        <p class="text-xs text-muted-foreground mb-2">Your API Token:</p>
                                        <div class="flex items-center justify-between">
                                            <code id="new-token-value" class="text-sm font-mono text-foreground break-all flex-1 mr-2"></code>
                                            <button onclick="copyToken()" 
                                                    class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-8 px-3 py-1">
                                                Copy
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-xs text-green-700 dark:text-green-300 mt-3 font-medium">
                                        ⚠️ Save this token now. You won't be able to see it again!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Global Token Input -->
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Set Token for Testing</h3>
                    <p class="text-sm text-muted-foreground mb-4">Enter your API token to authenticate requests in the testing forms below:</p>
                    <div class="flex space-x-2">
                        <input 
                            type="text" 
                            id="globalToken" 
                            placeholder="Bearer token (e.g., 1|abcd...)" 
                            class="flex h-10 flex-1 rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                        >
                        <button 
                            onclick="setGlobalToken()" 
                            class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2"
                        >
                            Set Token
                        </button>
                        <button 
                            onclick="clearGlobalToken()" 
                            class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2"
                        >
                            Clear
                        </button>
                    </div>
                    <div id="tokenStatus" class="mt-2 text-sm"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Features & CRUD Operations -->
    <div class="mb-12">
        <h2 id="new-features" class="scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight mb-6">
            🎉 Latest Features & Updates
        </h2>
        
        <div class="space-y-6">
            <!-- Feature Highlights -->
            <div class="rounded-lg border border-border bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-950/20 dark:to-purple-950/20 shadow-sm">
                <div class="p-6">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-blue-200 dark:border-blue-800">
                            <h3 class="font-semibold text-blue-700 dark:text-blue-300 mb-2">✅ CRUD Operations Optimization (v1.2)</h3>
                            <ul class="text-sm text-blue-600 dark:text-blue-400 space-y-1">
                                <li>• Fixed 403 authorization errors</li>
                                <li>• Consistent user scoping pattern</li>
                                <li>• Enhanced security with database-level isolation</li>
                                <li>• Improved performance with direct queries</li>
                            </ul>
                        </div>
                        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-purple-200 dark:border-purple-800">
                            <h3 class="font-semibold text-purple-700 dark:text-purple-300 mb-2">✅ Enhanced Account Management (v1.2)</h3>
                            <ul class="text-sm text-purple-600 dark:text-purple-400 space-y-1">
                                <li>• Fixed balance field mapping issues</li>
                                <li>• Improved form validation</li>
                                <li>• Account details with transaction history</li>
                                <li>• Mobile-responsive interface</li>
                            </ul>
                        </div>
                        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-green-200 dark:border-green-800">
                            <h3 class="font-semibold text-green-700 dark:text-green-300 mb-2">✅ Category Color System (v1.2)</h3>
                            <ul class="text-sm text-green-600 dark:text-green-400 space-y-1">
                                <li>• Flexible hex color input (with/without #)</li>
                                <li>• Enhanced validation regex patterns</li>
                                <li>• Custom color picker support</li>
                                <li>• Visual consistency improvements</li>
                            </ul>
                        </div>
                        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-orange-200 dark:border-orange-800">
                            <h3 class="font-semibold text-orange-700 dark:text-orange-300 mb-2">✅ Advanced Analytics API (v1.3)</h3>
                            <ul class="text-sm text-orange-600 dark:text-orange-400 space-y-1">
                                <li>• Dashboard with comprehensive financial summary</li>
                                <li>• Monthly analytics with year comparison</li>
                                <li>• Spending trends analysis (30/90/365 days)</li>
                                <li>• Category breakdown with percentages</li>
                                <li>• Budget performance metrics & projections</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CRUD API Endpoints Overview -->
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-4">📋 Complete CRUD API Endpoints</h3>
                    <p class="text-muted-foreground mb-6">The Budget Tracker API now provides full CRUD operations for all financial entities with optimized user scoping and enhanced security.</p>
                    
                    <div class="space-y-6">
                        <!-- Dashboard & Analytics -->
                        <div class="border-l-4 border-purple-500 pl-4">
                            <h4 class="text-lg font-semibold text-purple-700 dark:text-purple-300 mb-3">Dashboard & Analytics</h4>
                            <div class="space-y-2">
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-mono">GET</span>
                                    <code class="text-sm">/api/dashboard</code>
                                    <span class="text-sm text-muted-foreground">Get comprehensive financial analytics</span>
                                </div>
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-mono">GET</span>
                                    <code class="text-sm">/api/analytics/monthly?year={year}</code>
                                    <span class="text-sm text-muted-foreground">Month-by-month comparison for a year</span>
                                </div>
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-mono">GET</span>
                                    <code class="text-sm">/api/analytics/trends?period={30|90|365}</code>
                                    <span class="text-sm text-muted-foreground">Spending trends over period</span>
                                </div>
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-mono">GET</span>
                                    <code class="text-sm">/api/analytics/category-breakdown?month={YYYY-MM}</code>
                                    <span class="text-sm text-muted-foreground">Detailed category spending breakdown</span>
                                </div>
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-mono">GET</span>
                                    <code class="text-sm">/api/analytics/budget-performance</code>
                                    <span class="text-sm text-muted-foreground">Budget adherence metrics and projections</span>
                                </div>
                            </div>
                        </div>

                        <!-- Account Management -->
                        <div class="border-l-4 border-green-500 pl-4">
                            <h4 class="text-lg font-semibold text-green-700 dark:text-green-300 mb-3">Account Management</h4>
                            <div class="space-y-2">
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-mono">GET</span>
                                    <code class="text-sm">/api/accounts</code>
                                    <span class="text-sm text-muted-foreground">List all user accounts</span>
                                </div>
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded font-mono">POST</span>
                                    <code class="text-sm">/api/accounts</code>
                                    <span class="text-sm text-muted-foreground">Create new account</span>
                                </div>
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-mono">GET</span>
                                    <code class="text-sm">/api/accounts/{id}</code>
                                    <span class="text-sm text-muted-foreground">Get account with transaction history</span>
                                </div>
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded font-mono">PUT</span>
                                    <code class="text-sm">/api/accounts/{id}</code>
                                    <span class="text-sm text-muted-foreground">Update account details</span>
                                </div>
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded font-mono">DELETE</span>
                                    <code class="text-sm">/api/accounts/{id}</code>
                                    <span class="text-sm text-muted-foreground">Delete account and transactions</span>
                                </div>
                            </div>
                        </div>

                        <!-- Category Management -->
                        <div class="border-l-4 border-orange-500 pl-4">
                            <h4 class="text-lg font-semibold text-orange-700 dark:text-orange-300 mb-3">Category Management</h4>
                            <div class="space-y-2">
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-mono">GET</span>
                                    <code class="text-sm">/api/categories</code>
                                    <span class="text-sm text-muted-foreground">List all categories with statistics</span>
                                </div>
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded font-mono">POST</span>
                                    <code class="text-sm">/api/categories</code>
                                    <span class="text-sm text-muted-foreground">Create category with color validation</span>
                                </div>
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-mono">GET</span>
                                    <code class="text-sm">/api/categories/{id}</code>
                                    <span class="text-sm text-muted-foreground">Get category with spending analytics</span>
                                </div>
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded font-mono">PUT</span>
                                    <code class="text-sm">/api/categories/{id}</code>
                                    <span class="text-sm text-muted-foreground">Update category and color</span>
                                </div>
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded font-mono">DELETE</span>
                                    <code class="text-sm">/api/categories/{id}</code>
                                    <span class="text-sm text-muted-foreground">Delete category</span>
                                </div>
                            </div>
                        </div>

                        <!-- Transaction Management -->
                        <div class="border-l-4 border-indigo-500 pl-4">
                            <h4 class="text-lg font-semibold text-indigo-700 dark:text-indigo-300 mb-3">Transaction Management</h4>
                            <div class="space-y-2">
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-mono">GET</span>
                                    <code class="text-sm">/api/transactions</code>
                                    <span class="text-sm text-muted-foreground">List with filtering and pagination</span>
                                </div>
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded font-mono">POST</span>
                                    <code class="text-sm">/api/transactions</code>
                                    <span class="text-sm text-muted-foreground">Create with account/category validation</span>
                                </div>
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-mono">GET</span>
                                    <code class="text-sm">/api/transactions/{id}</code>
                                    <span class="text-sm text-muted-foreground">Get transaction with relationships</span>
                                </div>
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded font-mono">PUT</span>
                                    <code class="text-sm">/api/transactions/{id}</code>
                                    <span class="text-sm text-muted-foreground">Update transaction details</span>
                                </div>
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded font-mono">DELETE</span>
                                    <code class="text-sm">/api/transactions/{id}</code>
                                    <span class="text-sm text-muted-foreground">Delete transaction</span>
                                </div>
                            </div>
                        </div>

                        <!-- Budget Management -->
                        <div class="border-l-4 border-pink-500 pl-4">
                            <h4 class="text-lg font-semibold text-pink-700 dark:text-pink-300 mb-3">Budget Management</h4>
                            <div class="space-y-2">
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-mono">GET</span>
                                    <code class="text-sm">/api/budgets</code>
                                    <span class="text-sm text-muted-foreground">List budgets with progress tracking</span>
                                </div>
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded font-mono">POST</span>
                                    <code class="text-sm">/api/budgets</code>
                                    <span class="text-sm text-muted-foreground">Create budget with overlap validation</span>
                                </div>
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-mono">GET</span>
                                    <code class="text-sm">/api/budgets/{id}</code>
                                    <span class="text-sm text-muted-foreground">Get budget with spending details</span>
                                </div>
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded font-mono">PUT</span>
                                    <code class="text-sm">/api/budgets/{id}</code>
                                    <span class="text-sm text-muted-foreground">Update budget parameters</span>
                                </div>
                                <div class="flex items-center gap-4 p-2 rounded hover:bg-muted/50">
                                    <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded font-mono">DELETE</span>
                                    <code class="text-sm">/api/budgets/{id}</code>
                                    <span class="text-sm text-muted-foreground">Delete budget</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security & Performance Improvements -->
                    <div class="mt-8 p-4 bg-green-50 dark:bg-green-950/30 rounded-lg border border-green-200 dark:border-green-800">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-green-800 dark:text-green-200">Security & Performance Enhancements</p>
                                <div class="text-sm text-green-700 dark:text-green-300 mt-1 space-y-1">
                                    <p>• <strong>Database-level User Isolation:</strong> All queries scoped with <code>where('user_id', Auth::id())</code></p>
                                    <p>• <strong>Enhanced Validation:</strong> Improved field validation and error handling</p>
                                    <p>• <strong>Optimized Queries:</strong> Direct model queries instead of relationship traversal</p>
                                    <p>• <strong>Consistent Error Responses:</strong> Standardized HTTP status codes and error messages</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Registration -->
    <div class="mb-12">
        <h2 id="register" class="scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight mb-6">
            User Registration
        </h2>
        
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm endpoint-card">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span class="method-badge method-post">POST</span>
                        <code class="text-lg font-mono">/api/register</code>
                    </div>
                    <span class="text-sm text-muted-foreground">Authentication: None</span>
                </div>
                
                <p class="text-muted-foreground mb-6">Register a new user account</p>
                
                <div class="grid lg:grid-cols-2 gap-6">
                    <!-- Parameters -->
                    <div>
                        <h4 class="text-lg font-semibold mb-3">Request Parameters</h4>
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                <code class="text-sm">name</code>
                                <span class="text-xs text-muted-foreground">string, required</span>
                            </div>
                            <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                <code class="text-sm">email</code>
                                <span class="text-xs text-muted-foreground">string, required</span>
                            </div>
                            <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                <code class="text-sm">password</code>
                                <span class="text-xs text-muted-foreground">string, required (min: 8)</span>
                            </div>
                            <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                <code class="text-sm">password_confirmation</code>
                                <span class="text-xs text-muted-foreground">string, required</span>
                            </div>
                        </div>
                        
                        <!-- Test Form -->
                        <div class="rounded-lg border border-border bg-muted/30 p-4">
                            <h5 class="font-medium mb-3">Test this endpoint</h5>
                            <form onsubmit="testEndpoint(event, 'register')" class="space-y-3">
                                <input name="name" placeholder="Full Name" 
                                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" 
                                       required>
                                <input name="email" type="email" placeholder="Email" 
                                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" 
                                       required>
                                <input name="password" type="password" placeholder="Password" 
                                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" 
                                       required>
                                <input name="password_confirmation" type="password" placeholder="Confirm Password" 
                                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" 
                                       required>
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                    Send Request
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Example Response -->
                    <div>
                        <h4 class="text-lg font-semibold mb-3">Example Response</h4>
                        <pre class="text-xs"><code>{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "email_verified_at": null,
    "created_at": "2024-01-15T10:30:00.000000Z",
    "updated_at": "2024-01-15T10:30:00.000000Z"
  },
  "token": "1|abcdef123456..."
}</code></pre>
                    </div>
                </div>
                
                <!-- Response Container -->
                <div id="response-register" class="mt-6 hidden">
                    <h4 class="text-lg font-semibold mb-3">Response</h4>
                    <div class="response-container rounded border bg-muted p-4">
                        <pre id="response-content-register" class="text-sm"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Login -->
    <div class="mb-12">
        <h2 id="login" class="scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight mb-6">
            User Login
        </h2>
        
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm endpoint-card">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span class="method-badge method-post">POST</span>
                        <code class="text-lg font-mono">/api/login</code>
                    </div>
                    <span class="text-sm text-muted-foreground">Authentication: None</span>
                </div>
                
                <p class="text-muted-foreground mb-6">Authenticate user and receive API token</p>
                
                <div class="grid lg:grid-cols-2 gap-6">
                    <!-- Parameters -->
                    <div>
                        <h4 class="text-lg font-semibold mb-3">Request Parameters</h4>
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                <code class="text-sm">email</code>
                                <span class="text-xs text-muted-foreground">string, required</span>
                            </div>
                            <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                <code class="text-sm">password</code>
                                <span class="text-xs text-muted-foreground">string, required</span>
                            </div>
                        </div>
                        
                        <!-- Test Form -->
                        <div class="rounded-lg border border-border bg-muted/30 p-4">
                            <h5 class="font-medium mb-3">Test this endpoint</h5>
                            <form onsubmit="testEndpoint(event, 'login')" class="space-y-3">
                                <input name="email" type="email" placeholder="Email" 
                                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" 
                                       required>
                                <input name="password" type="password" placeholder="Password" 
                                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" 
                                       required>
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                    Send Request
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Example Response -->
                    <div>
                        <h4 class="text-lg font-semibold mb-3">Example Response</h4>
                        <pre class="text-xs"><code>{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "email_verified_at": null,
    "created_at": "2024-01-15T10:30:00.000000Z",
    "updated_at": "2024-01-15T10:30:00.000000Z"
  },
  "token": "1|abcdef123456..."
}</code></pre>
                    </div>
                </div>
                
                <!-- Response Container -->
                <div id="response-login" class="mt-6 hidden">
                    <h4 class="text-lg font-semibold mb-3">Response</h4>
                    <div class="response-container rounded border bg-muted p-4">
                        <pre id="response-content-login" class="text-sm"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Get User Profile -->
    <div class="mb-12">
        <h2 id="get-user" class="scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight mb-6">
            Get User Profile
        </h2>
        
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm endpoint-card">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span class="method-badge method-get">GET</span>
                        <code class="text-lg font-mono">/api/user</code>
                    </div>
                    <span class="text-sm text-muted-foreground">Authentication: Bearer Token</span>
                </div>
                
                <p class="text-muted-foreground mb-6">Retrieve the authenticated user's profile information</p>
                
                <div class="grid lg:grid-cols-2 gap-6">
                    <!-- Parameters -->
                    <div>
                        <h4 class="text-lg font-semibold mb-3">Request Parameters</h4>
                        <p class="text-sm text-muted-foreground mb-4">No parameters required</p>
                        
                        <!-- Test Form -->
                        <div class="rounded-lg border border-border bg-muted/30 p-4">
                            <h5 class="font-medium mb-3">Test this endpoint</h5>
                            <form onsubmit="testEndpoint(event, 'user')" class="space-y-3">
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                    Send Request
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Example Response -->
                    <div>
                        <h4 class="text-lg font-semibold mb-3">Example Response</h4>
                        <pre class="text-xs"><code>{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "email_verified_at": null,
  "created_at": "2024-01-15T10:30:00.000000Z",
  "updated_at": "2024-01-15T10:30:00.000000Z"
}</code></pre>
                    </div>
                </div>
                
                <!-- Response Container -->
                <div id="response-user" class="mt-6 hidden">
                    <h4 class="text-lg font-semibold mb-3">Response</h4>
                    <div class="response-container rounded border bg-muted p-4">
                        <pre id="response-content-user" class="text-sm"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Profile -->
    <div class="mb-12">
        <h2 id="update-profile" class="scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight mb-6">
            Update Profile
        </h2>
        
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm endpoint-card">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span class="method-badge method-put">PUT</span>
                        <code class="text-lg font-mono">/api/profile</code>
                    </div>
                    <span class="text-sm text-muted-foreground">Authentication: Bearer Token</span>
                </div>
                
                <p class="text-muted-foreground mb-6">Update the authenticated user's profile information</p>
                
                <div class="grid lg:grid-cols-2 gap-6">
                    <!-- Parameters -->
                    <div>
                        <h4 class="text-lg font-semibold mb-3">Request Parameters</h4>
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                <code class="text-sm">name</code>
                                <span class="text-xs text-muted-foreground">string, required</span>
                            </div>
                            <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                <code class="text-sm">email</code>
                                <span class="text-xs text-muted-foreground">string, required</span>
                            </div>
                        </div>
                        
                        <!-- Test Form -->
                        <div class="rounded-lg border border-border bg-muted/30 p-4">
                            <h5 class="font-medium mb-3">Test this endpoint</h5>
                            <form onsubmit="testEndpoint(event, 'profile')" class="space-y-3">
                                <input name="name" placeholder="Full Name" 
                                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" 
                                       required>
                                <input name="email" type="email" placeholder="Email" 
                                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" 
                                       required>
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                    Send Request
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Example Response -->
                    <div>
                        <h4 class="text-lg font-semibold mb-3">Example Response</h4>
                        <pre class="text-xs"><code>{
  "message": "Profile updated successfully",
  "user": {
    "id": 1,
    "name": "John Doe Updated",
    "email": "john.updated@example.com",
    "email_verified_at": null,
    "created_at": "2024-01-15T10:30:00.000000Z",
    "updated_at": "2024-01-15T11:45:00.000000Z"
  }
}</code></pre>
                    </div>
                </div>
                
                <!-- Response Container -->
                <div id="response-profile" class="mt-6 hidden">
                    <h4 class="text-lg font-semibold mb-3">Response</h4>
                    <div class="response-container rounded border bg-muted p-4">
                        <pre id="response-content-profile" class="text-sm"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Password -->
    <div class="mb-12">
        <h2 id="update-password" class="scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight mb-6">
            Update Password
        </h2>
        
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm endpoint-card">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span class="method-badge method-put">PUT</span>
                        <code class="text-lg font-mono">/api/password</code>
                    </div>
                    <span class="text-sm text-muted-foreground">Authentication: Bearer Token</span>
                </div>
                
                <p class="text-muted-foreground mb-6">Update the authenticated user's password</p>
                
                <div class="grid lg:grid-cols-2 gap-6">
                    <!-- Parameters -->
                    <div>
                        <h4 class="text-lg font-semibold mb-3">Request Parameters</h4>
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                <code class="text-sm">current_password</code>
                                <span class="text-xs text-muted-foreground">string, required</span>
                            </div>
                            <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                <code class="text-sm">password</code>
                                <span class="text-xs text-muted-foreground">string, required (min: 8)</span>
                            </div>
                            <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                <code class="text-sm">password_confirmation</code>
                                <span class="text-xs text-muted-foreground">string, required</span>
                            </div>
                        </div>
                        
                        <!-- Test Form -->
                        <div class="rounded-lg border border-border bg-muted/30 p-4">
                            <h5 class="font-medium mb-3">Test this endpoint</h5>
                            <form onsubmit="testEndpoint(event, 'password')" class="space-y-3">
                                <input name="current_password" type="password" placeholder="Current Password" 
                                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" 
                                       required>
                                <input name="password" type="password" placeholder="New Password" 
                                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" 
                                       required>
                                <input name="password_confirmation" type="password" placeholder="Confirm New Password" 
                                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" 
                                       required>
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                    Send Request
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Example Response -->
                    <div>
                        <h4 class="text-lg font-semibold mb-3">Example Response</h4>
                        <pre class="text-xs"><code>{
  "message": "Password updated successfully"
}</code></pre>
                    </div>
                </div>
                
                <!-- Response Container -->
                <div id="response-password" class="mt-6 hidden">
                    <h4 class="text-lg font-semibold mb-3">Response</h4>
                    <div class="response-container rounded border bg-muted p-4">
                        <pre id="response-content-password" class="text-sm"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout -->
    <div class="mb-12">
        <h2 id="logout" class="scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight mb-6">
            Logout
        </h2>
        
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm endpoint-card">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span class="method-badge method-post">POST</span>
                        <code class="text-lg font-mono">/api/logout</code>
                    </div>
                    <span class="text-sm text-muted-foreground">Authentication: Bearer Token</span>
                </div>
                
                <p class="text-muted-foreground mb-6">Revoke the current API token</p>
                
                <div class="grid lg:grid-cols-2 gap-6">
                    <!-- Parameters -->
                    <div>
                        <h4 class="text-lg font-semibold mb-3">Request Parameters</h4>
                        <p class="text-sm text-muted-foreground mb-4">No parameters required</p>
                        
                        <!-- Test Form -->
                        <div class="rounded-lg border border-border bg-muted/30 p-4">
                            <h5 class="font-medium mb-3">Test this endpoint</h5>
                            <form onsubmit="testEndpoint(event, 'logout')" class="space-y-3">
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-destructive text-destructive-foreground hover:bg-destructive/90 h-10 px-4 py-2">
                                    Send Request
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Example Response -->
                    <div>
                        <h4 class="text-lg font-semibold mb-3">Example Response</h4>
                        <pre class="text-xs"><code>{
  "message": "Logged out successfully"
}</code></pre>
                    </div>
                </div>
                
                <!-- Response Container -->
                <div id="response-logout" class="mt-6 hidden">
                    <h4 class="text-lg font-semibold mb-3">Response</h4>
                    <div class="response-container rounded border bg-muted p-4">
                        <pre id="response-content-logout" class="text-sm"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Section -->
    <div class="space-y-4 mb-8">
        <h2 id="delete-account" class="scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight mb-6">
            🗑️ Delete Account
        </h2>
        <p class="text-muted-foreground mb-4">
            Permanently delete your user account and all associated data. This action cannot be undone.
        </p>

        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <div class="flex items-center gap-2">
                    <span class="method-badge method-delete">DELETE</span>
                    <code class="text-sm font-mono bg-muted px-2 py-1 rounded">/api/account</code>
                </div>
                <p class="text-sm text-muted-foreground">Delete the authenticated user's account</p>
            </div>
            <div class="p-6 pt-0">
                <div class="grid w-full items-center gap-4">
                    <div class="flex flex-col space-y-1.5">
                        <label class="text-sm font-medium leading-none" for="delete-password">Current Password *</label>
                        <input 
                            type="password" 
                            id="delete-password" 
                            placeholder="Enter your current password"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                            required
                        >
                    </div>
                    <button 
                        onclick="testEndpoint('delete-account')" 
                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-destructive text-destructive-foreground hover:bg-destructive/90 h-10 px-4 py-2"
                    >
                        🗑️ Delete Account
                    </button>
                </div>
                
                <div class="mt-4">
                    <h4 class="text-sm font-semibold mb-2">Response</h4>
                    <pre id="delete-account-response" class="response-container text-sm bg-muted p-3 rounded overflow-x-auto">Click "Delete Account" to see the response</pre>
                </div>

                <div class="mt-4 p-4 bg-destructive/10 border border-destructive/20 rounded">
                    <p class="text-sm text-destructive font-medium">⚠️ Warning</p>
                    <p class="text-sm text-muted-foreground mt-1">
                        This action will permanently delete your account and all associated data including accounts, transactions, categories, and budgets. This cannot be undone.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Management Testing -->
    <div class="mb-12">
        <h2 id="account-management" class="scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight mb-6">
            💳 Account Management
        </h2>

        <!-- List Accounts -->
        <div class="mb-8">
            <h3 class="text-2xl font-semibold mb-4">List All Accounts</h3>
            
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm endpoint-card">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="method-badge method-get">GET</span>
                            <code class="text-lg font-mono">/api/accounts</code>
                        </div>
                        <span class="text-sm text-muted-foreground">Authentication: Bearer Token</span>
                    </div>
                    
                    <p class="text-muted-foreground mb-6">Retrieve all user accounts with transaction counts</p>
                    
                    <div class="grid lg:grid-cols-2 gap-6">
                        <!-- Test Form -->
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Test this endpoint</h4>
                            <div class="rounded-lg border border-border bg-muted/30 p-4">
                                <form onsubmit="testEndpoint(event, 'accounts-list')" class="space-y-3">
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                        Send GET Request
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Example Response -->
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Example Response</h4>
                            <pre class="text-xs"><code>{
  "success": true,
  "accounts": [
    {
      "id": 1,
      "name": "Main Checking",
      "type": "bank",
      "balance": "2500.00",
      "description": "Primary checking account",
      "transactions_count": 45,
      "created_at": "2024-01-15T10:30:00.000000Z"
    }
  ]
}</code></pre>
                        </div>
                    </div>
                    
                    <!-- Response Container -->
                    <div id="response-accounts-list" class="mt-6 hidden">
                        <h4 class="text-lg font-semibold mb-3">Response</h4>
                        <div class="response-container rounded border bg-muted p-4">
                            <pre id="response-content-accounts-list" class="text-sm"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Account -->
        <div class="mb-8">
            <h3 class="text-2xl font-semibold mb-4">Create New Account</h3>
            
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm endpoint-card">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="method-badge method-post">POST</span>
                            <code class="text-lg font-mono">/api/accounts</code>
                        </div>
                        <span class="text-sm text-muted-foreground">Authentication: Bearer Token</span>
                    </div>
                    
                    <p class="text-muted-foreground mb-6">Create a new financial account</p>
                    
                    <div class="grid lg:grid-cols-2 gap-6">
                        <!-- Parameters & Test Form -->
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Request Parameters</h4>
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">name</code>
                                    <span class="text-xs text-muted-foreground">string, required</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">type</code>
                                    <span class="text-xs text-muted-foreground">enum (cash, bank, credit_card)</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">balance</code>
                                    <span class="text-xs text-muted-foreground">decimal, required</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">description</code>
                                    <span class="text-xs text-muted-foreground">string, optional</span>
                                </div>
                            </div>
                            
                            <div class="rounded-lg border border-border bg-muted/30 p-4">
                                <h5 class="font-medium mb-3">Test this endpoint</h5>
                                <form onsubmit="testEndpoint(event, 'accounts-create')" class="space-y-3">
                                    <input name="name" placeholder="Account Name (e.g., Main Checking)" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" 
                                           required>
                                    <select name="type" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                        <option value="">Select Account Type</option>
                                        <option value="cash">Cash</option>
                                        <option value="bank">Bank Account</option>
                                        <option value="credit_card">Credit Card</option>
                                    </select>
                                    <input name="balance" type="number" step="0.01" placeholder="Initial Balance (e.g., 1500.00)" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" 
                                           required>
                                    <input name="description" placeholder="Optional description" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                        Send Request
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Example Response -->
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Example Response</h4>
                            <pre class="text-xs"><code>{
  "success": true,
  "message": "Account created successfully.",
  "account": {
    "id": 2,
    "name": "Savings Account",
    "type": "bank",
    "balance": "5000.00",
    "description": "Emergency fund account",
    "user_id": 1,
    "created_at": "2024-01-15T14:22:00.000000Z",
    "updated_at": "2024-01-15T14:22:00.000000Z"
  }
}</code></pre>
                        </div>
                    </div>
                    
                    <!-- Response Container -->
                    <div id="response-accounts-create" class="mt-6 hidden">
                        <h4 class="text-lg font-semibold mb-3">Response</h4>
                        <div class="response-container rounded border bg-muted p-4">
                            <pre id="response-content-accounts-create" class="text-sm"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Get Single Account -->
        <div class="mb-8">
            <h3 class="text-2xl font-semibold mb-4">Get Account with Transaction History</h3>
            
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm endpoint-card">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="method-badge method-get">GET</span>
                            <code class="text-lg font-mono">/api/accounts/{id}</code>
                        </div>
                        <span class="text-sm text-muted-foreground">Authentication: Bearer Token</span>
                    </div>
                    
                    <p class="text-muted-foreground mb-6">Get account details with paginated transaction history</p>
                    
                    <div class="grid lg:grid-cols-2 gap-6">
                        <!-- Test Form -->
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Test this endpoint</h4>
                            <div class="rounded-lg border border-border bg-muted/30 p-4">
                                <form onsubmit="testEndpoint(event, 'accounts-show')" class="space-y-3">
                                    <input name="account_id" type="number" placeholder="Account ID (e.g., 1)" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" 
                                           required>
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                        Send GET Request
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Example Response -->
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Example Response</h4>
                            <pre class="text-xs"><code>{
  "success": true,
  "account": {
    "id": 1,
    "name": "Main Checking",
    "type": "bank",
    "balance": "2500.00",
    "description": "Primary checking account",
    "transactions": {
      "data": [
        {
          "id": 15,
          "type": "expense",
          "amount": "75.50",
          "description": "Grocery shopping",
          "date": "2024-01-15",
          "category": {
            "id": 3,
            "name": "Food & Dining"
          }
        }
      ],
      "current_page": 1,
      "total": 45
    }
  }
}</code></pre>
                        </div>
                    </div>
                    
                    <!-- Response Container -->
                    <div id="response-accounts-show" class="mt-6 hidden">
                        <h4 class="text-lg font-semibold mb-3">Response</h4>
                        <div class="response-container rounded border bg-muted p-4">
                            <pre id="response-content-accounts-show" class="text-sm"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Account -->
        <div class="mb-8">
            <h3 class="text-2xl font-semibold mb-4">Update Account Details</h3>
            
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm endpoint-card">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="method-badge method-put">PUT</span>
                            <code class="text-lg font-mono">/api/accounts/{id}</code>
                        </div>
                        <span class="text-sm text-muted-foreground">Authentication: Bearer Token</span>
                    </div>
                    
                    <p class="text-muted-foreground mb-6">Update account information and balance</p>
                    
                    <div class="grid lg:grid-cols-2 gap-6">
                        <!-- Parameters & Test Form -->
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Request Parameters</h4>
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">name</code>
                                    <span class="text-xs text-muted-foreground">string, required</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">type</code>
                                    <span class="text-xs text-muted-foreground">enum (cash, bank, credit_card)</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">balance</code>
                                    <span class="text-xs text-muted-foreground">decimal, required</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">description</code>
                                    <span class="text-xs text-muted-foreground">string, optional</span>
                                </div>
                            </div>
                            
                            <div class="rounded-lg border border-border bg-muted/30 p-4">
                                <h5 class="font-medium mb-3">Test this endpoint</h5>
                                <form onsubmit="testEndpoint(event, 'accounts-update')" class="space-y-3">
                                    <input name="account_id" type="number" placeholder="Account ID to update" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" 
                                           required>
                                    <input name="name" placeholder="Updated Account Name" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" 
                                           required>
                                    <select name="type" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                        <option value="">Select Account Type</option>
                                        <option value="cash">Cash</option>
                                        <option value="bank">Bank Account</option>
                                        <option value="credit_card">Credit Card</option>
                                    </select>
                                    <input name="balance" type="number" step="0.01" placeholder="Updated Balance" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" 
                                           required>
                                    <input name="description" placeholder="Updated description" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                        Send Request
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Example Response -->
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Example Response</h4>
                            <pre class="text-xs"><code>{
  "success": true,
  "message": "Account updated successfully.",
  "account": {
    "id": 1,
    "name": "Updated Checking Account",
    "type": "bank",
    "balance": "3000.00",
    "description": "Updated primary account",
    "user_id": 1,
    "created_at": "2024-01-15T10:30:00.000000Z",
    "updated_at": "2024-01-15T15:45:00.000000Z"
  }
}</code></pre>
                        </div>
                    </div>
                    
                    <!-- Response Container -->
                    <div id="response-accounts-update" class="mt-6 hidden">
                        <h4 class="text-lg font-semibold mb-3">Response</h4>
                        <div class="response-container rounded border bg-muted p-4">
                            <pre id="response-content-accounts-update" class="text-sm"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Account -->
        <div class="mb-8">
            <h3 class="text-2xl font-semibold mb-4">Delete Account and Transactions</h3>
            
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm endpoint-card">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="method-badge method-delete">DELETE</span>
                            <code class="text-lg font-mono">/api/accounts/{id}</code>
                        </div>
                        <span class="text-sm text-muted-foreground">Authentication: Bearer Token</span>
                    </div>
                    
                    <p class="text-muted-foreground mb-6">Delete an account and all associated transactions</p>
                    
                    <div class="grid lg:grid-cols-2 gap-6">
                        <!-- Test Form -->
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Test this endpoint</h4>
                            <div class="rounded-lg border border-red-200 bg-red-50 dark:border-red-800 dark:bg-red-950/30 p-4">
                                <div class="flex items-start space-x-3 mb-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-600 dark:text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-red-900 dark:text-red-100">Warning</p>
                                        <p class="text-sm text-red-700 dark:text-red-300">This action cannot be undone. All transactions will be permanently deleted.</p>
                                    </div>
                                </div>
                                <form onsubmit="testEndpoint(event, 'accounts-delete')" class="space-y-3">
                                    <input name="account_id" type="number" placeholder="Account ID to delete" 
                                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" 
                                           required>
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-destructive text-destructive-foreground hover:bg-destructive/90 h-10 px-4 py-2">
                                        Delete Account
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Example Response -->
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Example Response</h4>
                            <pre class="text-xs"><code>{
  "success": true,
  "message": "Account and all associated transactions deleted successfully."
}</code></pre>
                        </div>
                    </div>
                    
                    <!-- Response Container -->
                    <div id="response-accounts-delete" class="mt-6 hidden">
                        <h4 class="text-lg font-semibold mb-3">Response</h4>
                        <div class="response-container rounded border bg-muted p-4">
                            <pre id="response-content-accounts-delete" class="text-sm"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Management Testing -->
    <div class="mb-12">
        <h2 id="category-management" class="scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight mb-6">
            🏷️ Category Management
        </h2>

        <!-- List Categories -->
        <div class="mb-8">
            <h3 class="text-2xl font-semibold mb-4">List All Categories</h3>
            
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm endpoint-card">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="method-badge method-get">GET</span>
                            <code class="text-lg font-mono">/api/categories</code>
                        </div>
                        <span class="text-sm text-muted-foreground">Authentication: Bearer Token</span>
                    </div>
                    
                    <p class="text-muted-foreground mb-6">Retrieve all user categories with transaction and budget statistics</p>
                    
                    <div class="grid lg:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Test this endpoint</h4>
                            <div class="rounded-lg border border-border bg-muted/30 p-4">
                                <form onsubmit="testEndpoint(event, 'categories-list')" class="space-y-3">
                                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                        Send GET Request
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Example Response</h4>
                            <pre class="text-xs"><code>{
  "success": true,
  "categories": [
    {
      "id": 1,
      "name": "Food & Dining",
      "type": "expense",
      "color": "#ef4444",
      "description": "Meals and restaurants",
      "transactions_count": 25,
      "budgets_count": 2,
      "created_at": "2024-01-15T10:30:00.000000Z"
    }
  ]
}</code></pre>
                        </div>
                    </div>
                    
                    <div id="response-categories-list" class="mt-6 hidden">
                        <h4 class="text-lg font-semibold mb-3">Response</h4>
                        <div class="response-container rounded border bg-muted p-4">
                            <pre id="response-content-categories-list" class="text-sm"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Category -->
        <div class="mb-8">
            <h3 class="text-2xl font-semibold mb-4">Create New Category</h3>
            
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm endpoint-card">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="method-badge method-post">POST</span>
                            <code class="text-lg font-mono">/api/categories</code>
                        </div>
                        <span class="text-sm text-muted-foreground">Authentication: Bearer Token</span>
                    </div>
                    
                    <p class="text-muted-foreground mb-6">Create a new transaction category with color and type</p>
                    
                    <div class="grid lg:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Request Parameters</h4>
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">name</code>
                                    <span class="text-xs text-muted-foreground">string, required</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">type</code>
                                    <span class="text-xs text-muted-foreground">enum (income, expense)</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">color</code>
                                    <span class="text-xs text-muted-foreground">hex color, required</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">description</code>
                                    <span class="text-xs text-muted-foreground">string, optional</span>
                                </div>
                            </div>
                            
                            <div class="rounded-lg border border-border bg-muted/30 p-4">
                                <h5 class="font-medium mb-3">Test this endpoint</h5>
                                <form onsubmit="testEndpoint(event, 'categories-create')" class="space-y-3">
                                    <input name="name" placeholder="Category Name (e.g., Groceries)" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                    <select name="type" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                        <option value="">Select Category Type</option>
                                        <option value="income">Income</option>
                                        <option value="expense">Expense</option>
                                    </select>
                                    <input name="color" type="color" value="#ef4444" class="w-full h-10 border border-input rounded-md cursor-pointer">
                                    <input name="description" placeholder="Optional description" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                        Send Request
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Example Response</h4>
                            <pre class="text-xs"><code>{
  "success": true,
  "message": "Category created successfully.",
  "category": {
    "id": 5,
    "name": "Entertainment",
    "type": "expense",
    "color": "#8b5cf6",
    "description": "Movies, games, fun activities",
    "user_id": 1,
    "created_at": "2024-01-15T14:22:00.000000Z"
  }
}</code></pre>
                        </div>
                    </div>
                    
                    <div id="response-categories-create" class="mt-6 hidden">
                        <h4 class="text-lg font-semibold mb-3">Response</h4>
                        <div class="response-container rounded border bg-muted p-4">
                            <pre id="response-content-categories-create" class="text-sm"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Get Single Category -->
        <div class="mb-8">
            <h3 class="text-2xl font-semibold mb-4">Get Category with Analytics</h3>
            
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm endpoint-card">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="method-badge method-get">GET</span>
                            <code class="text-lg font-mono">/api/categories/{id}</code>
                        </div>
                        <span class="text-sm text-muted-foreground">Authentication: Bearer Token</span>
                    </div>
                    
                    <p class="text-muted-foreground mb-6">Get category details with recent transactions and spending analytics</p>
                    
                    <div class="grid lg:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Test this endpoint</h4>
                            <div class="rounded-lg border border-border bg-muted/30 p-4">
                                <form onsubmit="testEndpoint(event, 'categories-show')" class="space-y-3">
                                    <input name="category_id" type="number" placeholder="Category ID (e.g., 1)" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                        Send GET Request
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Example Response</h4>
                            <pre class="text-xs"><code>{
  "success": true,
  "category": {
    "id": 1,
    "name": "Food & Dining",
    "type": "expense",
    "color": "#ef4444",
    "transactions_count": 25
  },
  "recent_transactions": [
    {
      "id": 15,
      "amount": "45.50",
      "description": "Lunch at cafe",
      "date": "2024-01-15",
      "account": {
        "name": "Main Checking"
      }
    }
  ],
  "total_amount": 1250.75,
  "active_budgets": 1
}</code></pre>
                        </div>
                    </div>
                    
                    <div id="response-categories-show" class="mt-6 hidden">
                        <h4 class="text-lg font-semibold mb-3">Response</h4>
                        <div class="response-container rounded border bg-muted p-4">
                            <pre id="response-content-categories-show" class="text-sm"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Management Testing -->
    <div class="mb-12">
        <h2 id="transaction-management" class="scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight mb-6">
            💸 Transaction Management
        </h2>

        <!-- List Transactions -->
        <div class="mb-8">
            <h3 class="text-2xl font-semibold mb-4">List All Transactions</h3>
            
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm endpoint-card">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="method-badge method-get">GET</span>
                            <code class="text-lg font-mono">/api/transactions</code>
                        </div>
                        <span class="text-sm text-muted-foreground">Authentication: Bearer Token</span>
                    </div>
                    
                    <p class="text-muted-foreground mb-6">Retrieve paginated transactions with account and category relationships</p>
                    
                    <div class="grid lg:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Test this endpoint</h4>
                            <div class="rounded-lg border border-border bg-muted/30 p-4">
                                <form onsubmit="testEndpoint(event, 'transactions-list')" class="space-y-3">
                                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                        Send GET Request
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Example Response</h4>
                            <pre class="text-xs"><code>{
  "success": true,
  "transactions": {
    "data": [
      {
        "id": 1,
        "type": "expense",
        "amount": "75.50",
        "description": "Grocery shopping",
        "date": "2024-01-15",
        "account": {
          "id": 1,
          "name": "Main Checking"
        },
        "category": {
          "id": 3,
          "name": "Food & Dining",
          "color": "#ef4444"
        }
      }
    ],
    "current_page": 1,
    "total": 156
  }
}</code></pre>
                        </div>
                    </div>
                    
                    <div id="response-transactions-list" class="mt-6 hidden">
                        <h4 class="text-lg font-semibold mb-3">Response</h4>
                        <div class="response-container rounded border bg-muted p-4">
                            <pre id="response-content-transactions-list" class="text-sm"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Transaction -->
        <div class="mb-8">
            <h3 class="text-2xl font-semibold mb-4">Create New Transaction</h3>
            
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm endpoint-card">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="method-badge method-post">POST</span>
                            <code class="text-lg font-mono">/api/transactions</code>
                        </div>
                        <span class="text-sm text-muted-foreground">Authentication: Bearer Token</span>
                    </div>
                    
                    <p class="text-muted-foreground mb-6">Create a new transaction with account and category validation</p>
                    
                    <div class="grid lg:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Request Parameters</h4>
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">type</code>
                                    <span class="text-xs text-muted-foreground">enum (income, expense)</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">amount</code>
                                    <span class="text-xs text-muted-foreground">decimal, required</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">account_id</code>
                                    <span class="text-xs text-muted-foreground">integer, required</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">category_id</code>
                                    <span class="text-xs text-muted-foreground">integer, required</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">date</code>
                                    <span class="text-xs text-muted-foreground">date, required</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">description</code>
                                    <span class="text-xs text-muted-foreground">string, required</span>
                                </div>
                            </div>
                            
                            <div class="rounded-lg border border-border bg-muted/30 p-4">
                                <h5 class="font-medium mb-3">Test this endpoint</h5>
                                <form onsubmit="testEndpoint(event, 'transactions-create')" class="space-y-3">
                                    <select name="type" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                        <option value="">Select Transaction Type</option>
                                        <option value="income">Income</option>
                                        <option value="expense">Expense</option>
                                    </select>
                                    <input name="amount" type="number" step="0.01" placeholder="Amount (e.g., 50.00)" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                    <input name="account_id" type="number" placeholder="Account ID" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                    <input name="category_id" type="number" placeholder="Category ID" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                    <input name="date" type="date" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                    <input name="description" placeholder="Transaction description" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                        Send Request
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Example Response</h4>
                            <pre class="text-xs"><code>{
  "success": true,
  "message": "Transaction created successfully.",
  "transaction": {
    "id": 25,
    "type": "expense",
    "amount": "45.99",
    "description": "Coffee and pastry",
    "date": "2024-01-15",
    "account_id": 1,
    "category_id": 3,
    "user_id": 1,
    "created_at": "2024-01-15T14:22:00.000000Z"
  }
}</code></pre>
                        </div>
                    </div>
                    
                    <div id="response-transactions-create" class="mt-6 hidden">
                        <h4 class="text-lg font-semibold mb-3">Response</h4>
                        <div class="response-container rounded border bg-muted p-4">
                            <pre id="response-content-transactions-create" class="text-sm"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Budget Management Testing -->
    <div class="mb-12">
        <h2 id="budget-management" class="scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight mb-6">
            📊 Budget Management
        </h2>

        <!-- List Budgets -->
        <div class="mb-8">
            <h3 class="text-2xl font-semibold mb-4">List All Budgets</h3>
            
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm endpoint-card">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="method-badge method-get">GET</span>
                            <code class="text-lg font-mono">/api/budgets</code>
                        </div>
                        <span class="text-sm text-muted-foreground">Authentication: Bearer Token</span>
                    </div>
                    
                    <p class="text-muted-foreground mb-6">Retrieve all budgets with progress tracking and category details</p>
                    
                    <div class="grid lg:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Test this endpoint</h4>
                            <div class="rounded-lg border border-border bg-muted/30 p-4">
                                <form onsubmit="testEndpoint(event, 'budgets-list')" class="space-y-3">
                                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                        Send GET Request
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Example Response</h4>
                            <pre class="text-xs"><code>{
  "success": true,
  "budgets": {
    "data": [
      {
        "id": 1,
        "name": "Monthly Food Budget",
        "amount": "600.00",
        "start_date": "2024-01-01",
        "end_date": "2024-01-31",
        "description": "Monthly food expenses",
        "category": {
          "id": 3,
          "name": "Food & Dining",
          "color": "#ef4444"
        },
        "spent_amount": "425.75",
        "remaining_amount": "174.25",
        "percentage_used": 70.96
      }
    ],
    "current_page": 1,
    "total": 8
  }
}</code></pre>
                        </div>
                    </div>
                    
                    <div id="response-budgets-list" class="mt-6 hidden">
                        <h4 class="text-lg font-semibold mb-3">Response</h4>
                        <div class="response-container rounded border bg-muted p-4">
                            <pre id="response-content-budgets-list" class="text-sm"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Budget -->
        <div id="budget-create" class="mb-8">
            <h3 class="text-2xl font-semibold mb-4">Create New Budget</h3>
            
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm endpoint-card">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="method-badge method-post">POST</span>
                            <code class="text-lg font-mono">/api/budgets</code>
                        </div>
                        <span class="text-sm text-muted-foreground">Authentication: Bearer Token</span>
                    </div>
                    
                    <p class="text-muted-foreground mb-6">Create a new budget with overlap validation and spending limits</p>
                    
                    <div class="grid lg:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Request Parameters</h4>
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">name</code>
                                    <span class="text-xs text-muted-foreground">string, required</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">amount</code>
                                    <span class="text-xs text-muted-foreground">decimal, required</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">category_id</code>
                                    <span class="text-xs text-muted-foreground">integer, required</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">start_date</code>
                                    <span class="text-xs text-muted-foreground">date, required</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">end_date</code>
                                    <span class="text-xs text-muted-foreground">date, required</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">description</code>
                                    <span class="text-xs text-muted-foreground">string, optional</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">is_limiter</code>
                                    <span class="text-xs text-muted-foreground">boolean, optional</span>
                                </div>
                            </div>
                            
                            <div class="rounded-lg border border-border bg-muted/30 p-4">
                                <h5 class="font-medium mb-3">Test this endpoint</h5>
                                <form onsubmit="testEndpoint(event, 'budgets-create')" class="space-y-3">
                                    <input name="name" placeholder="Budget Name (e.g., Monthly Entertainment)" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                    <input name="amount" type="number" step="0.01" placeholder="Budget Amount (e.g., 300.00)" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                    <input name="category_id" type="number" placeholder="Category ID (expense categories only)" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                    <input name="start_date" type="date" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                    <input name="end_date" type="date" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                    <input name="description" placeholder="Budget description (optional)" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                                    <div class="flex items-center space-x-2">
                                        <input name="is_limiter" type="checkbox" id="is_limiter_create" class="rounded border-input">
                                        <label for="is_limiter_create" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Hard limit (prevent overspending)</label>
                                    </div>
                                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                        Send Request
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Example Response</h4>
                            <pre class="text-xs"><code>{
  "success": true,
  "message": "Budget created successfully.",
  "budget": {
    "id": 3,
    "name": "Q1 Transportation",
    "amount": "400.00",
    "start_date": "2024-01-01",
    "end_date": "2024-03-31",
    "description": "Quarterly transport budget",
    "is_limiter": false,
    "category_id": 8,
    "user_id": 1,
    "created_at": "2024-01-15T14:22:00.000000Z"
  }
}</code></pre>
                        </div>
                    </div>
                    
                    <div id="response-budgets-create" class="mt-6 hidden">
                        <h4 class="text-lg font-semibold mb-3">Response</h4>
                        <div class="response-container rounded border bg-muted p-4">
                            <pre id="response-content-budgets-create" class="text-sm"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Budget -->
        <div id="budget-update" class="mb-8">
            <h3 class="text-2xl font-semibold mb-4">Update Budget</h3>
            
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm endpoint-card">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="method-badge method-put">PUT</span>
                            <code class="text-lg font-mono">/api/budgets/{id}</code>
                        </div>
                        <span class="text-sm text-muted-foreground">Authentication: Bearer Token</span>
                    </div>
                    
                    <p class="text-muted-foreground mb-6">Update an existing budget with overlap validation and parameter changes</p>
                    
                    <div class="grid lg:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Request Parameters</h4>
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">name</code>
                                    <span class="text-xs text-muted-foreground">string, required</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">amount</code>
                                    <span class="text-xs text-muted-foreground">decimal, required</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">category_id</code>
                                    <span class="text-xs text-muted-foreground">integer, required</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">start_date</code>
                                    <span class="text-xs text-muted-foreground">date, required</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">end_date</code>
                                    <span class="text-xs text-muted-foreground">date, required</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">description</code>
                                    <span class="text-xs text-muted-foreground">string, optional</span>
                                </div>
                                <div class="flex justify-between items-center py-2 px-3 bg-muted/50 rounded">
                                    <code class="text-sm">is_limiter</code>
                                    <span class="text-xs text-muted-foreground">boolean, optional</span>
                                </div>
                            </div>
                            
                            <div class="rounded-lg border border-border bg-muted/30 p-4">
                                <h5 class="font-medium mb-3">Test this endpoint</h5>
                                <form onsubmit="testEndpoint(event, 'budgets-update')" class="space-y-3">
                                    <input name="budget_id" type="number" placeholder="Budget ID to update" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                    <input name="name" placeholder="Budget Name (e.g., Updated Entertainment Budget)" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                    <input name="amount" type="number" step="0.01" placeholder="Budget Amount (e.g., 450.00)" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                    <input name="category_id" type="number" placeholder="Category ID (expense categories only)" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                    <input name="start_date" type="date" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                    <input name="end_date" type="date" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                    <input name="description" placeholder="Budget description (optional)" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                                    <div class="flex items-center space-x-2">
                                        <input name="is_limiter" type="checkbox" id="is_limiter" class="rounded border-input">
                                        <label for="is_limiter" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Hard limit (prevent overspending)</label>
                                    </div>
                                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                        Send PUT Request
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Example Response</h4>
                            <pre class="text-xs"><code>{
  "success": true,
  "message": "Budget updated successfully.",
  "budget": {
    "id": 3,
    "name": "Updated Entertainment Budget",
    "amount": "450.00",
    "start_date": "2024-01-01",
    "end_date": "2024-01-31",
    "description": "Updated monthly entertainment budget",
    "is_limiter": false,
    "category_id": 5,
    "user_id": 1,
    "created_at": "2024-01-15T14:22:00.000000Z",
    "updated_at": "2024-01-20T16:45:00.000000Z"
  }
}</code></pre>
                        </div>
                    </div>
                    
                    <div id="response-budgets-update" class="mt-6 hidden">
                        <h4 class="text-lg font-semibold mb-3">Response</h4>
                        <div class="response-container rounded border bg-muted p-4">
                            <pre id="response-content-budgets-update" class="text-sm"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Budget -->
        <div id="budget-delete" class="mb-8">
            <h3 class="text-2xl font-semibold mb-4">Delete Budget</h3>
            
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm endpoint-card">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="method-badge method-delete">DELETE</span>
                            <code class="text-lg font-mono">/api/budgets/{id}</code>
                        </div>
                        <span class="text-sm text-muted-foreground">Authentication: Bearer Token</span>
                    </div>
                    
                    <p class="text-muted-foreground mb-6">Permanently delete a budget and all its associated data</p>
                    
                    <div class="grid lg:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Test this endpoint</h4>
                            
                            <div class="rounded-lg border border-red-200 bg-red-50 dark:border-red-800 dark:bg-red-950/30 p-4 mb-4">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-600 dark:text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-red-900 dark:text-red-100">
                                            Warning: Permanent Action
                                        </p>
                                        <p class="text-sm text-red-700 dark:text-red-300 mt-1">
                                            This action cannot be undone. The budget will be permanently deleted from your account.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="rounded-lg border border-border bg-muted/30 p-4">
                                <h5 class="font-medium mb-3">Test this endpoint</h5>
                                <form onsubmit="testEndpoint(event, 'budgets-delete')" class="space-y-3">
                                    <input name="budget_id" type="number" placeholder="Budget ID to delete" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" id="confirm-delete-budget" required class="rounded border-input">
                                        <label for="confirm-delete-budget" class="text-sm font-medium leading-none text-red-600 dark:text-red-400">I understand this action cannot be undone</label>
                                    </div>
                                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-red-600 text-white hover:bg-red-700 h-10 px-4 py-2">
                                        Delete Budget
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Example Response</h4>
                            <pre class="text-xs"><code>{
  "success": true,
  "message": "Budget deleted successfully."
}</code></pre>
                        </div>
                    </div>
                    
                    <div id="response-budgets-delete" class="mt-6 hidden">
                        <h4 class="text-lg font-semibold mb-3">Response</h4>
                        <div class="response-container rounded border bg-muted p-4">
                            <pre id="response-content-budgets-delete" class="text-sm"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testing Guide -->
    <div class="mb-12">
        <h2 id="testing-guide" class="scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight mb-6">
            🧪 Testing Guide
        </h2>
        
        <div class="space-y-6">
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">How to Test the API</h3>
                    <div class="prose prose-sm max-w-none dark:prose-invert">
                        <ol class="list-decimal list-inside space-y-3">
                            <li><strong>Create a Token:</strong> Use the "Create New API Token" form in the Authentication section to generate a token.</li>
                            <li><strong>Set the Token:</strong> Copy the generated token and paste it into the "Set Token for Testing" field.</li>
                            <li><strong>Test Endpoints:</strong> Use the test forms in each endpoint section to send requests.</li>
                            <li><strong>View Responses:</strong> The API responses will appear below each test form.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="rounded-lg border border-amber-200 bg-amber-50 dark:border-amber-800 dark:bg-amber-950/30 p-4">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-amber-600 dark:text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-amber-900 dark:text-amber-100">
                            Important Notes
                        </p>
                        <p class="text-sm text-amber-700 dark:text-amber-300 mt-1">
                            Tokens are valid until you log out or they're explicitly revoked. Keep your tokens secure and don't share them publicly.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Code Examples -->
    <div class="mb-12">
        <h2 id="examples" class="scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight mb-6">
            Code Examples
        </h2>
        
        <div class="space-y-6">
            <!-- JavaScript Example -->
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">JavaScript (Fetch API)</h3>
                    <pre class="text-sm"><code>// Get user profile
const response = await fetch('/api/user', {
    method: 'GET',
    headers: {
        'Authorization': 'Bearer YOUR_TOKEN_HERE',
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
});

const user = await response.json();
console.log(user);</code></pre>
                </div>
            </div>

            <!-- cURL Example -->
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">cURL</h3>
                    <pre class="text-sm"><code># Update user profile
curl -X PUT {{ url('/api/profile') }} \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe Updated",
    "email": "john.updated@example.com"
  }'</code></pre>
                </div>
            </div>
        </div>
    </div>

    <!-- Future Development Section -->
    <div class="mb-12">
        <h2 id="future-development" class="scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight mb-6">
            🚧 Future Development
        </h2>
        
        <div class="rounded-lg border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-950/30 text-card-foreground shadow-sm mb-6">
            <div class="p-6">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-amber-900 dark:text-amber-100 mb-2">Planned Features & Enhancements</h3>
                        <p class="text-sm text-amber-800 dark:text-amber-200">
                            The following endpoints and features are planned for future releases. These will enhance the analytics and reporting capabilities of the Budget Tracker API.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Advanced Analytics -->
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-4 flex items-center gap-2">
                        <span class="text-2xl">📊</span>
                        Advanced Analytics Endpoints
                    </h3>
                    <div class="space-y-3 ml-8">
                        <div class="flex items-start gap-3">
                            <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs px-2 py-1 rounded font-mono">GET</span>
                            <div>
                                <code class="text-sm font-semibold">/api/analytics/income-vs-expense</code>
                                <p class="text-sm text-muted-foreground mt-1">Custom date range comparison with visual data (start={date}&end={date})</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs px-2 py-1 rounded font-mono">GET</span>
                            <div>
                                <code class="text-sm font-semibold">/api/analytics/account-history/{id}</code>
                                <p class="text-sm text-muted-foreground mt-1">Account balance history over time with trend analysis</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs px-2 py-1 rounded font-mono">GET</span>
                            <div>
                                <code class="text-sm font-semibold">/api/analytics/savings-rate</code>
                                <p class="text-sm text-muted-foreground mt-1">Calculate savings rate and financial health metrics</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs px-2 py-1 rounded font-mono">GET</span>
                            <div>
                                <code class="text-sm font-semibold">/api/analytics/forecast</code>
                                <p class="text-sm text-muted-foreground mt-1">AI-powered spending forecast and predictions</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Export -->
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-4 flex items-center gap-2">
                        <span class="text-2xl">📥</span>
                        Data Export & Reporting
                    </h3>
                    <div class="space-y-3 ml-8">
                        <div class="flex items-start gap-3">
                            <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs px-2 py-1 rounded font-mono">GET</span>
                            <div>
                                <code class="text-sm font-semibold">/api/export/transactions</code>
                                <p class="text-sm text-muted-foreground mt-1">Export transactions to CSV, Excel, or PDF formats</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs px-2 py-1 rounded font-mono">GET</span>
                            <div>
                                <code class="text-sm font-semibold">/api/reports/monthly-summary</code>
                                <p class="text-sm text-muted-foreground mt-1">Generate comprehensive monthly financial reports</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs px-2 py-1 rounded font-mono">GET</span>
                            <div>
                                <code class="text-sm font-semibold">/api/reports/tax-summary</code>
                                <p class="text-sm text-muted-foreground mt-1">Tax-ready report with categorized deductions</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recurring Transactions -->
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-4 flex items-center gap-2">
                        <span class="text-2xl">🔄</span>
                        Recurring Transactions
                    </h3>
                    <div class="space-y-3 ml-8">
                        <div class="flex items-start gap-3">
                            <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 text-xs px-2 py-1 rounded font-mono">POST</span>
                            <div>
                                <code class="text-sm font-semibold">/api/recurring-transactions</code>
                                <p class="text-sm text-muted-foreground mt-1">Create recurring/scheduled transactions (daily, weekly, monthly)</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs px-2 py-1 rounded font-mono">GET</span>
                            <div>
                                <code class="text-sm font-semibold">/api/recurring-transactions</code>
                                <p class="text-sm text-muted-foreground mt-1">List all recurring transaction schedules</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 text-xs px-2 py-1 rounded font-mono">PUT</span>
                            <div>
                                <code class="text-sm font-semibold">/api/recurring-transactions/{id}</code>
                                <p class="text-sm text-muted-foreground mt-1">Update or pause recurring schedules</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Goals -->
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-4 flex items-center gap-2">
                        <span class="text-2xl">🎯</span>
                        Financial Goals & Savings
                    </h3>
                    <div class="space-y-3 ml-8">
                        <div class="flex items-start gap-3">
                            <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 text-xs px-2 py-1 rounded font-mono">POST</span>
                            <div>
                                <code class="text-sm font-semibold">/api/goals</code>
                                <p class="text-sm text-muted-foreground mt-1">Create savings goals with target amounts and deadlines</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs px-2 py-1 rounded font-mono">GET</span>
                            <div>
                                <code class="text-sm font-semibold">/api/goals/progress</code>
                                <p class="text-sm text-muted-foreground mt-1">Track progress towards financial goals</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications & Alerts -->
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-4 flex items-center gap-2">
                        <span class="text-2xl">🔔</span>
                        Notifications & Alerts
                    </h3>
                    <div class="space-y-3 ml-8">
                        <div class="flex items-start gap-3">
                            <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs px-2 py-1 rounded font-mono">GET</span>
                            <div>
                                <code class="text-sm font-semibold">/api/notifications</code>
                                <p class="text-sm text-muted-foreground mt-1">Get budget alerts, bill reminders, and anomaly detection</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 text-xs px-2 py-1 rounded font-mono">POST</span>
                            <div>
                                <code class="text-sm font-semibold">/api/notifications/preferences</code>
                                <p class="text-sm text-muted-foreground mt-1">Configure notification settings and alert thresholds</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Multi-Currency Support -->
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-4 flex items-center gap-2">
                        <span class="text-2xl">💱</span>
                        Multi-Currency & Exchange Rates
                    </h3>
                    <div class="space-y-3 ml-8">
                        <div class="flex items-start gap-3">
                            <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs px-2 py-1 rounded font-mono">GET</span>
                            <div>
                                <code class="text-sm font-semibold">/api/exchange-rates</code>
                                <p class="text-sm text-muted-foreground mt-1">Real-time currency conversion and historical rates</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs px-2 py-1 rounded font-mono">GET</span>
                            <div>
                                <code class="text-sm font-semibold">/api/dashboard/consolidated</code>
                                <p class="text-sm text-muted-foreground mt-1">View all accounts in a single base currency</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Webhooks -->
            <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-4 flex items-center gap-2">
                        <span class="text-2xl">🔗</span>
                        Webhooks & Integrations
                    </h3>
                    <div class="space-y-3 ml-8">
                        <div class="flex items-start gap-3">
                            <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 text-xs px-2 py-1 rounded font-mono">POST</span>
                            <div>
                                <code class="text-sm font-semibold">/api/webhooks</code>
                                <p class="text-sm text-muted-foreground mt-1">Register webhooks for transaction events and budget alerts</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs px-2 py-1 rounded font-mono">GET</span>
                            <div>
                                <code class="text-sm font-semibold">/api/integrations/bank-import</code>
                                <p class="text-sm text-muted-foreground mt-1">Import transactions from bank statements (OFX, QFX, CSV)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="rounded-lg border border-purple-200 dark:border-purple-800 bg-purple-50 dark:bg-purple-950/30 text-card-foreground shadow-sm">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-purple-900 dark:text-purple-100 mb-3">📅 Development Timeline</h3>
                    <div class="space-y-2 text-sm text-purple-800 dark:text-purple-200">
                        <p><strong>v2.0 (Q1 2026):</strong> Advanced Analytics, Data Export, Recurring Transactions</p>
                        <p><strong>v2.1 (Q2 2026):</strong> Financial Goals, Notifications, Multi-Currency</p>
                        <p><strong>v2.2 (Q3 2026):</strong> Webhooks, Bank Imports, AI Forecasting</p>
                    </div>
                    <p class="text-xs text-purple-700 dark:text-purple-300 mt-4">
                        <em>Timeline subject to change. Follow our GitHub repository for the latest updates.</em>
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    let globalToken = '';
    
    // Token creation
    document.getElementById('create-token-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const tokenName = document.getElementById('token-name').value;
        
        try {
            const response = await fetch('/api/tokens', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ name: tokenName })
            });
            
            const result = await response.json();
            
            if (response.ok) {
                document.getElementById('new-token-value').textContent = result.token;
                document.getElementById('new-token-display').classList.remove('hidden');
                document.getElementById('token-name').value = '';
            } else {
                alert('Error creating token: ' + (result.message || 'Unknown error'));
            }
        } catch (error) {
            alert('Network error: ' + error.message);
        }
    });
    
    function copyToken() {
        const tokenValue = document.getElementById('new-token-value').textContent;
        navigator.clipboard.writeText(tokenValue).then(() => {
            // Optional: Show a temporary success message
            const button = event.target;
            const originalText = button.textContent;
            button.textContent = 'Copied!';
            setTimeout(() => {
                button.textContent = originalText;
            }, 2000);
        });
    }
    
    function setGlobalToken() {
        globalToken = document.getElementById('globalToken').value;
        const status = document.getElementById('tokenStatus');
        if (globalToken) {
            status.innerHTML = '<span class="text-green-600 dark:text-green-400">✓ Token set successfully</span>';
        } else {
            status.innerHTML = '<span class="text-red-600 dark:text-red-400">✗ Please enter a token</span>';
        }
    }
    
    function clearGlobalToken() {
        globalToken = '';
        document.getElementById('globalToken').value = '';
        document.getElementById('tokenStatus').innerHTML = '<span class="text-muted-foreground">Token cleared</span>';
    }
    
    async function testEndpoint(event, endpoint) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        
        const endpoints = {
            'register': { url: '/api/register', method: 'POST' },
            'login': { url: '/api/login', method: 'POST' },
            'user': { url: '/api/user', method: 'GET' },
            'profile': { url: '/api/profile', method: 'PUT' },
            'password': { url: '/api/password', method: 'PUT' },
            'logout': { url: '/api/logout', method: 'POST' },
            'delete-account': { url: '/api/account', method: 'DELETE' },
            'accounts-list': { url: '/api/accounts', method: 'GET' },
            'accounts-create': { url: '/api/accounts', method: 'POST' },
            'accounts-show': { url: '/api/accounts/{id}', method: 'GET' },
            'accounts-update': { url: '/api/accounts/{id}', method: 'PUT' },
            'accounts-delete': { url: '/api/accounts/{id}', method: 'DELETE' },
            'categories-list': { url: '/api/categories', method: 'GET' },
            'categories-create': { url: '/api/categories', method: 'POST' },
            'categories-show': { url: '/api/categories/{id}', method: 'GET' },
            'transactions-list': { url: '/api/transactions', method: 'GET' },
            'transactions-create': { url: '/api/transactions', method: 'POST' },
            'budgets-list': { url: '/api/budgets', method: 'GET' },
            'budgets-create': { url: '/api/budgets', method: 'POST' },
            'budgets-update': { url: '/api/budgets/{id}', method: 'PUT' },
            'budgets-delete': { url: '/api/budgets/{id}', method: 'DELETE' }
        };
        
        const config = endpoints[endpoint];
        if (!config) return;
        
        // Handle ID replacement in URLs
        let url = config.url;
        if (url.includes('{id}')) {
            if (data.account_id) {
                url = url.replace('{id}', data.account_id);
                delete data.account_id; // Remove from request body
            } else if (data.category_id) {
                url = url.replace('{id}', data.category_id);
                delete data.category_id; // Remove from request body
            } else if (data.transaction_id) {
                url = url.replace('{id}', data.transaction_id);
                delete data.transaction_id; // Remove from request body
            } else if (data.budget_id) {
                url = url.replace('{id}', data.budget_id);
                delete data.budget_id; // Remove from request body
            }
        }
        
        const headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        };
        
        if (globalToken && endpoint !== 'register' && endpoint !== 'login') {
            headers['Authorization'] = 'Bearer ' + globalToken;
        }
        
        try {
            const response = await fetch(url, {
                method: config.method,
                headers: headers,
                body: config.method !== 'GET' && config.method !== 'DELETE' ? JSON.stringify(data) : undefined
            });
            
            const result = await response.json();
            
            // Display response
            const responseContainer = document.getElementById(`response-${endpoint}`);
            const responseContent = document.getElementById(`response-content-${endpoint}`);
            
            responseContent.textContent = JSON.stringify(result, null, 2);
            responseContainer.classList.remove('hidden');
            
            // Auto-set token if this is a login/register request
            if ((endpoint === 'login' || endpoint === 'register') && result.token) {
                document.getElementById('globalToken').value = result.token;
                setGlobalToken();
            }
            
        } catch (error) {
            alert('Network error: ' + error.message);
        }
    }

    // Auto-generate table of contents
    document.addEventListener('DOMContentLoaded', () => {
        const tocContainer = document.getElementById('toc-container');
        if (!tocContainer) return;

        const headings = document.querySelectorAll('h2[id], h3[id], h4[id]');
        if (headings.length === 0) {
            tocContainer.innerHTML = '<p class="text-sm text-muted-foreground px-4">No headings found</p>';
            return;
        }

        const tocList = document.createElement('ul');
        tocList.className = 'space-y-1';

        headings.forEach((heading, index) => {
            const li = document.createElement('li');
            const link = document.createElement('a');
            link.href = '#' + heading.id;
            link.textContent = heading.textContent;
            link.className = `toc-link text-muted-foreground hover:text-foreground cursor-pointer ${
                heading.tagName === 'H2' ? '' : 
                heading.tagName === 'H3' ? 'pl-4 text-xs' : 
                'pl-8 text-xs'
            }`;
            
            // Add click handler for smooth scrolling
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const targetElement = document.getElementById(heading.id);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    
                    // Update URL without triggering page reload
                    history.replaceState(null, null, '#' + heading.id);
                    
                    // Update active link
                    document.querySelectorAll('.toc-link').forEach(a => a.classList.remove('active'));
                    link.classList.add('active');
                }
            });

            li.appendChild(link);
            tocList.appendChild(li);
        });

        tocContainer.appendChild(tocList);

        // Add scroll spy functionality
        let observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Remove active class from all links
                    document.querySelectorAll('.toc-link').forEach(a => a.classList.remove('active'));
                    
                    // Add active class to current section link
                    const activeLink = document.querySelector(`.toc-link[href="#${entry.target.id}"]`);
                    if (activeLink) {
                        activeLink.classList.add('active');
                    }
                }
            });
        }, {
            rootMargin: '-20% 0% -35% 0%'
        });

        headings.forEach(heading => observer.observe(heading));
    });

    // Navigation link active states and section management
    document.addEventListener('DOMContentLoaded', () => {
        const navLinks = document.querySelectorAll('.nav-link');
        const sectionButtons = document.querySelectorAll('button[class*="font-semibold"]');
        let isManualNavigation = false; // Flag to prevent scroll spy interference
        
        // Map sections to their related hash fragments  
        const sectionMap = {
            'token-auth': 'auth',
            'new-features': 'features', 
            'register': 'user',
            'login': 'user',
            'get-user': 'user',
            'update-profile': 'user',
            'update-password': 'user',
            'logout': 'user',
            'delete-account': 'user',
            'account-management': 'account',
            'category-management': 'category',
            'transaction-management': 'transaction',
            'budget-management': 'budget',
            'testing-guide': 'testing',
            'examples': 'testing'
        };

        const updateActiveNavLinks = () => {
            const currentHash = window.location.hash.replace('#', '');
            const activeSection = sectionMap[currentHash];
            
            // Reset all nav links
            navLinks.forEach(link => {
                link.classList.remove('active', 'bg-accent', 'text-accent-foreground');
                link.classList.add('text-muted-foreground');
            });

            // Reset all section buttons
            sectionButtons.forEach(button => {
                button.classList.remove('section-button-active');
            });

            // Highlight active nav link
            if (currentHash) {
                navLinks.forEach(link => {
                    if (link.getAttribute('href') === '#' + currentHash) {
                        link.classList.remove('text-muted-foreground');
                        link.classList.add('active');
                    }
                });

                // Highlight parent section button if a child is active
                if (activeSection) {
                    sectionButtons.forEach(button => {
                        const buttonText = button.textContent.toLowerCase();
                        if ((activeSection === 'auth' && buttonText.includes('authentication')) ||
                            (activeSection === 'features' && buttonText.includes('new features')) ||
                            (activeSection === 'user' && buttonText.includes('user management')) ||
                            (activeSection === 'account' && buttonText.includes('account management')) ||
                            (activeSection === 'category' && buttonText.includes('category management')) ||
                            (activeSection === 'transaction' && buttonText.includes('transaction management')) ||
                            (activeSection === 'budget' && buttonText.includes('budget management')) ||
                            (activeSection === 'testing' && buttonText.includes('interactive testing'))) {
                            
                            button.classList.add('section-button-active');
                        }
                    });
                }
            }
        };

        updateActiveNavLinks();
        window.addEventListener('hashchange', updateActiveNavLinks);
        
        // Handle clicks on nav links to update hash and active states immediately
        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Set flag to prevent scroll spy interference
                isManualNavigation = true;
                
                const targetHash = link.getAttribute('href');
                const targetId = targetHash.replace('#', '');
                
                // Update the URL hash
                window.location.hash = targetHash;
                
                // Immediately update active states
                updateActiveNavLinks();
                
                // Scroll to the target element smoothly
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    
                    // Reset flag after scroll completes
                    setTimeout(() => {
                        isManualNavigation = false;
                    }, 1000);
                }
            });
        });

        // Create a modified intersection observer that respects manual navigation
        const createScrollSpy = () => {
            const headings = document.querySelectorAll('h2[id], h3[id], h4[id]');
            
            let observer = new IntersectionObserver((entries) => {
                // Don't interfere with manual navigation
                if (isManualNavigation) return;
                
                // Find the entry that is most visible
                let mostVisible = null;
                let maxRatio = 0;
                
                entries.forEach(entry => {
                    if (entry.isIntersecting && entry.intersectionRatio > maxRatio) {
                        maxRatio = entry.intersectionRatio;
                        mostVisible = entry;
                    }
                });
                
                if (mostVisible) {
                    const targetId = mostVisible.target.id;
                    if (window.location.hash !== '#' + targetId) {
                        history.replaceState(null, null, '#' + targetId);
                        updateActiveNavLinks();
                    }
                }
            }, {
                rootMargin: '-10% 0% -60% 0%', // Adjusted for better detection
                threshold: [0, 0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1.0]
            });

            headings.forEach(heading => observer.observe(heading));
        };
        
        // Initialize scroll spy
        createScrollSpy();

        // Also update on page load with hash
        if (window.location.hash) {
            setTimeout(updateActiveNavLinks, 100);
        }
    });
</script>
@endpush