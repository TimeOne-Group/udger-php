FROM php:8.0-cli-alpine

# Install composer from the official image
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apk --update add git less openssh && \
    rm -rf /var/lib/apt/lists/* && \
    rm /var/cache/apk/*

RUN docker-php-ext-install mysqli pdo_mysql