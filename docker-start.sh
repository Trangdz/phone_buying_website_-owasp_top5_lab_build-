#!/bin/bash
composer install
php /var/www/html/artisan key:generate
php /var/www/html/artisan migrate

php-fpm
