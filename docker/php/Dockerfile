FROM php:7.1-fpm
RUN apt-get update && apt-get upgrade -y && docker-php-ext-install -j$(nproc) pdo_mysql
RUN curl -sL https://deb.nodesource.com/setup_7.x | bash -
RUN apt-get install -y git nodejs zlib1g zlib1g-dev zlibc libicu-dev
RUN docker-php-ext-install -j$(nproc) pdo_mysql zip mbstring intl
RUN npm install -g bower
RUN npm install -g requirejs
RUN cd /tmp
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN rm composer-setup.php
RUN mv composer.phar /usr/bin/composer