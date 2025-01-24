FROM php:8.2

LABEL maintainer="PHT <phamhoangthongxyz@gmail.com>"

# Update package lists and install necessary packages
RUN apt-get update && apt-get install -y \
    openssl \
    zip \
    unzip \
    curl \
    vim \
    nano \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    autoconf \
    g++ \
    make \
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

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set up working directory
WORKDIR /var/www/html
