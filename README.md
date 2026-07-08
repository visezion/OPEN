# OPEN

This project is ready to run with Docker. If you want the easiest deployment path, use the commands below exactly as written.

## Deploy On A Linux Server

Install Docker and the Compose plugin first. On Ubuntu, run:

```bash
sudo apt update
sudo apt install -y ca-certificates curl git
sudo install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
sudo chmod a+r /etc/apt/keyrings/docker.gpg
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
  $(. /etc/os-release && echo \"$VERSION_CODENAME\") stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
sudo apt update
sudo apt install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
sudo systemctl enable --now docker
```

Clone the project and start it:

```bash
git clone https://github.com/visezion/OPEN.git
cd OPEN
chmod +x scripts/docker-deploy.sh
sudo bash ./scripts/docker-deploy.sh
```

Open the app in your browser:

```text
http://YOUR-SERVER-IP:8080
```

The first run will:

- create `.env` from `.env.docker.example`
- generate `APP_KEY`
- build the Docker image
- start Apache, PHP, MySQL, Redis, queue worker, scheduler, and Mailpit
- run Laravel migrations automatically

## Fresh Install With Seed Data

If you need seed data on a brand new database, run:

```bash
cd OPEN
sudo bash ./scripts/docker-deploy.sh --seed
```

## Daily Commands

Start or rebuild:

```bash
cd OPEN
sudo bash ./scripts/docker-deploy.sh
```

Stop the app:

```bash
cd OPEN
sudo docker compose down
```

Stop the app and delete database data:

```bash
cd OPEN
sudo docker compose down -v
```

See live logs:

```bash
cd OPEN
sudo docker compose logs -f app
```

Open a shell inside the app container:

```bash
cd OPEN
sudo docker compose exec app bash
```

Run tests:

```bash
cd OPEN
sudo docker compose exec app php artisan test --without-tty
```

## Important Ports

- App: `8080`
- Mailpit web UI: `8025`
- MySQL: `3306`
- Redis: `6379`

Change them in `.env` if your server already uses those ports.

## Files That Matter

- `.env.docker.example`: default Docker environment values
- `.env`: your live environment file, created automatically on first run
- `docker-compose.yml`: service definitions
- `scripts/docker-deploy.sh`: one-command deploy script

## Troubleshooting

If the app does not start, run:

```bash
cd OPEN
sudo docker compose ps
sudo docker compose logs --tail=100 app
```

If you changed `.env`, restart the stack:

```bash
cd OPEN
sudo docker compose down
sudo bash ./scripts/docker-deploy.sh
```

If you want a completely clean reinstall:

```bash
cd ..
sudo docker compose -f OPEN/docker-compose.yml down -v --remove-orphans || true
sudo rm -rf OPEN
git clone https://github.com/visezion/OPEN.git
cd OPEN
chmod +x scripts/docker-deploy.sh
sudo bash ./scripts/docker-deploy.sh
```
