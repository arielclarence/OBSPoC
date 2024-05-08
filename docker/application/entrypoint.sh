#!/usr/bin/env sh
set -e

if which composer >/dev/null 2>&1; then
    cd /var/www/html && composer install
fi
php /var/www/html/artisan optimize
php /var/www/html/artisan migrate
php /var/www/html/artisan l5-swagger:generate

/usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
