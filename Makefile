composer:
	docker compose exec php composer install

migrate-db:
	docker compose exec php php ./yii migrate

	#docker compose exec php php ./yii migrate/to m250212_084612_order_dump

#migrate-db:
#	docker compose exec php php yii migrate/create order
#	docker compose exec php php yii migrate/create order