@extends('layouts.docs')

@section('title', 'Introduction')

@section('sidebar')
    <x-docs.navigation />
@endsection

@section('toc')
    <!-- TOC is auto-generated from headings -->
@endsection

@section('content')
<h1>Introduction</h1>

<p class="text-xl text-muted-foreground">
    Build modern web applications with Laravel, Blade, and our comprehensive component library.
</p>

<x-docs.callout type="info" title="Welcome">
    This documentation will help you get started with our Laravel project and understand how to use all the available features and components.
</x-docs.callout>

## What is this project?

This is a modern Laravel application built with:

- **Laravel 11** - The latest version of the Laravel framework
- **Blade Templates** - Server-side rendering with powerful templating
- **Tailwind CSS** - Utility-first CSS framework
- **Laravel Sanctum** - API authentication
- **Modern UI Components** - Pre-built, customizable components

## Key Features

### 🚀 Fast Development
Get up and running quickly with our pre-configured setup and component library.

### 🎨 Modern Design
Built with Tailwind CSS and following modern design principles for beautiful UIs.

### 🔐 Secure Authentication
Laravel Sanctum provides secure API authentication out of the box.

### 📱 Responsive Design
All components are mobile-first and work perfectly on all devices.

### 🧪 Well Tested
Comprehensive test suite ensures reliability and maintainability.

## Quick Example

Here's how easy it is to create a beautiful component:

<x-docs.code language="php" title="Example Component Usage">
<x-button variant="primary" size="lg">
    Click me!
</x-button>
</x-docs.code>

## Architecture Overview

Our application follows Laravel's MVC architecture with some additional patterns:

```
app/
├── Http/
│   ├── Controllers/     # Handle HTTP requests
│   ├── Requests/        # Form request validation
│   └── Middleware/      # Request/response filtering
├── Models/              # Eloquent models
├── Services/            # Business logic
└── View/
    └── Components/      # Blade components
```

## What's Next?

Ready to dive in? Here are some suggested next steps:

1. **[Installation](/docs/installation)** - Set up your development environment
2. **[Quick Start](/docs/quickstart)** - Build your first page in 5 minutes
3. **[API Authentication](/docs/api/authentication)** - Learn about API security
4. **[Components](/docs/components/buttons)** - Explore our component library

<x-docs.callout type="success" title="Need Help?">
    If you get stuck, check out our troubleshooting guide or reach out to the community for help.
</x-docs.callout>
@endsection