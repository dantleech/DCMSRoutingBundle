#!/bin/bash

SCRIPT_DIR="$PWD"

mysql -e "DROP DATABASE dcms_routing_test" -u root
mysql -e "CREATE DATABASE dcms_routing_test" -u root

${SCRIPT_DIR}/vendor/doctrine/phpcr-odm/bin/phpcr jackalope:init:dbal
${SCRIPT_DIR}/vendor/doctrine/phpcr-odm/bin/phpcr doctrine:phpcr:register-system-node-types
