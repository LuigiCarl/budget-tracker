#!/bin/bash
set -e

echo "Starting Laravel application..."

# Create .env file if it doesn't exist
if [ ! -f .env ]; then
    echo "Creating .env file from example..."
    cp .env.example .env
fi

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force --no-interaction
fi

# Clear all caches (don't use database cache clearing)
echo "Clearing caches..."
rm -rf bootstrap/cache/*.php
php artisan config:clear --no-interaction || true
php artisan cache:clear --no-interaction || true
php artisan view:clear --no-interaction || true
php artisan route:clear --no-interaction || true

# Run migrations
echo "Running migrations..."
php artisan migrate --force --no-interaction

# Cache config for better performance
echo "Caching configuration..."
php artisan config:cache --no-interaction

# Start the server
echo "Starting server on port $PORT..."
php artisan serve --host=0.0.0.0 --port=$PORT --no-interaction
