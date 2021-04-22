FROM php:7.2.31-fpm-alpine3.12

RUN apk update && apk add --no-cache \
    nginx \
    composer \
    gettext \
    supervisor \
    #required by intl extension
    icu-dev && \
    docker-php-ext-install intl pdo_mysql opcache

RUN mkdir -p /run/php && mkdir -p /run/nginx

WORKDIR /app

COPY ./ /app
COPY .provision/etc /etc
COPY .provision/entrypoint.sh /entrypoint.sh

RUN composer install --no-dev --optimize-autoloader --no-suggest --no-interaction

ENTRYPOINT ["sh", "/entrypoint.sh"]
