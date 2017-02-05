FROM php:7.1-fpm
RUN apt-get update && docker-php-ext-install -j$(nproc) pdo_mysql
RUN /var/www/html/app/console migrations:migrate --no-interaction