# Use PHP 7.3 FPM with Alpine as the base image
FROM php:7.3.23-fpm-alpine

# Set maintainer information
LABEL maintainer="HoangThong <phamhoangthongxyz@gmail.com>"

# Set non-interactive mode for package installation
ARG DEBIAN_FRONTEND=noninteractive

# Update system and install necessary dependencies
RUN apk update && apk upgrade && apk add --no-cache \
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
  libwebp-dev \
  libmemcached-dev 

# Install PHP extensions
RUN docker-php-ext-install \
  bcmath \
  mbstring \
  intl \
  opcache \
  pdo \
  pdo_pgsql \
  pgsql

# install Memcached
RUN pecl install memcached && docker-php-ext-enable memcached

# Configure and install GD extension (remove --with-webp for PHP 7.3)
RUN docker-php-ext-configure gd \
  --with-freetype-dir=/usr/include/ \
  --with-jpeg-dir=/usr/include/ \
  && docker-php-ext-install -j$(nproc) gd

# Set working directory
WORKDIR /var/www/html
