FROM php:8.2-apache

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y unzip git \
    && docker-php-ext-install pdo_mysql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer