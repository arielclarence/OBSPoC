FROM gitlab.bastrucks.com:5050/basworld/boilerplates/api/prod:1.1.0

COPY --chown=www-data:www-data . /var/www/html

USER www-data
