FROM php:7.3-cli-alpine

ENV DEBIAN_FRONTEND noninteractive

# Install dev dependencies
RUN apk update \
    && apk upgrade --available \
    && apk add --virtual build-deps \
        autoconf \
        build-base \
        icu-dev \
        libevent-dev \
        openssl-dev \
        zlib-dev \
        libzip \
        libzip-dev \
        zlib \
        zlib-dev \
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
        curl \
        wget \
        bash \
        chromium \
        firefox-esr

# Install and configure NodeJS Package Manager (npm)
ENV NODE_ENV development
RUN npm install -g npm testcafe
RUN npm config set cache ~/.cache/npm

# Install RoadRunner application server (see https://roadrunner.dev/)
RUN wget -qO- https://github.com/spiral/roadrunner/releases/download/v1.4.8/roadrunner-1.4.8-linux-amd64.tar.gz | tar xvz --strip-components 1 -C /usr/local/bin roadrunner-1.4.8-linux-amd64/rr

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install -j$(getconf _NPROCESSORS_ONLN) \
    intl \
    gd \
    iconv \
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

WORKDIR /var/www/html

# Copy files
COPY --chown=www-data:www-data . .

# Build
RUN make

# Expose port for Roadrunner PHP application server (replaces nginx in Symlex 4.4+)
EXPOSE 8081

# Run server
CMD rr serve