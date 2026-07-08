#!/usr/bin/env bash
set -euo pipefail

root_dir="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "${root_dir}"

usage() {
    cat <<'EOF'
Usage: ./scripts/docker-deploy.sh [--seed]

Options:
  --seed    Run `php artisan db:seed --force` during container bootstrap.
EOF
}

require_command() {
    if ! command -v "$1" >/dev/null 2>&1; then
        echo "Missing required command: $1" >&2
        exit 1
    fi
}

resolve_docker_cmd() {
    if command -v docker >/dev/null 2>&1; then
        if docker info >/dev/null 2>&1; then
            DOCKER_CMD=(docker)
            return
        fi
    fi

    if command -v sudo >/dev/null 2>&1 && sudo -n docker info >/dev/null 2>&1; then
        DOCKER_CMD=(sudo docker)
        return
    fi

    if command -v sudo >/dev/null 2>&1; then
        echo "Docker requires elevated privileges. You may be prompted for your sudo password." >&2
        sudo docker info >/dev/null
        DOCKER_CMD=(sudo docker)
        return
    fi

    echo "Docker is installed but not accessible to the current user." >&2
    exit 1
}

update_env_value() {
    local key="$1"
    local value="$2"
    local tmp_file
    tmp_file="$(mktemp)"

    awk -v key="${key}" -v value="${value}" '
        BEGIN { found = 0 }
        index($0, key "=") == 1 {
            print key "=" value
            found = 1
            next
        }
        { print }
        END {
            if (found == 0) {
                print key "=" value
            }
        }
    ' .env > "${tmp_file}"

    mv "${tmp_file}" .env
}

ensure_env_file() {
    if [[ ! -f .env ]]; then
        cp .env.docker.example .env
        echo "Created .env from .env.docker.example"
    fi
}

ensure_app_key() {
    if grep -Eq '^APP_KEY=base64:' .env; then
        return
    fi

    local app_key
    app_key="$("${DOCKER_CMD[@]}" run --rm php:8.2-cli php -r 'echo "base64:".base64_encode(random_bytes(32));')"
    update_env_value "APP_KEY" "${app_key}"

    echo "Generated APP_KEY in .env"
}

apply_seed_flag() {
    local should_seed="$1"
    update_env_value "LARAVEL_RUN_SEEDERS" "${should_seed}"
}

seed_flag="false"

while (($#)); do
    case "$1" in
        --seed)
            seed_flag="true"
            shift
            ;;
        -h|--help)
            usage
            exit 0
            ;;
        *)
            echo "Unknown option: $1" >&2
            usage
            exit 1
            ;;
    esac
done

require_command docker
resolve_docker_cmd
ensure_env_file
ensure_app_key
apply_seed_flag "${seed_flag}"

"${DOCKER_CMD[@]}" compose build app
"${DOCKER_CMD[@]}" compose up -d

echo "Containers are starting. Current status:"
"${DOCKER_CMD[@]}" compose ps

echo
echo "OPEN should become available at the APP_URL configured in .env."
echo "Mailpit UI is available at http://localhost:${MAILPIT_WEB_PORT:-8025} unless you changed the port."
