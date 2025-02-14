FROM php:8.3-cli

WORKDIR /app

COPY --chown=www-data:www-data . /app

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pcntl opcache bcmath \
    && docker-php-ext-enable zip opcache bcmath

COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

#COPY --from=oven/bun:latest /bun/bin/bun /usr/local/bin/bun

RUN curl -fsSL https://bun.sh/install | bash && \
    mv /root/.bun/bin/bun /usr/local/bin/bun

RUN git config --global --add safe.directory /app

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install && \
    composer require laravel/octane && \
    php artisan octane:install --server=frankenphp

RUN bun install --production && bun build --outdir=dist ./src/index.tsx

EXPOSE 8000

CMD ["php", "artisan", "octane:start", "--host=0.0.0.0", "--port=8000"]
