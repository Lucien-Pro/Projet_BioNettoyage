#!/bin/bash

# Script d'installation automatique de Docker et Docker Compose pour Ubuntu/Debian
# Usage: sudo ./install_docker.sh

set -e

echo "--- Mise à jour du système ---"
sudo apt-get update
sudo apt-get upgrade -y

echo "--- Installation des dépendances ---"
sudo apt-get install -y \
    ca-certificates \
    curl \
    gnupg \
    lsb-release \
    git

echo "--- Ajout de la clé GPG officielle de Docker ---"
sudo mkdir -p /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg

echo "--- Configuration du dépôt Docker ---"
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
  $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

echo "--- Installation de Docker ---"
sudo apt-get update
sudo apt-get install -y docker-ce docker-ce-cli containerd.io docker-compose-plugin

echo "--- Configuration des permissions (permet d'utiliser docker sans sudo) ---"
sudo usermod -aG docker $USER

echo "--- Installation de Docker Compose (V2 Standalone) ---"
sudo apt-get install -y docker-compose

echo "--------------------------------------------------------"
echo " Installation terminée ! "
echo " IMPORTANT : Veuillez vous déconnecter et vous reconnecter "
echo " pour que les changements de groupe (docker) prennent effet."
echo "--------------------------------------------------------"
