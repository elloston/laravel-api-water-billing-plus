# Use PHP 8.2 as the base image
FROM php:8.2-cli

# Install required dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the application files into the container
COPY . .

# Set appropriate permissions for storage and cache directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Specify the default command to run when the container starts
CMD php artisan serve --host=0.0.0.0 --port=8000
