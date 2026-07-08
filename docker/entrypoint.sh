#!/usr/bin/env bash
set -euo pipefail

role="${CONTAINER_ROLE:-app}"
app_root="/var/www/html"
bootstrap_marker="${app_root}/storage/framework/.bootstrapped"

log() {
    printf '[open:%s] %s\n' "${role}" "$*"
}

artisan() {
    php artisan "$@" --no-interaction
}

ensure_runtime_directories() {
    mkdir -p \
        "${app_root}/bootstrap/cache" \
        "${app_root}/storage/framework/cache" \
        "${app_root}/storage/framework/sessions" \
        "${app_root}/storage/framework/views" \
        "${app_root}/storage/logs" \
        "${app_root}/uploads"

    chown -R www-data:www-data "${app_root}/bootstrap/cache" "${app_root}/storage" "${app_root}/uploads"
    chmod -R ug+rw "${app_root}/bootstrap/cache" "${app_root}/storage" "${app_root}/uploads"
}

ensure_app_key() {
    if [[ -n "${APP_KEY:-}" ]]; then
        return
    fi

    export APP_KEY="base64:$(php -r 'echo base64_encode(random_bytes(32));')"
    log "APP_KEY was not provided; generated an ephemeral key for this container."
}

wait_for_database() {
    if [[ "${DB_CONNECTION:-}" != "mysql" ]]; then
        return
    fi

    log "Waiting for MySQL at ${DB_HOST:-db}:${DB_PORT:-3306}..."

php <<'PHP'
<?php
$host = getenv('DB_HOST') ?: 'db';
$port = getenv('DB_PORT') ?: '3306';
$database = getenv('DB_DATABASE') ?: 'open';
$username = getenv('DB_USERNAME') ?: 'open';
$password = getenv('DB_PASSWORD') ?: 'open_secret';
$retries = 60;
$stdout = fopen('php://stdout', 'w');
$stderr = fopen('php://stderr', 'w');

for ($attempt = 1; $attempt <= $retries; $attempt++) {
    try {
        new PDO(
            "mysql:host={$host};port={$port};dbname={$database}",
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 3,
            ]
        );

        fwrite($stdout, "MySQL connection ready.\n");
        exit(0);
    } catch (Throwable $exception) {
        fwrite($stderr, "Waiting for MySQL ({$attempt}/{$retries}): {$exception->getMessage()}\n");
        sleep(2);
    }
}

fwrite($stderr, "MySQL did not become ready in time.\n");
exit(1);
PHP
}

bootstrap_laravel() {
    log "Running Laravel bootstrap tasks."

    artisan package:discover --ansi
    artisan storage:link || true

    if [[ "${LARAVEL_RUN_MIGRATIONS:-true}" == "true" ]]; then
        artisan migrate --force --graceful
    fi

    if [[ "${LARAVEL_RUN_SEEDERS:-false}" == "true" ]]; then
        artisan db:seed --force
    fi

    if [[ "${LARAVEL_CACHE_CONFIG:-true}" == "true" ]]; then
        artisan optimize:clear
        artisan config:cache
        artisan route:cache
        artisan view:cache
    fi

    touch "${bootstrap_marker}"
    chown www-data:www-data "${bootstrap_marker}"
}

wait_for_application_bootstrap() {
    if [[ "${role}" == "app" ]]; then
        return
    fi

    local attempts=60
    local counter=1

    while [[ ! -f "${bootstrap_marker}" && ${counter} -le ${attempts} ]]; do
        log "Waiting for application bootstrap marker (${counter}/${attempts})."
        sleep 2
        counter=$((counter + 1))
    done
}

start_queue_worker() {
    local queue_connection="${LARAVEL_QUEUE_CONNECTION:-${QUEUE_CONNECTION:-redis}}"
    exec gosu www-data php artisan queue:work "${queue_connection}" --tries=3 --sleep=1 --timeout=120 --no-interaction
}

start_scheduler() {
    exec gosu www-data php artisan schedule:work --no-interaction
}

main() {
    cd "${app_root}"

    ensure_runtime_directories
    ensure_app_key
    wait_for_database
    wait_for_application_bootstrap
    bootstrap_laravel

    case "${role}" in
        app)
            exec apache2-foreground
            ;;
        queue)
            start_queue_worker
            ;;
        scheduler)
            start_scheduler
            ;;
        *)
            exec "$@"
            ;;
    esac
}

main "$@"
