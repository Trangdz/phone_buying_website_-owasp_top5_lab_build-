#!/bin/bash
set -e

log() {
  echo "[docker-start.sh] $1"
}

log "=== Composer install ==="
composer install

log "=== Key generate ==="
php /var/www/artisan key:generate

log "=== Create storage link ==="
php /var/www/artisan storage:link

log "=== Migrate ==="
php /var/www/artisan migrate --force

log "=== Fix permissions ==="
chown -R www-data:www-data storage bootstrap/cache || true
chmod -R 775 storage bootstrap/cache || true

log "=== Starting PHP-FPM ==="
exec php-fpm
