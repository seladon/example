#!/bin/bash

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

function printTable()
{
    local -r delimiter="${1}"
    local -r data="$(removeEmptyLines "${2}")"

    if [[ "${delimiter}" != '' && "$(isEmptyString "${data}")" = 'false' ]]
    then
        local -r numberOfLines="$(wc -l <<< "${data}")"

        if [[ "${numberOfLines}" -gt '0' ]]
        then
            local table=''
            local i=1

            for ((i = 1; i <= "${numberOfLines}"; i = i + 1))
            do
                local line=''
                line="$(sed "${i}q;d" <<< "${data}")"

                local numberOfColumns='0'
                numberOfColumns="$(awk -F "${delimiter}" '{print NF}' <<< "${line}")"

                # Add Line Delimiter

                if [[ "${i}" -eq '1' ]]
                then
                    table="${table}$(printf '%s#+' "$(repeatString '#+' "${numberOfColumns}")")"
                fi

                # Add Header Or Body

                table="${table}\n"

                local j=1

                for ((j = 1; j <= "${numberOfColumns}"; j = j + 1))
                do
                    table="${table}$(printf '#| %s' "$(cut -d "${delimiter}" -f "${j}" <<< "${line}")")"
                done

                table="${table}#|\n"

                # Add Line Delimiter

                if [[ "${i}" -eq '1' ]] || [[ "${numberOfLines}" -gt '1' && "${i}" -eq "${numberOfLines}" ]]
                then
                    table="${table}$(printf '%s#+' "$(repeatString '#+' "${numberOfColumns}")")"
                fi
            done

            if [[ "$(isEmptyString "${table}")" = 'false' ]]
            then
                echo -e "${table}" | column -s '#' -t | awk '/^\+/{gsub(" ", "-", $0)}1'
            fi
        fi
    fi
}

function removeEmptyLines()
{
    local -r content="${1}"

    echo -e "${content}" | sed '/^\s*$/d'
}

function repeatString()
{
    local -r string="${1}"
    local -r numberToRepeat="${2}"

    if [[ "${string}" != '' && "${numberToRepeat}" =~ ^[1-9][0-9]*$ ]]
    then
        local -r result="$(printf "%${numberToRepeat}s")"
        echo -e "${result// /${string}}"
    fi
}

function isEmptyString()
{
    local -r string="${1}"

    if [[ "$(trimString "${string}")" = '' ]]
    then
        echo 'true' && return 0
    fi

    echo 'false' && return 1
}

function trimString()
{
    local -r string="${1}"

    sed 's,^[[:blank:]]*,,' <<< "${string}" | sed 's,[[:blank:]]*$,,'
}


### INFO ###
SERVICE="
SERVICE, DOMAIN, SWAGGER
${SERVICE_NAME} , http://localhost:$(read_var NGINX_PORT .env.local), http://localhost:$(read_var NGINX_PORT .env.local)/api/docs/?url=/api/docs/file/app-openapi.yaml,
"

DEPENDENCIES="
SERVICE, DOMAIN, PORT
redis , redis, $(read_var REDIS_PORT .env.local),
memcached , memcached, $(read_var MEMCACHED_PORT .env.local),
mysql , mysql, $(read_var MYSQL_PORT .env.local),
nginx , nginx-router, $(read_var NGINX_PORT .env.local),
"

echo -e "${YELLOW}Service${NC}"
printTable ',' "${SERVICE}"

echo -e "${YELLOW}Dependencies${NC}"
printTable ',' "${DEPENDENCIES}"
