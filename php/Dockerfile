# Download from official image
FROM php:8.1-fpm

# Define a proper user to avoid permission issues
RUN addgroup --gid 1000 user
RUN adduser --disabled-password --gecos '' --uid 1000 --gid 1000 user

# Update to get all dependencies mandatory for Symfony
RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip autoconf pkg-config libssl-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql mysqli \
    && pecl install apcu mongodb \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini

# Install Composer & Symfony client
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# Set the working directory
WORKDIR /var/www/app
# Line mandatory to avoid permissions issues
RUN chown user:user /var/www/app

# Use configured user
USER user