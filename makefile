#!/usr/bin/make
include .env.local
export $(shell sed 's/=.*//' .env.local)
compose=docker-compose -f docker-compose.yml

.DEFAULT_GOAL := help

.PHONY: init
init: clean build start ci migrate ## Первичная установка или переустановка проекта

.PHONY: clean
clean: ## Остановка приложения с полной очисткой
		$(compose) down
		rm -rf ./.docker/data ./var ./vendor ./_docker/data/mysql

.PHONY: start
start: ## Запуск приложения
		$(compose) up -d

.PHONY: build
build: ## Принудительное обновление контейнеров
		$(compose) build

.PHONY: ci
ci: ## Установка composer-зависимостей
		$(compose) exec php-fpm composer install

.PHONY: dist
dist: ## Посмотреть что изменить
		./scripts/info/dist.sh

.PHONY: migrate
migrate: ## Установить миграции
		./scripts/migrate/migrate.sh

.PHONY: run-test ## Запуск всех тестов
run-test:
		./scripts/run/tests.sh $(s)

.PHONY: info ##вывести информацию о сервисе
info:
		./scripts/info/services-url.sh

.PHONY: run-analyze ##прогон psalm в сервисе
run-analyze:
		./scripts/run/psalm.sh $(s)

.PHONY: run-lint ##фикс кодстайла easy-coding-standard в серве
run-lint:
		./scripts/run/ecs.sh $(s)

.PHONY: run-test-coverage ##Запуск всех тестов
run-test-coverage:
		./scripts/run/tests-coverage.sh