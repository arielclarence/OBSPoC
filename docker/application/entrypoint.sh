#!/usr/bin/env sh
set -e

php /var/www/html/artisan migrate
php /var/www/html/artisan config:clear
php /var/www/html/artisan cache:clear

/usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
