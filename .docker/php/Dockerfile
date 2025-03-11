# Use PHP 8.1 FPM with Alpine as the base image
FROM php:8.1.23-fpm-alpine

# Set maintainer information
LABEL maintainer="HoangThong <phamhoangthongxyz@gmail.com>"

# Set non-interactive mode for package installation
ARG DEBIAN_FRONTEND=noninteractive

# Use alternative Alpine mirrors to avoid network issues
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories

# Update system and install necessary dependencies
RUN apk update --update-cache && apk upgrade && apk add --no-cache \
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
  openssl-dev \
  postgresql-dev \
  libpng-dev \
  libjpeg-turbo-dev \
  freetype-dev \
  libwebp-dev \
  libmemcached-dev \
  zlib-dev

# Install PHP extensions
RUN docker-php-ext-install \
  bcmath \
  mbstring \
  intl \
  opcache \
  pdo \
  pdo_pgsql \
  pgsql

# Install Memcached
RUN pecl install memcached && docker-php-ext-enable memcached

# Configure and install GD extension
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) gd

# Set working directory
WORKDIR /var/www/html