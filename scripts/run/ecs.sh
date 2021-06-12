#!/bin/bash

RED='\033[1;31m'
YELLOW='\033[1;33m'
GREEN='\033[0;32m'
BLUE='\033[1;34m'
NC='\033[0m' # No Color

### Helpers ###
read_var() {
    VAR=$(grep "^$1=" $2 | xargs)
    IFS="=" read -ra VAR <<< "$VAR"
    IFS=" "
    echo ${VAR[1]}
}

BASE_DIR=$(pwd)

SERVICES_TO_RUN_THROUGH=(
  $(read_var SERVICE_NAME .env.local)
)

echo -e "${BLUE}Запуск автоматического фикса easy-coding-standard${NC}"

# Прогон тестов для всех сервисов, либо, если передан параметр $s, то для сервисов с $s в названии
for i in "${SERVICES_TO_RUN_THROUGH[@]}"
do
  if [[ -z ${s} || "$i" == *"$s"* ]]; then
    echo -e "${BLUE}Выполнение easy-coding-standard для $i${NC}"
    ((docker-compose exec -T php-fpm ./vendor/bin/ecs check src)
      || (echo -e "${RED}FATAL ERROR\nОшибка при попытке выполнить фиксы easy-coding-standard${NC}" && exit))
  fi
done


echo -e "${GREEN}Конец автоматического фикса easy-coding-standard${NC}"