FROM php:8.2-fpm-alpine

ARG user
ARG group
ARG uid
ARG gid

WORKDIR /var/www

RUN apk update && apk add --no-cache \
    composer \
    curl git unzip \
    libxml2-dev \
    oniguruma-dev \
    postgresql-dev \
    php-tokenizer php-dom php-session php-xmlwriter php-fileinfo php-xml git

RUN docker-php-ext-install \
    pcntl \
    pdo \
    pdo_pgsql \
    mbstring \
    xml \
    dom

RUN addgroup --gid $gid $group && adduser --disabled-password -G $group --uid $uid $user

USER $user