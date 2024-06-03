FROM gitlab.bastrucks.com:5050/basworld/boilerplates/api/prod:1.0.0

WORKDIR /var/www/html

COPY . .

EXPOSE 80
