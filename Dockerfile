FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files first for better caching
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader --no-dev

# Copy package.json files
COPY package.json package-lock.json* ./
RUN npm ci

# Copy application code
COPY . .

# Complete composer installation
RUN composer dump-autoload --no-dev --optimize

# Build assets
RUN npm run build

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Expose port
EXPOSE $PORT

# Start command - Generate key if missing, clear config cache, run migrations, then serve
CMD php artisan key:generate --force; \
    php artisan config:clear; \
    php artisan cache:clear; \
    php artisan migrate --force; \
    php artisan serve --host=0.0.0.0 --port=$PORT