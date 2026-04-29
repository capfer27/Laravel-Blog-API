# Variables
COMPOSE = docker compose

# Default command
help:
	@echo "Available commands:"
	@echo "  make up      - Запустить контейнеры"
	@echo "  make down    - Остановить контейнеры"
	@echo "  make wipe    - Остановить контейнеры и УДАЛИТЬ все тома (очистить БД)"
	@echo "  make restart - Перезагрузить контейнеры и очистите все данные (ядерный вариант)"
	@echo "  make logs    - Отображать журналов в реальном времени"
	@echo "  make shell   - Перейти в контейнер PHP"
	@echo "  make seed    - Наполнить базу тестовыми данными (Seed)"
	@echo "  make fresh   - Сбросить БД и запустить миграции с сидами"
	@echo "  make test    - Запустить tests (Pest)"
	@echo "  make queue   - Запустить Laravel QUEUE"

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


# Команды для очередей (Queue)
queue:
# 	$(COMPOSE) exec app php artisan migrate
# 	@echo "Создание таблицы jobs..."
# 	$(COMPOSE) exec app php artisan queue:table
	@echo "Запуск воркера очередей..."
	$(COMPOSE) exec app php artisan queue:work

test:
	$(COMPOSE) exec app php artisan test
