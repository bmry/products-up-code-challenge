DOCKER_COMPOSE?=docker-compose
EXEC?=$(DOCKER_COMPOSE) exec php
COMPOSER=$(EXEC) composer
CONSOLE=bin/console

.DEFAULT_GOAL := help
.PHONY: help install up stop ps sh logs cache-clear create-symfony-api create-symfony-website orm maker entity controller git

help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

### Docker commands

up: 													## Start all containers
	$(DOCKER_COMPOSE) up -d

ps:														## List all containers
	$(DOCKER_COMPOSE) ps

stop:													## Stop all containers
	$(DOCKER_COMPOSE) stop

stop-all:											    ## Stop all containers on your machine
	docker stop $(docker ps -q)

down:													## Stop and remove all containers, volumes and networks
	$(DOCKER_COMPOSE) down

rm:														## Remove all stopped containers, volumes and networks
	$(DOCKER_COMPOSE) rm

sh:														## Run shell inside php container
	$(EXEC) /bin/bash

entity: 												## Create symfony entity
	$(EXEC) php bin/console make:entity

controller:												## Create symfony controller
	$(EXEC) php bin/console make:controller

logs: 													## Show logs
	$(EXEC) tail -f var/logs/dev.log

cache-clear: 											## Clean cache
	$(EXEC) rm -rf var/cache/*

### Database commands

db-create:												## Create database
	$(EXEC) php bin/console doctrine:database:create

db-diff:												## Generate migration
	$(EXEC) php bin/console doctrine:migrations:diff --formatted

db-migration:											## Create migration
	$(EXEC) php bin/console make:migration

db-migrate: 											## Run migrations
	$(EXEC) php bin/console doctrine:migrations:migrate
