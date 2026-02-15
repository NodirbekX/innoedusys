FROM php:8.3-cli

# Install system packages
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip \
    libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath gd

WORKDIR /var/www/html

COPY . .

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
