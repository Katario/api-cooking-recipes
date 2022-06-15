# Download from official image
FROM php:8.1-fpm

# Use args passed by docker-compose
ARG GROUP_ID
ARG USER_ID
ARG GIT_EMAIL
ARG GIT_NAME

# Define a proper user to avoid permission issues
RUN addgroup --gid $GROUP_ID user
RUN adduser --disabled-password --gecos '' --uid $USER_ID --gid $GROUP_ID user

# Update to get all dependencies mandatory for Symfony
RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

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

RUN git config --global user.email $GIT_EMAIL \
    && git config --global user.name $GIT_NAME