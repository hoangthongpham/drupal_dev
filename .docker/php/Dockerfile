FROM php:8.3-fpm-alpine

LABEL maintainer="HoangThong <phamhoangthongxyz@gmail.com>"

ARG DEBIAN_FRONTEND=noninteractive

# Install necessary packages
RUN apk update && apk upgrade \
    && apk add --no-cache \
    openssl \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    autoconf \
    g++ \
    make \
    libcurl \
    curl-dev \
    openssl-dev \
    postgresql-dev

# Install PHP extensions
RUN docker-php-ext-install \
    bcmath \
    mbstring \
    intl \
    opcache \
    pdo \
    pdo_pgsql \
    pgsql \
    gd

# Install PHP GD extension
RUN apk add --no-cache libpng libpng-dev libjpeg-turbo libjpeg-turbo-dev freetype freetype-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN mkdir -p /var/www/html
