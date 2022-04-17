# balt_test

Забилдить докер:
sudo docker-compose up -d --build

Зайти в контейнер php.
docker exec -u root -t -i php-apache /bin/bash

Зайти в контейнер postgres.
docker exec -u root -t -i database /bin/bash
