@extends('layouts.docs')

@section('title', 'Introduction')

@section('sidebar')
    <x-docs.navigation />
@endsection

@section('toc')
    <!-- TOC is auto-generated from headings -->
@endsection

@section('content')
<div class="mb-12">
    <div class="mb-2 inline-block px-3 py-1 rounded-full bg-[#6366F1]/10 text-[#6366F1] text-xs font-semibold">Welcome</div>
    <h1 class="text-4xl font-bold tracking-tight mb-3">FinanEase Documentation</h1>
    <p class="text-lg text-muted-foreground">A modern personal finance management application built with Laravel and React.</p>
</div>

<div class="mt-6 grid gap-4 md:grid-cols-2">
    <div class="rounded-lg border bg-card p-6 hover:shadow-lg transition-shadow">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-[#6366F1] to-[#8B5CF6] flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h3 class="font-semibold">Quick Start</h3>
        </div>
        <p class="text-sm text-muted-foreground mb-3">Get up and running in minutes with our step-by-step guide.</p>
        <a href="{{ route('docs.quickstart') }}" class="text-sm text-[#6366F1] hover:underline">Get started →</a>
    </div>
    
    <div class="rounded-lg border bg-card p-6 hover:shadow-lg transition-shadow">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-[#10B981] to-[#059669] flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
            </div>
            <h3 class="font-semibold">API Reference</h3>
        </div>
        <p class="text-sm text-muted-foreground mb-3">Complete API documentation with examples and authentication.</p>
        <a href="{{ route('docs.api.authentication') }}" class="text-sm text-[#10B981] hover:underline">View API docs →</a>
    </div>
</div>

<x-docs.callout type="info" title="Welcome to FinanEase">
    FinanEase helps you track expenses, manage budgets, and gain insights into your spending habits with a beautiful, intuitive interface.
</x-docs.callout>

## What is FinanEase?

FinanEase is a comprehensive personal finance tracker that helps you:

- **Track Transactions** - Record income and expenses across multiple accounts
- **Manage Budgets** - Set spending limits by category and get alerts when overspending
- **Multiple Accounts** - Manage cash, bank accounts, e-wallets, and more
- **Transfer Funds** - Move money between accounts with automatic tracking
- **Analytics** - Visualize spending patterns with charts and reports
- **Dark Mode** - Beautiful UI with light and dark theme support

## Tech Stack

<div class="grid gap-4 md:grid-cols-3 mt-4">
    <div class="rounded-lg border p-4">
        <h4 class="font-semibold text-[#6366F1] mb-2">Backend</h4>
        <ul class="text-sm space-y-1 text-muted-foreground">
            <li>• Laravel 11</li>
            <li>• PostgreSQL</li>
            <li>• Laravel Sanctum</li>
            <li>• Mailtrap Email</li>
        </ul>
    </div>
    <div class="rounded-lg border p-4">
        <h4 class="font-semibold text-[#8B5CF6] mb-2">Frontend</h4>
        <ul class="text-sm space-y-1 text-muted-foreground">
            <li>• React 18 + TypeScript</li>
            <li>• TanStack Query</li>
            <li>• Tailwind CSS</li>
            <li>• Recharts</li>
        </ul>
    </div>
    <div class="rounded-lg border p-4">
        <h4 class="font-semibold text-[#10B981] mb-2">Features</h4>
        <ul class="text-sm space-y-1 text-muted-foreground">
            <li>• PWA Support</li>
            <li>• Real-time Updates</li>
            <li>• Responsive Design</li>
            <li>• Admin Dashboard</li>
        </ul>
    </div>
</div>

## Application Structure

The application follows a clean architecture with separated concerns:

```
├── Backend (Laravel API)
│   ├── Controllers - Handle HTTP requests
│   ├── Models - Eloquent data models
│   ├── Requests - Input validation
│   └── Notifications - Email notifications
│
└── Frontend (React SPA)
    ├── Components - Reusable UI components
    ├── Context - Global state management
    ├── Hooks - Custom React hooks
    └── Utils - API client & utilities
```

## Key Features Overview

### 📊 Dashboard
Real-time overview of your finances with:
- Total balance across all accounts
- Monthly income vs expenses comparison
- Recent transactions list
- Budget progress indicators

### 💳 Transactions
Complete transaction management:
- Income and expense tracking
- Category-based organization
- Date filtering and search
- Bulk operations support

### 📈 Budgets
Smart budget management:
- Category-based budgets
- Monthly spending limits
- Visual progress bars
- Overspend warnings

### 🏦 Accounts
Multi-account support:
- Cash, bank, e-wallet accounts
- Balance tracking
- Account-to-account transfers
- Transaction history per account

### 🏷️ Categories
Flexible categorization:
- Income and expense categories
- Custom category icons
- Category-based analytics
- Budget association

## What's Next?

<div class="grid gap-3 mt-4">
    <a href="{{ route('docs.installation') }}" class="flex items-center gap-3 p-4 rounded-lg border hover:bg-accent transition-colors">
        <span class="text-2xl">1️⃣</span>
        <div>
            <div class="font-medium">Installation</div>
            <div class="text-sm text-muted-foreground">Set up your development environment</div>
        </div>
    </a>
    <a href="{{ route('docs.quickstart') }}" class="flex items-center gap-3 p-4 rounded-lg border hover:bg-accent transition-colors">
        <span class="text-2xl">2️⃣</span>
        <div>
            <div class="font-medium">Quick Start</div>
            <div class="text-sm text-muted-foreground">Create your first transaction in 5 minutes</div>
        </div>
    </a>
    <a href="{{ route('docs.features.dashboard') }}" class="flex items-center gap-3 p-4 rounded-lg border hover:bg-accent transition-colors">
        <span class="text-2xl">3️⃣</span>
        <div>
            <div class="font-medium">Explore Features</div>
            <div class="text-sm text-muted-foreground">Learn about all the features available</div>
        </div>
    </a>
</div>

<x-docs.callout type="success" title="Ready to Start?">
    Head over to the <a href="{{ route('docs.installation') }}" class="font-medium underline">Installation Guide</a> to set up FinanEase on your machine.
</x-docs.callout>
@endsection