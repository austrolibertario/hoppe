
FROM php:7.3-fpm

MAINTAINER Ricardo Sierra <sierra.csi@gmail.com>

RUN apt-get update; \
  apt-get install -y --no-install-recommends \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  pkg-config \
  patch;

ADD https://git.archlinux.org/svntogit/packages.git/plain/trunk/freetype.patch?h=packages/php /tmp/freetype.patch
RUN docker-php-source extract; \
  cd /usr/src/php; \
  patch -p1 -i /tmp/freetype.patch; \
  rm /tmp/freetype.patch

# Packages
RUN apt-get upgrade -y \
    libzip-dev \
    libfreetype6-dev \
    default-mysql-client \
    libjpeg62-turbo-dev \
    libpq-dev \
    libmagickwand-dev \
    libmcrypt-dev \
    libicu-dev zip unzip zlib1g-dev libpng-dev \
 #   libpng12-dev \
    libmemcached-dev \
    libssl-dev \
    libssl-doc \
    libsasl2-dev \
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
    && docker-php-ext-configure gd --with-gd \
        --with-freetype-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
        --with-png-dir=/usr/include/ \
    && docker-php-ext-install gd \
                && docker-php-ext-install pcntl \
    && pecl install mcrypt-1.0.2 && docker-php-ext-enable mcrypt \
    && pecl install xdebug && docker-php-ext-enable xdebug \
    && pecl install mongodb && docker-php-ext-enable mongodb \
    && pecl install redis && docker-php-ext-enable redis \
    && pecl install trader && docker-php-ext-enable trader \
    && yes '' | pecl install imagick && docker-php-ext-enable imagick \
    && docker-php-ext-enable pcntl


# # Docker Install
# RUN curl -fsSL https://get.docker.com -o get-docker.sh && sh get-docker.sh && rm get-docker.sh
#     #groupadd docker && usermod -aG docker $USER

# RUN apt-get update && \
#       apt-get -y install sudo

# #RUN useradd -m root && echo "root:root" | chpasswd && adduser root sudo
# RUN echo "root:root" | chpasswd && adduser root sudo

# composer
RUN curl -sS http://getcomposer.org/installer | php && \
    mv composer.phar /usr/bin/composer && \
    chmod +x /usr/bin/composer


WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]

