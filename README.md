Скопировать репозиторий:
````
git clone git@github.com:AntonSamoilenko/order.git
````
---
Перейти в папку проека:
````
cd /dir/to/project/
````
---
Билд образа:
````
docker compose build --no-cache
````
---
Запуск контейнера, порт по умолчанию: 8080
````
docker compose up -d
````
---
Накатываем зависимости и миграции
если установленна make:
````
make composer
make migrate_db
````
если не устновлен:
````
docker compose exec php composer install
docker compose exec php php ./yii migrate
````
---
Доступ по ссылке:
````
http://localhost:<PORT>/orders
````
---