#!/bin/bash

cd /var/www
php bin/console file-processor:start "$1"