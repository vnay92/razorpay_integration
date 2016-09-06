#!/bin/bash

echo "Getting System Dependencies"

cp .env.example .env
composer install
php artisan migrate:refresh
