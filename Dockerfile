FROM php:8.0-apache

RUN apt-get update && apt-get install -y zip libzip-dev libpng-dev zlib1g-dev libicu-dev g++ git \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql gd zip intl \
    && rm -rf /var/lib/apt/lists/*

# Composer installation.
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer clear-cache
ENV PATH="${PATH}:/root/.composer/vendor/bin"

COPY . /var/www/html/

# Update the default apache site with the config we created.
ADD apache-config.conf /etc/apache2/sites-enabled/000-default.conf

# Authorize these folders to be edited
RUN chmod -R 777 /var/www/html/storage
RUN chmod -R 777 /var/www/html/bootstrap/cache

# Allow rewrite
RUN a2enmod rewrite
