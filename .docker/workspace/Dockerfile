FROM php:8.3

LABEL maintainer="PHT <phamhoangthongxyz@gmail.com>"

# Update package lists
RUN apt-get update

# Install necessary packages
RUN apt-get install -y \
    openssl \
    git \
    curl \
    vim \
    nano \
    net-tools \
    pkg-config \
    iputils-ping \
    zip \
    unzip \
    libzip-dev \
    libonig-dev \
    libicu-dev \
    g++ \
    make \
    libcurl4-openssl-dev \
    libssl-dev \
    postgresql-server-dev-all \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev

# Install PHP extensions
RUN docker-php-ext-install \
    bcmath \
    mbstring \
    intl \
    opcache \
    pdo \
    pdo_pgsql \
    pgsql

# Install PHP GD extension
RUN apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Install Node.js and npm
# RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
#     && apt-get install -y nodejs

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set up working directory
WORKDIR /var/www/html
