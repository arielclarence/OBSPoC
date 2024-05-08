FROM gitlab.bastrucks.com:5050/basworld/templates/dockerfiles/php/8.3-api:3.0.0 AS build

# Composer installation
COPY --from=composer:2.6.6 /usr/bin/composer /usr/local/bin/composer

RUN apk update && apk add --no-cache openssl-dev curl-dev autoconf g++ make libzip-dev zip unzip libxml2-dev linux-headers bash
# Add MongoDB
RUN pecl install mongodb && docker-php-ext-enable mongodb

COPY entrypoint.sh /var/www/

ENTRYPOINT ["/var/www/entrypoint.sh"]

FROM build AS ci

RUN pecl install xdebug && docker-php-ext-enable xdebug
# Copy development ini files
COPY php/php-development.ini php/xdebug.ini /usr/local/etc/php/conf.d/

ENTRYPOINT []

FROM ci AS dev
# Copy entrypoint file
COPY entrypoint.sh /var/www/

ENTRYPOINT ["/var/www/entrypoint.sh"]

FROM build AS prod

RUN rm /usr/local/bin/composer
# Copy entrypoint file
COPY entrypoint.sh /var/www/

ENTRYPOINT ["/var/www/entrypoint.sh"]

