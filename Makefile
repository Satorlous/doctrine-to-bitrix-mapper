# Executables (local)
DOCKER_COMPOSE = docker compose

# Docker containers
PHP_CONT = $(DOCKER_COMPOSE) exec -it php
DB_CONT = $(DOCKER_COMPOSE) exec -it db

# Executables
PHP      = $(PHP_CONT) php
COMPOSER = $(PHP_CONT) composer
SYMFONY  = $(PHP) bin/console

# Misc
.DEFAULT_GOAL = help
.PHONY        : help build up up-prod start start-prod restart restart-prod down logs sh sh-db composer vendor sf cc prune-dangling-volumes

## —— 🎵 🐳 The Symfony Docker Makefile 🐳 🎵 ——————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
build: ## Builds the Docker images
	@$(DOCKER_COMPOSE) --env-file .env --env-file .env.local --env-file .env.dev --env-file .env.dev.local build

build-prod: ## Builds the Docker images for production environment
	$(DOCKER_COMPOSE) -f 'docker-compose.yml' -f 'docker-compose.prod.yml' --env-file .env --env-file .env.local --env-file .env.prod --env-file .env.prod.local build

up: ## Start the docker hub in detached mode (no logs)
	@$(DOCKER_COMPOSE) --env-file .env --env-file .env.local --env-file .env.dev --env-file .env.dev.local up --detach

up-prod:
	$(DOCKER_COMPOSE) -f 'docker-compose.yml' -f 'docker-compose.prod.yml' --env-file .env --env-file .env.local --env-file .env.prod --env-file .env.prod.local up --detach

start: build up

start-prod: build-prod up-prod

down: ## Stop the docker hub
	@$(DOCKER_COMPOSE) down

restart: down up

restart-prod: down up-prod

logs: ## Show live logs
	@$(DOCKER_COMPOSE) logs $(c) --tail=0 --follow

sh: ## Connect to the PHP FPM container
	@$(PHP_CONT) sh

sh-db: ##Connect to DB container
	@$(DB_CONT) sh

## —— Composer 🧙 ——————————————————————————————————————————————————————————————
composer: ## Run composer, pass the parameter "c=" to run a given command, example: make composer c='req symfony/orm-pack'
	@$(eval c ?=)
	@$(COMPOSER) $(c)

vendor: ## Install vendors according to the current composer.lock file
vendor: c=install --prefer-dist --no-dev --no-progress --no-scripts --no-interaction
vendor: composer

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
sf: ## List all Symfony commands or pass the parameter "c=" to run a given command, example: make sf c=about
	$(eval c ?=)
	$(SYMFONY) $(c)

cc: c = cache:clear ## Clear the cache
cc: sf

ccr:
	$(SYMFONY) doctrine:cache:clear-metadata
	$(SYMFONY) doctrine:cache:clear-query
	$(SYMFONY) doctrine:cache:clear-result

prune-vols: ## Prune dangling volumes to free disk space
	@docker volume rm -f $$(docker volume ls -qf 'dangling=true')

prune-imgs: ## Prune dangling images to free disk space
	@docker image rm -f $$(docker images -qf 'dangling=true')
