.PHONY: env-setup install up down restart clean

ifneq ("$(wildcard ./.env)","")
	include .env
endif

env-setup:
	@if [ ! -f .env ]; then \
		echo "Creating .env file from .env.example"; \
		cp .env.example .env; \
	else \
		echo ".env file already exists"; \
	fi


install: env-setup up

up:
	docker-compose up -d

down:
	docker-compose down

restart: down up

clean:
	docker-compose down -v
