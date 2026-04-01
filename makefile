.PHONY: up down shell migrate fresh install setup

# Ovo su vam samo skracenice da ne bi kucali sve ovo.. tipa umjesto docker compose up -d samo kucate make up

up:
	docker compose up -d

down:
	docker compose down

install:
	docker compose exec app composer install

migrate:
	docker compose exec app php artisan migrate

fresh:
	docker compose exec app php artisan migrate:fresh --seed

shell:
	docker compose exec app bash

tinker:
	docker compose exec app php artisan tinker

setup:
	cp .env.example .env
	docker compose exec app php artisan key:generate
