composer:
	docker compose exec php composer install

migrate_db:
	docker compose exec php php ./yii migrate

cache:
	docker compose exec php php yii cache/flush-all

#migrate-db:
#	docker compose exec php php yii migrate/create order
#	docker compose exec php php yii migrate/create order
#	docker compose exec php php ./yii migrate/to m250212_084612_order_dump
#	docker compose exec php php ./yii migrate/down
#	docker compose exec php composer dump-autoload --optimize