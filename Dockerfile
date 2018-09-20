FROM circleci/php:5.6.37-apache-jessie as base

FROM base
ARG cache=1
COPY ./ /var/www/html/
RUN sudo chown -R circleci /var/www/html/*
RUN composer install
RUN vendor/bin/phpunit tests
