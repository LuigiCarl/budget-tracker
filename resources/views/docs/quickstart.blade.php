@extends('layouts.docs')

@section('title', 'Quick Start')

@section('sidebar')
    <x-docs.navigation />
@endsection

@section('toc')
    <!-- TOC is auto-generated from headings -->
@endsection

@section('content')
<div class="mb-8">
    <div class="mb-2 inline-block px-3 py-1 rounded-full bg-[#6366F1]/10 text-[#6366F1] text-xs font-semibold">Getting Started</div>
    <h1 class="text-4xl font-bold tracking-tight mb-3">Quick Start</h1>
    <p class="text-lg text-muted-foreground">Build your first feature in under 5 minutes with this step-by-step guide.</p>
</div>

<x-docs.callout type="info" title="Prerequisites">
    Make sure you've completed the [installation guide](/docs/installation) before proceeding.
</x-docs.callout>

## Step 1: Create Your First Route

Let's create a simple dashboard page. Add this route to your `routes/web.php`:

<x-docs.code language="php" filename="routes/web.php">
Route::get('/my-dashboard', function () {
    return view('my-dashboard', [
        'stats' => [
            'users' => 1250,
            'revenue' => 45620,
            'orders' => 892,
            'growth' => 12.5
        ]
    ]);
})->name('my-dashboard');
</x-docs.code>

## Step 2: Create the View

Create a new Blade view file at `resources/views/my-dashboard.blade.php`:

<x-docs.code language="php" filename="resources/views/my-dashboard.blade.php">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            My Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Users Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-500 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                {{ number_format($stats['users']) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Revenue Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-500 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Revenue</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                ${{ number_format($stats['revenue']) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Orders Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-500 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 12H6L5 9z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Orders</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                {{ number_format($stats['orders']) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Growth Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-orange-500 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Growth</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                +{{ $stats['growth'] }}%
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Welcome Message -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    Welcome to Your Dashboard!
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    This is your custom dashboard built in just a few minutes. You can expand this with more features, charts, and functionality as needed.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
</x-docs.code>

## Step 3: Test Your Page

Visit your new dashboard at: `http://localhost:8000/my-dashboard`

You should see a beautiful dashboard with statistics cards and a welcome message.

## Step 4: Add Navigation (Optional)

To make your dashboard easily accessible, add it to your main navigation. Update your `app-layout` component:

<x-docs.code language="php" filename="resources/views/layouts/navigation.blade.php">
<!-- Add this to your navigation menu -->
<x-nav-link :href="route('my-dashboard')" :active="request()->routeIs('my-dashboard')">
    {{ __('My Dashboard') }}
</x-nav-link>
</x-docs.code>

## What We Built

In just a few minutes, you've created:

- ✅ A new route with data passing
- ✅ A responsive dashboard view
- ✅ Beautiful UI components with Tailwind CSS
- ✅ Dark mode support
- ✅ Mobile-friendly design

## Next Steps

Now that you have the basics down, here are some suggestions for expanding your application:

### Add API Endpoints

Create API routes to make your data accessible:

<x-docs.code language="php" title="API Routes">
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard-stats', function () {
        return response()->json([
            'users' => 1250,
            'revenue' => 45620,
            'orders' => 892,
            'growth' => 12.5
        ]);
    });
});
</x-docs.code>

### Create a Model and Migration

For real data, create a model:

<x-docs.code language="bash" title="Create Model">
php artisan make:model DashboardStat -m
</x-docs.code>

### Add Form Handling

Create forms with validation:

<x-docs.code language="php" title="Form Request">
php artisan make:request StoreDashboardRequest
</x-docs.code>

<x-docs.callout type="success" title="Congratulations!">
    You've successfully built your first feature! Ready to dive deeper? Explore our [component library](/docs/components/buttons) or learn about [API authentication](/docs/api/authentication).
</x-docs.callout>

## Common Patterns

Here are some common patterns you'll use frequently:

### Controller with Resource

<x-docs.code language="bash">
php artisan make:controller DashboardController --resource
</x-docs.code>

### Form Requests

<x-docs.code language="php">
public function store(StoreDashboardRequest $request)
{
    // Validation is handled automatically
    $validated = $request->validated();
    
    // Your logic here
}
</x-docs.code>

### Blade Components

<x-docs.code language="bash">
php artisan make:component StatCard
</x-docs.code>

Ready to continue? Check out our [API documentation](/docs/api/authentication) or explore more [components](/docs/components/buttons).
@endsection