FROM php:latest

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Nginx
RUN apt-get install -y nginx

# Copy Nginx configuration files
COPY docker/application/nginx/default.conf /etc/nginx/sites-available/default
COPY docker/application/nginx/nginx.conf /etc/nginx/nginx.conf


# Expose port 80
EXPOSE 80

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project files
COPY . .

# Install Laravel dependencies using Composer
RUN composer install --no-dev --optimize-autoloader

# Set permissions for Laravel storage and bootstrap cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Start Nginx
CMD ["nginx", "-g", "daemon off;"]
