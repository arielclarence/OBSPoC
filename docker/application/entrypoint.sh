#!/usr/bin/env sh
set -e

if which composer >/dev/null 2>&1; then
    cd /var/www/html && composer install
fi

php /var/www/html/artisan config:clear
php /var/www/html/artisan cache:clear
php /var/www/html/artisan migrate

/usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
