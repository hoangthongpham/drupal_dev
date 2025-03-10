# Use Debian-based PHP 7.4 FPM as the base image
FROM php:7.4-fpm

# Set maintainer information
LABEL maintainer="PHT <phamhoangthongxyz@gmail.com>"

# Set non-interactive mode to avoid prompts during installation
ARG DEBIAN_FRONTEND=noninteractive

# Update package lists and install necessary dependencies
RUN apt-get update && apt-get install -y \
  pkg-config \
  openssl \
  zip \
  unzip \
  curl \
  vim \
  nano \
  libzip-dev \
  libicu-dev \
  autoconf \
  g++ \
  make \
  libonig-dev \
  libcurl4-openssl-dev \
  libssl-dev \
  libpq-dev \
  libpng-dev \
  libjpeg-dev \
  libfreetype6-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) \
  bcmath \
  mbstring \
  intl \
  opcache \
  pdo \
  pdo_pgsql \
  pgsql \
  gd \
  && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set up working directory
WORKDIR /var/www/html
