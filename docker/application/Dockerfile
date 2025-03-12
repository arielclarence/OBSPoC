################################################################################################
### BASE: things required for all - dev, ci, prod
################################################################################################
FROM serversideup/php:8.4-fpm-nginx-alpine-v3.5.1 AS base

USER root

################################################################################################
### BUILD: things required for dev & ci
################################################################################################
FROM base AS build

RUN install-php-extensions xdebug
RUN apk add --no-cache mysql-client

################################################################################################
### CI: specific to ci (if any)
################################################################################################
FROM build AS ci

COPY php/xdebug.ini /usr/local/etc/php/conf.d/
ENV PHP_OPCACHE_ENABLE="1"

USER www-data

################################################################################################
### DEV: specific to local (if any)
################################################################################################
FROM build AS dev

COPY php/xdebug.ini /usr/local/etc/php/conf.d/
USER www-data

################################################################################################
### PROD - for deployment
################################################################################################
FROM base AS prod

ENV AUTORUN_ENABLED="true" \
    PHP_OPCACHE_ENABLE="1"

STOPSIGNAL SIGTERM
COPY --chmod=755 ./entrypoint.d/ /etc/entrypoint.d/

USER www-data
