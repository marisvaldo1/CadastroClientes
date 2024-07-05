FROM php:7.1-apache

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo_mysql

# Instalar Composer 2.2
RUN curl -sS https://getcomposer.org/download/2.2.18/composer.phar -o /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install

EXPOSE 8000
