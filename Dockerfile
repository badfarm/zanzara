FROM php:8.0-rc

COPY --from=composer:2.0.4 /usr/bin/composer /usr/bin/composer

COPY . .
COPY bot.php bot.php

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git

RUN apt-get install -y libzip-dev zip
RUN docker-php-ext-configure zip
RUN docker-php-ext-install zip

RUN composer install

CMD php bot.php
