FROM php:8.2-apache

# Installation des extensions PHP nécessaires et dépendances LDAP
RUN apt-get update && \
    apt-get install -y libldap2-dev && \
    docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ && \
    docker-php-ext-install pdo pdo_mysql ldap

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
