composer:
	docker compose exec php composer install

migrate_db:
	docker compose exec php php ./yii migrate

cache:
	docker compose exec php php yii cache/flush-all