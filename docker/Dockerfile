# syntax=docker/dockerfile:1.7

ARG PHP_IMAGE=php:8.5.1-fpm
ARG COMPOSER_IMAGE=composer:2.9.3
ARG APP_ENV=local

# Composer
FROM ${COMPOSER_IMAGE} AS composer

WORKDIR /app
COPY composer.json composer.lock ./
RUN --mount=type=cache,target=/tmp/composer-cache \
    COMPOSER_CACHE_DIR=/tmp/composer-cache \
    composer install --prefer-dist --no-interaction --no-progress;

# PHP
FROM ${PHP_IMAGE} AS app

ARG APP_ENV=local
WORKDIR /app

RUN set -eux; apt-get update; apt-get install -y --no-install-recommends \
    ca-certificates curl \
    libbz2-dev libcurl4-openssl-dev libffi-dev libzip-dev zlib1g-dev libicu-dev libpq-dev libsqlite3-dev libxml2-dev libonig-dev libgmp-dev libsodium-dev libjpeg62-turbo-dev libpng-dev libfreetype6-dev; \
    docker-php-ext-configure gd --with-freetype --with-jpeg; \
    docker-php-ext-install -j"$(nproc)" \
    bz2 ffi gd gmp intl exif mysqli pdo_mysql pdo_pgsql pgsql shmop soap sockets zip; \
    rm -rf /var/lib/apt/lists/*

COPY docker/linux/php-${APP_ENV}.ini /usr/local/etc/php/conf.d/42-custom-php.ini
COPY . .

RUN set -eux; \
    mkdir -p runtime web/assets; \
    chown -R www-data:www-data /app; \
    chmod -R 0777 /app/runtime /app/web/assets; \
    chmod +x /app/yii

COPY --from=composer /app/vendor ./vendor

EXPOSE 9000
CMD ["php-fpm"]
