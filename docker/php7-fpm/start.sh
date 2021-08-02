#!/bin/bash

set -e

if [ "$1" = 'php-fpm' ]; then
  while ! nc -z ${DATABASE_HOST} ${DATABASE_PORT};
  do
    echo sleeping;
    sleep 1;
  done;
  cd /var/www
  composer build
fi

exec "$@"