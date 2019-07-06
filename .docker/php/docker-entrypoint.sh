#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ] || [ "$1" = 'bin/console' ]; then
    if [ "$APP_ENV" != 'prod' ]; then
        composer install
    fi
    if [ "$APP_ENV" == 'prod' ]; then
        composer install --no-dev
    fi
    bin/console assets:install
    bin/console doctrine:schema:update -f
    bin/console doctrine:fixtures:load --group=demo

	# Permissions hack because setfacl does not work on Mac and Windows
	chown -R www-data var
fi

exec docker-php-entrypoint "$@"
