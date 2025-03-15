.PHONY: env-setup install up down restart clean certs

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


install: env-setup certs up

up:
	docker-compose up -d

down:
	docker-compose down

restart: down up

clean:
	docker-compose down -v

certs:
	@mkdir -p .wordpress/certs
	@echo "Generating SSL certificates for minomarktnl.test and pma.minomarktnl.test..."
	@openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
		-keyout .wordpress/certs/minomarktnl.test.key \
		-out .wordpress/certs/minomarktnl.test.crt \
		-subj "/CN=minomarktnl.test" \
		-addext "subjectAltName = DNS:minomarktnl.test,DNS:pma.minomarktnl.test"
	@echo "SSL certificates generated successfully."
