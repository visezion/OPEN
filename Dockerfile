FROM php:8.2-apache-bookworm AS php-base

ENV APACHE_DOCUMENT_ROOT=/var/www/html \
    COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        gosu \
        libfreetype6-dev \
        libicu-dev \
        libjpeg62-turbo-dev \
        libonig-dev \
        libpng-dev \
        libxml2-dev \
        libzip-dev \
        unzip \
        zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        bcmath \
        exif \
        gd \
        intl \
        mbstring \
        mysqli \
        opcache \
        pcntl \
        pdo_mysql \
        xml \
        zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && a2enmod expires headers rewrite \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/php/open.ini /usr/local/etc/php/conf.d/zz-open.ini
COPY docker/entrypoint.sh /usr/local/bin/open-entrypoint

FROM php-base AS composer

WORKDIR /app

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY . .

RUN composer install \
    --no-dev \
    --prefer-dist \
    --optimize-autoloader \
    --no-interaction \
    --no-progress \
    --no-scripts

FROM node:20-bookworm-slim AS frontend

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm ci --include=optional

COPY . .

RUN npm run build

FROM php-base

COPY . .
COPY --from=composer /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build
COPY --from=frontend /app/build ./build

RUN chmod +x /usr/local/bin/open-entrypoint \
    && mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache uploads \
    && chown -R www-data:www-data bootstrap/cache storage uploads \
    && chmod -R ug+rw bootstrap/cache storage uploads

ENTRYPOINT ["open-entrypoint"]
CMD ["apache2-foreground"]
