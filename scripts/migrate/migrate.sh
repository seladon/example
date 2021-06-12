#!/bin/bash

YELLOW='\033[1;33m'
GREEN='\033[0;32m'
BLUE='\033[1;34m'
NC='\033[0m' # No Color

# --- logistics-deliveries --- #
echo -e "${YELLOW}Migrating ${SERVICE_NAME} service${NC}"
docker-compose -f docker-compose.yml \
run --rm --no-deps php-fpm bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
