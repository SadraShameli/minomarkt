FROM wordpress:latest

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* 