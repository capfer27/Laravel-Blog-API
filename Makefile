# Variables
COMPOSE = docker compose

# Default command
help:
	@echo "Available commands:"
	@echo "  make up      - Start the containers"
	@echo "  make down    - Stop the containers"
	@echo "  make restart - Restart and clear everything (Nuclear option)"
	@echo "  make logs    - Show real-time logs"
	@echo "  make shell   - Jump into the PHP container"
	@echo "  make test    - Run Laravel tests (Pest/PHPUnit)"

up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

# This handles the cleanup we did manually earlier
restart:
	$(COMPOSE) down -v
	rm -rf ./postgres_data
	$(COMPOSE) up -d --build

logs:
	$(COMPOSE) logs -f

shell:
	$(COMPOSE) exec app /bin/sh

test:
	$(COMPOSE) exec app php artisan test
