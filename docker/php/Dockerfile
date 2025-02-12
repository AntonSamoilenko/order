FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \

    libzip-dev \
    zip \
    unzip \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    git \
    && docker-php-ext-install \
        pdo_mysql \
        mysqli \
        bcmath \
        intl \
        soap \
        xml \
        zip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./application /var/www/application

WORKDIR /var/www/application

CMD ["php-fpm"]
