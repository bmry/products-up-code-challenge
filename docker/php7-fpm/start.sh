#!/bin/bash

cd /var/www
composer install
php bin/console file-processor:start "$1"