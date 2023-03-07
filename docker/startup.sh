#!/bin/bash

php-fpm &

cd /var/www/html

# Wait for MySQL service to be available
until nc -z -v -w30 db 3306; do
    echo "Waiting for MySQL server..."
    sleep 5
done

php artisan migrate
php artisan db:seed
php artisan jwt:secret

tail -f /dev/null
