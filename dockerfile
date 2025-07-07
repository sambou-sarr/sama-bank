FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    zip unzip curl git libzip-dev libpq-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql zip mbstring bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html && a2enmod rewrite

EXPOSE 8000

CMD composer install && php artisan key:generate && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
