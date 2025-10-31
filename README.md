# OPEN (Laravel)

Production‑ready Laravel application with a modular Churchly package. This README covers local setup and multiple deployment options, including a self‑hosted GitHub Actions runner on Hestia/cPanel servers (no public IP required).

## Quick Start

1) Clone and enter the project
- git clone https://github.com/visezion/OPEN.git
- cd OPEN

2) PHP dependencies
- composer install --prefer-dist --no-interaction

3) Environment file
- cp .env.example .env
- php artisan key:generate

4) Database config
- Edit .env to set DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD

5) Migrate and link storage
- php artisan migrate --force
- php artisan storage:link

6) Cache config/routes/views for performance
- php artisan config:cache
- php artisan route:cache
- php artisan view:cache

7) Run the app (local)
- php artisan serve

Notes
- If you use queues/scheduling, configure a queue worker and crontab (see below).

## Requirements

- PHP 8.2+
- Composer 2.x
- MySQL 8.x or MariaDB 10.4+
- Node 18+ (only if you build frontend assets)
- Web server: Nginx or Apache

## Environment Variables (common)

These are the most important .env keys (set per environment):
- APP_NAME, APP_ENV, APP_KEY, APP_DEBUG, APP_URL
- DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
- CACHE_DRIVER, QUEUE_CONNECTION, SESSION_DRIVER
- FILESYSTEM_DISK (usually public), MAIL_*, LOG_LEVEL

Optional (used by modules/integrations):
- SANCTUM_STATEFUL_DOMAINS, SESSION_DOMAIN
- BROADCAST_DRIVER, PUSHER_* (if used)

## Database, Files, and Permissions

- Run migrations any time you pull new schema changes:
  - php artisan migrate --force
- Public storage symlink:
  - php artisan storage:link
- Ensure web user can write to storage/ and bootstrap/cache/:
  - chown -R www-data:www-data storage bootstrap/cache
  - chmod -R ug+rw storage bootstrap/cache

## Caches and Configuration

- Rebuild caches after changing .env or routes/views:
  - php artisan config:clear && php artisan route:clear && php artisan view:clear
  - php artisan config:cache && php artisan route:cache && php artisan view:cache

## Queues and Scheduler (optional)

- Queue worker (supervisor example):
  - php artisan queue:work --tries=3 --sleep=1
- Scheduler (crontab entry):
  - * * * * * cd /path/to/OPEN && php artisan schedule:run >> /dev/null 2>&1

## Deployment Options

### A) Self‑Hosted GitHub Actions Runner (recommended for Hestia/cPanel behind Cloudflare)

Use a runner installed on the server so the server pulls changes locally. No public IP or SSH from GitHub is required.

1) Install a GitHub Actions Runner on your server
- Repo → Settings → Actions → Runners → New self‑hosted runner → Linux
- Follow the install steps shown by GitHub
- Give it a label you’ll use in the workflow (example: hestia)

2) Set repository secrets
- DEPLOY_PATH: absolute folder containing the app (for example: /home/USERNAME/web/DOMAIN/public_html)
- Optionally set PHP_FPM_SERVICE/WEBSERVER_SERVICE if you want the workflow to reload services

3) Workflow overview
- The workflow in .github/workflows/php.yml has two jobs:
  - build: runs on ubuntu‑latest to validate/install
  - deploy: runs on your self‑hosted runner and executes:
    - cd "$DEPLOY_PATH"
    - git fetch --all && git reset --hard origin/main
    - composer install --no-interaction --prefer-dist --optimize-autoloader
    - php artisan migrate --force
    - php artisan config:cache && php artisan route:cache && php artisan view:cache
    - Reload php-fpm/nginx if configured

4) Common server issues
- composer: command not found → The workflow sets up PHP+Composer; if your runner isolates PATH, it falls back to a local composer.phar install.
- Permission errors → Fix ownership on storage/ and bootstrap/cache.
- 500 after deploy → Clear and rebuild caches, verify .env, and check logs in storage/logs/.

### B) SSH Deploy (requires publicly reachable IP/hostname)

If the server has a public IP or DNS, you can deploy from a GitHub‑hosted runner using appleboy/ssh‑action.

Required secrets:
- SSH_HOST, SSH_USER, SSH_KEY, DEPLOY_PATH
- Optional: SSH_PORT, SSH_FINGERPRINT

Sample script:
- cd $DEPLOY_PATH
- git pull origin main
- composer install --no-interaction --prefer-dist --optimize-autoloader
- php artisan migrate --force
- php artisan config:cache && php artisan route:cache && php artisan view:cache

### C) HestiaCP Git Webhook (no Actions)

You can also configure Hestia’s built‑in Git deployment to auto‑pull on push:
- Add repo/branch under the domain → set post‑deploy script to run composer + artisan commands.

## Troubleshooting

- Route cache errors “another route has already been assigned name …”
  - This happens when the same named route is registered twice. We updated Churchly routes to avoid duplicates by excluding overlapping resource routes.
  - Fix by reviewing custom routes vs Route::resource declarations and clearing route caches.
- DNS lookup failed during SSH deploy
  - Hosted runners can’t resolve private hostnames. Use self‑hosted runner or a public IP/DNS.
- 419/CSRF errors after deploy
  - Ensure APP_URL and session/cookie domains are correct; clear caches.

## Useful Commands

- php artisan tinker
- php artisan migrate:fresh --seed
- php artisan queue:work --tries=3
- php artisan optimize:clear

## Contributing

1) Create a feature branch
2) Follow PSR‑12 / Laravel conventions
3) Add focused changes and tests where applicable
4) Open a PR to main

## License

Proprietary – not for redistribution unless permitted by the owner.
