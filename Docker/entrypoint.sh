#!/bin/bash

if [ ! -f "vendor/autoload.php" ]; then
    echo "Running composer install..."
    composer install --no-progress --no-interaction || {
        echo "Composer install failed."
        exit 1
    }
else
    echo "vendor/autoload.php exists."
fi

if [ ! -f ".env" ]; then
    echo "Creating env file..."
    cp .env.example .env || {
        echo "Copying .env.example to .env failed."
        exit 1
    }
else
    echo ".env file exists."
fi

php artisan migrate
php artisan key:generate
php artisan storage:link
php artisan cache:clear
php artisan config:clear
php artisan route:clear

php artisan serve --port=$PORT --host=0.0.0.0 --env=.env

exec docker-php-entrypoint "$@"
