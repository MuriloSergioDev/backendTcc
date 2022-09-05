FROM php:8.0-apache

USER root

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
        libpng-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        git \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        zip \
        curl \
        libcurl3-dev \
        unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-ext-install intl \
    && docker-php-ext-install curl \
    && docker-php-ext-install calendar && docker-php-ext-configure calendar \
    && docker-php-source delete


COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - && apt-get install -y nodejs

COPY ./package*.json ./

RUN npm install

ARG user
ARG uid

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && chown -R $user:$user /home/$user

USER $user
