# balt_test

Забилдить докер:

sudo docker-compose up -d --build


Зайти в контейнер php.

docker exec -u root -t -i php-apache /bin/bash


Запустить composer

composer install

Сделать миграции

php artisan migrate


Если требуется указать свои параметры smtp, то изменить их в .env

Заменить email в /src/config/products/email.php, на которые будут отправляться сообщении о создании продукта.


Обновить config

php artisan config:cache


Запустить очередь

php artisan queue:work


Зайти на сайт
http://localhost:8080/


Я не совсем понял определение роль юзера через файлик конфига, потому добавил роль в стандартную модель пользователя laravel и проверяю по ней.
При миграции создаются 2 пользователя, но также их можно создать самостоятельно.

Admin:
Login: admin@admin.ru
Password: Admin

User:
Login: user@user.ru
Password: User

