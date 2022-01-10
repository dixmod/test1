FROM composer:2.2.2 as composer

FROM php:cli-alpine3.15

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

ADD . .

RUN cp environments/entrypoint.sh /entrypoint.sh

RUN export DATABASE_URL= \
    && touch .env \
    && composer install --ignore-platform-reqs --no-interaction

ENTRYPOINT ["/entrypoint.sh"]
