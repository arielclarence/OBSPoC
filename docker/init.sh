docker-compose up -d

sleep 10

docker-compose exec pim-service php artisan key:generate
# Create bas user for mongo
docker-compose exec pim-mongodb-server mongo -u root -p root \
    --authenticationDatabase admin pim \
    --eval 'if (db.getUser("bas") == null){db.createUser({user:"bas",pwd:"bas",roles:[{role:"readWrite",db:"pim"}]})}'
