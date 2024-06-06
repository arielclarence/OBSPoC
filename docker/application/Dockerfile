FROM gitlab.bastrucks.com:5050/basworld/templates/dockerfiles/php/8.3-api:3.0.0 AS build

# Install dependencies and PHP extensions
RUN apk add --no-cache zip unzip g++ make autoconf yaml-dev bash libzip-dev linux-headers icu-dev pkgconfig libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql intl xml sockets \
    && pecl install zip \
    && docker-php-ext-enable pdo_mysql intl xml zip sockets

# Copy entrypoint file
COPY entrypoint.sh /var/www/

ENTRYPOINT []

FROM build AS ci

# Composer installation
COPY --from=composer:2.6.6 /usr/bin/composer /usr/local/bin/composer

# Install development php packages
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Copy development ini files
COPY php/php-development.ini php/xdebug.ini /usr/local/etc/php/conf.d/

ENTRYPOINT []

FROM ci AS dev

# Copy entrypoint file
COPY entrypoint.sh /var/www/

ENTRYPOINT ["/var/www/entrypoint.sh"]

FROM build AS prod

# Copy entrypoint file
COPY entrypoint.sh /var/www/

ENTRYPOINT ["/var/www/entrypoint.sh"]
