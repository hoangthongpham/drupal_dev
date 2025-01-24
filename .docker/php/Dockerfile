FROM php:8.2-fpm-alpine

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
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libwebp-dev

# Install PHP extensions
RUN docker-php-ext-install \
    bcmath \
    mbstring \
    intl \
    opcache \
    pdo \
    pdo_pgsql \
    pgsql

# Configure and install GD extension
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd

# Set working directory
WORKDIR /var/www/html
