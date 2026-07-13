#!/usr/bin/env bash
set -euo pipefail

PORT="${PORT:-10000}"

if [ -n "${RENDER_EXTERNAL_URL:-}" ]; then
  export APP_URL="${RENDER_EXTERNAL_URL}"
fi

export APP_URL="${APP_URL:-https://kiu-career-hub.onrender.com}"
export APP_URL="${APP_URL//\\/}"
export APP_URL="${APP_URL%/}"

export APP_ENV="${APP_ENV:-production}"
export APP_DEBUG="${APP_DEBUG:-false}"
export LOG_CHANNEL="${LOG_CHANNEL:-stderr}"

mkdir -p \
  database \
  storage/framework/cache \
  storage/framework/sessions \
  storage/framework/views \
  storage/logs \
  bootstrap/cache

touch database/database.sqlite
chmod -R 775 storage bootstrap/cache database || true

php artisan migrate --force --no-interaction
php artisan db:seed --force --no-interaction || true
php artisan storage:link --force >/dev/null 2>&1 || true
php artisan config:clear >/dev/null 2>&1 || true

# router.php lets /css and /images load as static files
exec php -S "0.0.0.0:${PORT}" -t public public/router.php
