FROM composer:2.2.2 as composer

FROM php:8.1.1-fpm

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y \
        git \
        curl \
        git \
        zip \
        unzip \
        wget \
        gettext \
        build-essential \
        zlib1g-dev \
        cmake \
        mc \
        zsh \
        vim \
        inetutils-ping \
        libyaml-dev \
        libevent-dev \
        libev-dev \
        libuv1 \
        libuv1-dev \
        openssl \
        libssl-dev \
        libmemcached-dev \
        libxml2-dev \
        libmcrypt-dev \
        libicu-dev \
        locales \
        libcurl4-openssl-dev \
        libzip-dev \
        netcat-openbsd \
        socat \
        zlib1g-dev \
        libicu-dev \
        g++ \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install sockets \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install opcache \
    && docker-php-ext-install curl \
    && docker-php-ext-install filter \
    && docker-php-ext-install soap \
    && docker-php-ext-install zip \
    && docker-php-ext-install intl

RUN echo yes | pecl install ev-1.1.2 && echo "extension=ev.so" > /usr/local/etc/php/conf.d/ext-ev.ini
RUN echo yes | pecl install xdebug-3.1.2
RUN echo yes | pecl install memcached-3.1.5 && docker-php-ext-enable memcached
RUN echo yes | pecl install yaml-2.2.2 && echo "extension=yaml.so" > /usr/local/etc/php/conf.d/ext-yaml.ini

RUN echo '\
\n zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20210902/xdebug.so \
\n xdebug.client_host=10.254.254.254 \
\n xdebug.remote_connect_back=Off \
\n xdebug.client_port=9001 \
\n xdebug.remote_handler=dbgp \
\n xdebug.mode=debug \
\n xdebug.start_with_request=yes \
' >> /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/www

CMD php -S 0.0.0.0:8080 -t ./public/

