FROM php:8.2-fpm-alpine

ARG DEPS="bash nano curl"
RUN apk update && apk add --no-cache $DEPS

ARG DEPS_PHP="xdebug http pdo_mysql zip intl redis sockets spx opcache gd"
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod u+x /usr/local/bin/install-php-extensions \
    && sync \
    && install-php-extensions $DEPS_PHP

COPY ./conf/opcache.ini /usr/local/etc/php/conf.d/

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www
RUN chown -R www-data:www-data /var/www
