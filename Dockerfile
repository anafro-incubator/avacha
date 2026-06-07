FROM php:8.5-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY ./composer.* ./
RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction
RUN composer dump-autoload --optimize
