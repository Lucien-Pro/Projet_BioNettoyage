FROM php:8.2-apache

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installation des extensions PHP nécessaires et dépendances LDAP et OpenSSL
RUN apt-get update && \
    apt-get install -y libldap2-dev git unzip libzip-dev openssl && \
    docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ && \
    docker-php-ext-install pdo pdo_mysql ldap zip

# Activation de SSL et génération d'un certificat auto-signé pour le développement
RUN a2enmod ssl && a2ensite default-ssl
RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /etc/ssl/private/apache-selfsigned.key \
    -out /etc/ssl/certs/apache-selfsigned.crt \
    -subj "/C=FR/ST=France/L=Paris/O=BioNettoyage/OU=IT/CN=192.0.0.24"

# Mise à jour de la configuration SSL d'Apache pour utiliser nos certificats et le bon DocumentRoot
RUN sed -i 's|/etc/ssl/certs/ssl-cert-snakeoil.pem|/etc/ssl/certs/apache-selfsigned.crt|g' /etc/apache2/sites-available/default-ssl.conf
RUN sed -i 's|/etc/ssl/private/ssl-cert-snakeoil.key|/etc/ssl/private/apache-selfsigned.key|g' /etc/apache2/sites-available/default-ssl.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/default-ssl.conf

# Configuration spécifique LDAP pour autoriser le SSL sans vérification stricte du certificat
RUN mkdir -p /etc/ldap && echo "TLS_REQCERT never" >> /etc/ldap/ldap.conf

# Activation de mod_rewrite pour Laravel
RUN a2enmod rewrite

# Changement du DocumentRoot vers /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Configuration du répertoire de travail
WORKDIR /var/www/html

# Modification des permissions pour Laravel
RUN chown -R www-data:www-data /var/www/html
