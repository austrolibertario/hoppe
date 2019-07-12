FROM php:7.3-fpm

MAINTAINER Ricardo Sierra <sierra.csi@gmail.com>

# Packages
RUN apt-get update && apt-get upgrade -y \
    libzip-dev \
    libfreetype6-dev \
    mysql-client \
    tor \
    libjpeg62-turbo-dev \
    libpq-dev \
    libmagickwand-dev \
    libmcrypt-dev \
    libmcrypt-dev \
 #   libpng12-dev \
    libmemcached-dev \
    libssl-dev \
    libssl-doc \
    libsasl2-dev \
    zlib1g-dev \
    libxml2-dev \
    && docker-php-ext-install \
        # gmp \
        bcmath \
        calendar \
        sockets \
        bz2 \
        iconv \
        opcache \
        mbstring \
        pgsql \
        pdo_mysql \
        pdo_pgsql \
        mysqli \
        soap \
        zip \
        simplexml \
        xml \
    && docker-php-ext-configure gd \
        --with-freetype-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
        --with-png-dir=/usr/include/ \
    && docker-php-ext-install gd \
		&& docker-php-ext-install pcntl \
    && pecl install mcrypt-1.0.2 && docker-php-ext-enable mcrypt \
    && pecl install xdebug && docker-php-ext-enable xdebug \
    && pecl install mongodb && docker-php-ext-enable mongodb \
    && pecl install redis && docker-php-ext-enable redis \
    && yes '' | pecl install imagick && docker-php-ext-enable imagick

# composer
RUN curl -sS http://getcomposer.org/installer | php && \
    mv composer.phar /usr/bin/composer && \
    chmod +x /usr/bin/composer


WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]

