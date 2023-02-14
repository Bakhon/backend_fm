#!/bin/bash

php artisan migrate --force

php artisan config:cache

exec "$@"
