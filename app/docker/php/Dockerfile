FROM php:7.2-fpm-alpine

RUN apk update \
    && apk upgrade --available \
    && apk add --virtual build-deps \
        autoconf \
        build-base \
        icu-dev \
        libevent-dev \
        openssl-dev \
        zlib-dev \
    && apk add \
        bzip2 \
        git \
        mysql-client \
        nodejs \
        nodejs-npm \
        yarn \
        libpng \
        libpng-dev \
        libjpeg \
        libjpeg-turbo-dev \
        libwebp-dev \
        freetype \
        freetype-dev \
        zlib \
        zlib-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/

RUN docker-php-ext-install -j$(getconf _NPROCESSORS_ONLN) \
    intl \
    gd \
    mbstring \
    pdo_mysql \
    sockets \
    zip

RUN pecl channel-update pecl.php.net \
    && pecl install -o -f \
        redis \
        event \
    && rm -rf /tmp/pear \
    && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini \
    && echo "extension=event.so" > /usr/local/etc/php/conf.d/event.ini

# COPY ./ /var/www/html

# RUN mkdir -p \
#        /var/www/html/bin \
#        /var/www/html/vendor \
#        /var/www/html/storage

# RUN composer install --no-interaction

# RUN chown -R www-data:www-data /var/www/html/storage