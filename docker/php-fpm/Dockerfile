FROM php:8.3-fpm-alpine

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

RUN apk add --no-cache $PHPIZE_DEPS \
    && apk add --no-cache libzip-dev oniguruma-dev curl-dev postgresql-dev curl unzip \
    && docker-php-ext-install pdo_pgsql pgsql zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del $PHPIZE_DEPS

WORKDIR /app