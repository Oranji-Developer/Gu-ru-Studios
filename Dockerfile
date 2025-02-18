# Build stage for Node/Bun assets
FROM oven/bun:latest AS node-builder
WORKDIR /app
COPY package.json bun.lock ./
RUN bun install --frozen-lockfile
COPY . .
RUN bun run build

# PHP stage
FROM dunglas/frankenphp

WORKDIR /app

# Install PHP extensions
RUN install-php-extensions \
    pcntl \
    pdo_mysql \
    opcache \
    zip \
    gd \
    intl \
    bcmath

# Configure PHP
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# Install composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Copy all application files first
COPY --chown=www-data:www-data . .

# Copy built assets from node-builder stage
COPY --from=node-builder --chown=www-data:www-data /app/public/build public/build

# Copy composer.lock and composer.json
COPY composer.lock composer.json ./

# Install PHP dependencies
RUN composer install --optimize-autoloader

# Laravel specific commands
# Optimize Laravel
RUN php artisan optimize
RUN php artisan storage:link

# Set permissions
RUN chown -R www-data:www-data /app
RUN chmod -R 755 /app/storage /app/bootstrap/cache

# Expose port
EXPOSE 8000

# Start Laravel Octane
CMD ["php", "artisan", "octane:start", "--host=0.0.0.0", "--port=8000"]
