@extends('layouts.base')

@section('title', 'API Documentation - ' . config('app.name'))
@section('app-name', 'API Documentation')

@section('sidebar')
<div class="w-full" x-data="{ 
    authSection: true,
    featuresSection: true,
    endpointsSection: true,
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
            <a href="#register" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                User Registration
            </a>
            <a href="#login" class="nav-link group flex w-full items-center rounded-md border border-transparent px-2 py-1 text-sm hover:bg-accent hover:text-accent-foreground text-muted-foreground">
                User Login
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
                Latest Updates (v1.2)
            </a>
        </div>
    </div>

    <!-- API Endpoints Section -->
    <div class="pb-4">
        <button @click="endpointsSection = !endpointsSection" 
                class="flex w-full items-center justify-between rounded-md border border-transparent px-2 py-1 text-sm font-semibold hover:bg-accent hover:text-accent-foreground">
            <span>🚀 API Endpoints</span>
            <svg class="h-3 w-3 transition-transform duration-200" :class="{ 'rotate-90': endpointsSection }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <div x-show="endpointsSection" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="ml-4 mt-2 space-y-1 border-l border-border pl-4">
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
                            <h3 class="font-semibold text-orange-700 dark:text-orange-300 mb-2">✅ Dashboard Analytics (v1.1)</h3>
                            <ul class="text-sm text-orange-600 dark:text-orange-400 space-y-1">
                                <li>• Real-time financial statistics</li>
                                <li>• Pie chart expense visualization</li>
                                <li>• Budget progress tracking</li>
                                <li>• Recent activity overview</li>
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
            'logout': { url: '/api/logout', method: 'POST' }
        };
        
        const config = endpoints[endpoint];
        if (!config) return;
        
        const headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        };
        
        if (globalToken && endpoint !== 'register' && endpoint !== 'login') {
            headers['Authorization'] = 'Bearer ' + globalToken;
        }
        
        try {
            const response = await fetch(config.url, {
                method: config.method,
                headers: headers,
                body: config.method !== 'GET' ? JSON.stringify(data) : undefined
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

    // Navigation link active states
    document.addEventListener('DOMContentLoaded', () => {
        const navLinks = document.querySelectorAll('.nav-link');
        const updateActiveNavLinks = () => {
            const currentHash = window.location.hash;
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentHash) {
                    link.classList.remove('text-muted-foreground');
                    link.classList.add('bg-accent', 'text-accent-foreground');
                } else {
                    link.classList.add('text-muted-foreground');
                    link.classList.remove('bg-accent', 'text-accent-foreground');
                }
            });
        };

        updateActiveNavLinks();
        window.addEventListener('hashchange', updateActiveNavLinks);
    });
</script>
@endpush