FROM php:8.3-cli-bookworm

RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip zip \
    sqlite3 libsqlite3-dev \
    libzip-dev libxml2-dev libonig-dev \
    && docker-php-ext-install pdo_sqlite mbstring xml zip bcmath \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts --prefer-dist

COPY . .

# Keep build light — migrate/seed happen on container start
RUN cp .env.example .env \
    && php artisan key:generate --force \
    && mkdir -p database storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && touch database/database.sqlite \
    && chmod -R 775 storage bootstrap/cache database \
    && php artisan package:discover --ansi || true

COPY docker/start.sh /usr/local/bin/start-kiu
RUN sed -i 's/\r$//' /usr/local/bin/start-kiu \
    && chmod +x /usr/local/bin/start-kiu

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV PORT=10000

EXPOSE 10000

CMD ["start-kiu"]
