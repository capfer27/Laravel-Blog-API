# Variables
COMPOSE = docker compose

# Default command
help:
	@echo "Available commands:"
	@echo "  make up      - Start the containers"
	@echo "  make down    - Stop the containers"
	@echo "  make wipe    - Остановить контейнеры и УДАЛИТЬ все тома (очистить БД)"
	@echo "  make restart - Restart and clear everything (Nuclear option)"
	@echo "  make logs    - Show real-time logs"
	@echo "  make shell   - Jump into the PHP container"
	@echo "  make seed    - Наполнить базу тестовыми данными (Seed)"
	@echo "  make fresh   - Сбросить БД и запустить миграции с сидами"
	@echo "  make test    - Run Laravel tests (Pest/PHPUnit)"

up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

# Команда для удаления контейнеров и томов
wipe:
	$(COMPOSE) down -v

# This handles the cleanup we did manually earlier
restart:
	$(COMPOSE) down -v
	rm -rf ./postgres_data
	$(COMPOSE) up -d --build

logs:
	$(COMPOSE) logs -f

shell:
	$(COMPOSE) exec app /bin/sh

# Команда для сидинга (наполнение данными)
seed:
	$(COMPOSE) exec app php artisan db:seed

# Команда для полной очистки и пересоздания БД с данными
fresh:
	$(COMPOSE) exec app php artisan migrate:fresh --seed

test:
	$(COMPOSE) exec app php artisan test
