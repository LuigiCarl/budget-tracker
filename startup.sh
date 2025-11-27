#!/bin/bash
set -e

echo "Starting Laravel application..."

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force --no-interaction
fi

# Clear all caches
echo "Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Run migrations
echo "Running migrations..."
php artisan migrate --force --no-interaction

# Cache config for better performance
echo "Caching configuration..."
php artisan config:cache

# Start the server
echo "Starting server on port $PORT..."
php artisan serve --host=0.0.0.0 --port=$PORT --no-interaction
