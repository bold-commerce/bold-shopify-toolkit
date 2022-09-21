FROM circleci/php:7.4.15 as base

FROM base
ARG cache=1
COPY ./ /var/www/html/
RUN sudo chown -R circleci /var/www/html/*
RUN cd /var/www/html/ && composer install
RUN cd /var/www/html/ && vendor/bin/phpunit tests
