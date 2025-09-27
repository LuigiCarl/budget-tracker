@extends('layouts.base')

@section('title', 'Dashboard - ' . config('app.name'))
@section('app-name', 'Budget Tracker')

@section('content')
    <!-- Hero Section -->
    <div class="space-y-2 mb-8">
        <h1 class="scroll-m-20 text-4xl font-extrabold tracking-tight lg:text-5xl">
            Dashboard
        </h1>
        <p class="text-xl text-muted-foreground">
            Welcome back, {{ auth()->user()->name }}! Manage your budget tracking and explore our API.
        </p>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 mb-8">
        <!-- Welcome Card -->
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm card-hover">
            <div class="p-6">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-full">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Active Account</h3>
                        <p class="text-sm text-muted-foreground">You're successfully logged in</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- API Access Card -->
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm card-hover">
            <div class="p-6">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m13 0H4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">API Ready</h3>
                        <p class="text-sm text-muted-foreground">Full API access available</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documentation Card -->
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm card-hover">
            <div class="p-6">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-full">
                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Documentation</h3>
                        <p class="text-sm text-muted-foreground">Interactive API testing</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid gap-6 lg:grid-cols-2">
        <!-- Get Started Card -->
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold">Get Started</h2>
                </div>
                
                <p class="text-muted-foreground mb-6">
                    Explore the Budget Tracker API with our interactive documentation and start building your financial applications.
                </p>
                
                <div class="space-y-3">
                    <a href="{{ route('api.docs') }}" 
                       class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 w-full">
                        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Explore API Documentation
                    </a>
                    
                    <a href="{{ route('profile.edit') }}" 
                       class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 w-full">
                        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Manage Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- API Features Card -->
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-gradient-to-br from-green-500 to-blue-600 rounded-lg">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-7H5m14 14H5" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold">API Features</h2>
                </div>
                
                <p class="text-muted-foreground mb-4">
                    Powerful endpoints for complete budget management:
                </p>
                
                <div class="space-y-3">
                    <div class="flex items-center space-x-3 p-3 bg-accent/50 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium">User Authentication</p>
                            <p class="text-xs text-muted-foreground">Secure token-based authentication</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3 p-3 bg-accent/50 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium">Profile Management</p>
                            <p class="text-xs text-muted-foreground">Update user information and passwords</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3 p-3 bg-accent/50 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium">Interactive Testing</p>
                            <p class="text-xs text-muted-foreground">Test endpoints directly in the browser</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Information -->
    <div class="mt-8">
        <div class="rounded-lg border border-border bg-card text-card-foreground shadow-sm">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold">Account Information</h2>
                    <div class="flex items-center space-x-2 text-xs text-muted-foreground">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span>Active</span>
                    </div>
                </div>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-muted-foreground mb-2">Profile Details</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm">Name:</span>
                                <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm">Email:</span>
                                <span class="text-sm font-medium">{{ auth()->user()->email }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm">Member Since:</span>
                                <span class="text-sm font-medium">{{ auth()->user()->created_at->format('M j, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-muted-foreground mb-2">Account Status</h3>
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span class="text-sm">Email Verified</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span class="text-sm">API Access Enabled</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                <span class="text-sm">Laravel Sanctum Active</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
