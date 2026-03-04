#!/bin/sh
set -e

cd /var/www

if [ ! -f .env ] && [ -f .env.docker ]; then
  cp .env.docker .env
fi

if [ ! -f vendor/autoload.php ]; then
  composer install --no-interaction --prefer-dist
fi

if [ ! -f storage/logs/laravel.log ]; then
  mkdir -p storage/logs
  touch storage/logs/laravel.log
fi

APP_KEY_VALUE=$(grep -E '^APP_KEY=' .env 2>/dev/null | cut -d= -f2- || true)
if [ -z "$APP_KEY_VALUE" ]; then
  php artisan key:generate --force
fi

if [ "${RUN_MIGRATIONS}" = "true" ]; then
  php artisan migrate --force
fi

chown -R www-data:www-data storage bootstrap/cache || true

exec "$@"
