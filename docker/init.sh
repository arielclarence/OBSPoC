cp .env.example .env
echo "APACHE_USER=$(whoami)" >> .env
echo "USER_ID=$(id -u)" >> .env
echo "COMPOSE_PROJECT_NAME=boilerplate" >> .env

docker-compose build
docker-compose up -d
