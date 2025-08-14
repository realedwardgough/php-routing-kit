# Use official PHP 8.3 image with Apache
FROM php:8.3-apache

# Install system dependencies and extensions
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files into the container
COPY . .

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Run composer install (you can also run this manually later if preferred)
RUN composer install --no-interaction --optimize-autoloader

# Set correct permissions for Apache
RUN chown -R www-data:www-data /var/www/html

# Apache config for routing
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Expose port
EXPOSE 80
