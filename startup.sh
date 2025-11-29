#!/bin/bash
set -e

echo "Starting Laravel application..."

# Don't create .env file - use environment variables directly
# Laravel will read from environment if .env doesn't exist

# Set default values if not provided
export APP_ENV=${APP_ENV:-production}
export APP_DEBUG=${APP_DEBUG:-false}
export LOG_CHANNEL=${LOG_CHANNEL:-stack}
export SESSION_DRIVER=${SESSION_DRIVER:-file}
export CACHE_DRIVER=${CACHE_DRIVER:-file}
export QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync}

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ]; then
    echo "Generating APP_KEY..."
    # Generate a key and export it
    export APP_KEY=$(php artisan key:generate --show)
    echo "APP_KEY generated: $APP_KEY"
fi

# Clear all caches
echo "Clearing caches..."
rm -rf bootstrap/cache/*.php
php artisan config:clear --no-interaction || true
php artisan view:clear --no-interaction || true
php artisan route:clear --no-interaction || true

# Skip migrations - tables already exist in Supabase
echo "Skipping migrations (using existing Supabase tables)..."
# php artisan migrate --force --no-interaction || echo "Migrations skipped (tables may already exist)"

# Cache config for better performance
echo "Caching configuration..."
php artisan config:cache --no-interaction

# Start the server
echo "Starting server on port $PORT..."
php artisan serve --host=0.0.0.0 --port=$PORT --no-interaction
