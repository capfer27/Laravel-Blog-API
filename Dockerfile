FROM php:8.3-alpine

# 1. Install system dependencies + build dependencies for PHP extensions
# We need to add 'oniguruma-dev' because it's required to compile mbstring
RUN apk add --no-cache \
    openssl \
    zip \
    unzip \
    git \
    postgresql-dev \
    oniguruma-dev

# 2. Install PHP extensions
# Added mbstring since Laravel needs it and it's missing in your current list
RUN docker-php-ext-install pdo pdo_pgsql mbstring

# 3. Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /app

# 4. Copy files and install dependencies
COPY . /app

# Use --no-interaction to prevent composer from hanging during build
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Command to run the Laravel development server
CMD php artisan serve --host=0.0.0.0 --port=8000

EXPOSE 8000