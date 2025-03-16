.PHONY: install up down restart clean

install: up
	composer install
	bun i
	bun run build

up:
	docker-compose up -d
	
down:
	docker-compose down

restart: down up

clean:
	docker-compose down -v
