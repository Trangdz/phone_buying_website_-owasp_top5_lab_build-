FROM php:8.1-fpm-alpine

ARG workdir=/var/www

WORKDIR $workdir
RUN apk update && \
    apk add --no-cache \
        libzip-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        libwebp-dev \
        libxpm-dev \
        freetype-dev \
        zip \
        git \
        unzip\
        bash \
        dos2unix \
        nodejs \
        npm

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN docker-php-ext-install exif
RUN docker-php-ext-install zip
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

COPY ./docker/php/php.ini /usr/local/etc/php

COPY . .

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY docker-start.sh /var/www/

RUN chmod +x /var/www/docker-start.sh

# Cài đặt Node.js và npm để build frontend assets cho Laravel UI Auth
RUN npm install \
    && npm run build

CMD ["/var/www/docker-start.sh"]