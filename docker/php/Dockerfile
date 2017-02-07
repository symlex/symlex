FROM php:7.1-fpm
RUN apt-get update && docker-php-ext-install -j$(nproc) pdo_mysql
RUN apt-get install -y git nodejs npm
RUN npm install -g bower
RUN npm install -g requirejs
RUN update-alternatives --install /usr/bin/node node /usr/bin/nodejs 10