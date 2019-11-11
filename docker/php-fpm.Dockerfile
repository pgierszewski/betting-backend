FROM php:7.3-fpm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo pdo_mysql

RUN pecl install redis && docker-php-ext-enable redis
