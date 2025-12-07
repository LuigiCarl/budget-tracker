@extends('layouts.docs')

@section('title', 'Installation')

@section('sidebar')
    <x-docs.navigation />
@endsection

@section('toc')
    <!-- TOC is auto-generated from headings -->
@endsection

@section('content')
<div class="mb-8">
    <div class="mb-2 inline-block px-3 py-1 rounded-full bg-[#6366F1]/10 text-[#6366F1] text-xs font-semibold">Getting Started</div>
    <h1 class="text-4xl font-bold tracking-tight mb-3">Installation</h1>
    <p class="text-lg text-muted-foreground">Get your Laravel application up and running in minutes.</p>
</div>

## Prerequisites

Before you begin, make sure you have the following installed on your system:

- **PHP 8.2 or higher**
- **Composer** - PHP dependency manager
- **Node.js 18 or higher** - For frontend assets
- **MySQL/PostgreSQL** - Database server

<x-docs.callout type="warning" title="System Requirements">
    Make sure your PHP installation includes the required extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, and XML.
</x-docs.callout>

## Step 1: Clone the Repository

Clone the project repository to your local machine:

<x-docs.code language="bash" title="Clone Repository">
git clone https://github.com/yourusername/budget-tracker.git
cd budget-tracker
</x-docs.code>

## Step 2: Install Dependencies

Install PHP dependencies using Composer:

<x-docs.code language="bash" title="Install PHP Dependencies">
composer install
</x-docs.code>

Install Node.js dependencies:

<x-docs.code language="bash" title="Install Node Dependencies">
npm install
</x-docs.code>

## Step 3: Environment Configuration

Copy the example environment file and configure your settings:

<x-docs.code language="bash" title="Environment Setup">
cp .env.example .env
php artisan key:generate
</x-docs.code>

Update your `.env` file with your database credentials:

<x-docs.code language="env" filename=".env">
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=budget_tracker
DB_USERNAME=your_username
DB_PASSWORD=your_password
</x-docs.code>

## Step 4: Database Setup

Run the database migrations:

<x-docs.code language="bash" title="Database Migration">
php artisan migrate
</x-docs.code>

Optionally, seed the database with sample data:

<x-docs.code language="bash" title="Database Seeding">
php artisan db:seed
</x-docs.code>

## Step 5: Build Assets

Compile the frontend assets:

<x-docs.code language="bash" title="Build Assets">
# For development
npm run dev

# For production
npm run build
</x-docs.code>

## Step 6: Start the Development Server

Start the Laravel development server:

<x-docs.code language="bash" title="Start Server">
php artisan serve
</x-docs.code>

Your application should now be running at `http://localhost:8000`.

## Verification

To verify your installation was successful, visit the following URLs:

- **Homepage**: `http://localhost:8000`
- **Login**: `http://localhost:8000/login`
- **API Documentation**: `http://localhost:8000/api/docs`

<x-docs.callout type="success" title="Installation Complete!">
    Congratulations! Your Laravel application is now running. Check out the [Quick Start guide](/docs/quickstart) to begin building your first features.
</x-docs.callout>

## Docker Installation (Alternative)

If you prefer using Docker, you can get started even faster:

<x-docs.code language="bash" title="Docker Setup">
# Clone the repository
git clone https://github.com/yourusername/budget-tracker.git
cd budget-tracker

# Start with Laravel Sail
./vendor/bin/sail up -d

# Run migrations
./vendor/bin/sail artisan migrate
</x-docs.code>

## Troubleshooting

### Common Issues

**Permission Denied Errors**
```bash
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

**Composer Install Fails**
Make sure you have the correct PHP version and required extensions installed.

**Database Connection Error**
Verify your database credentials in the `.env` file and ensure your database server is running.

<x-docs.callout type="info" title="Need More Help?">
    If you're still having issues, check out our [troubleshooting guide](/docs/troubleshooting) for more detailed solutions.
</x-docs.callout>
@endsection