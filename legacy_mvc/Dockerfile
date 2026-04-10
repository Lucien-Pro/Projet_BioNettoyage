FROM php:8.2-apache

# Installation des extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Activation de mod_rewrite pour les fichiers .htaccess
RUN a2enmod rewrite

# Configuration du répertoire de travail
WORKDIR /var/www/html

# Modification des permissions si nécessaire
RUN chown -R www-data:www-data /var/www/html
