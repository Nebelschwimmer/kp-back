#!/bin/bash
set -e

whoami


if [ ! -d "~/kp-back/.git" ]; then
  git clone https://github.com/Nebelschwimmer/kp-back.git ~/kp-back
fi

cd ~/kp-back
git pull origin main


docker compose down
docker compose up -d