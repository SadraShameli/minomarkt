.PHONY: install build up down db clean composer-install env-setup deploy

ifneq ("$(wildcard ./.env)","")
	include .env
endif

install: env-setup build up db composer-install

env-setup:
	@if [ ! -f .env ]; then \
		echo "Creating .env file from .env.example"; \
		cp .env.example .env; \
	else \
		echo ".env file already exists"; \
	fi

build:
	docker-compose build nginx php-fpm

up:
	docker-compose up -d

down:
	docker-compose down

clean:
	docker-compose down -v

db:
	docker-compose exec -T mysql mysql -uroot -p${DB_PASSWORD} -e "CREATE DATABASE IF NOT EXISTS ${DB_NAME};"

composer-install:
	docker-compose exec php-fpm composer install

deploy:
	@echo "=== Running composer install ==="
	composer install
	@echo "=== Running npm install ==="
	npm install
	@echo "=== Building theme assets ==="
	npm run build
	@echo "=== Deploying theme to Hostinger ==="
	@echo "Loading environment variables..."
	$(eval include .env)
	@echo "Using SSH_HOST: ${SSH_HOST}, SSH_USER: ${SSH_USER}, SSH_DOMAIN: ${SSH_DOMAIN}"
	rsync -avz --delete -e "ssh -p ${SSH_PORT}" public/wp-content/themes/minomarkt/ ${SSH_USER}@${SSH_HOST}:domains/${SSH_DOMAIN}/public_html/wp-content/themes/minomarkt/
	@echo "=== Theme deployment complete ==="

%:
	@:
