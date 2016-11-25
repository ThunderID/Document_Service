THUNDER DOCUMENT

This service contain docker container, mongo, nginx and php-fpm included

# RUNNING CONTAINER

docker-compose build
docker-compose up -d

# RUNNING CONTAINER WITH KONG
1. Edit setup.sh file, change upstream_url of container
2. sh setup.sh