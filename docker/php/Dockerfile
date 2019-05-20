FROM php:7.3-fpm

MAINTAINER Ricardo Sierra <sierra.csi@gmail.com>

# NewRelic
RUN \
  curl -L https://download.newrelic.com/php_agent/archive/8.6.0.238/newrelic-php5-8.6.0.238-linux.tar.gz | tar -C /tmp -zx && \
    NR_INSTALL_USE_CP_NOT_LN=1 NR_INSTALL_SILENT=1 /tmp/newrelic-php5-*/newrelic-install install && \
      rm -rf /tmp/newrelic-php5-* /tmp/nrinstall* && \
        sed -i -e 's/"REPLACE_WITH_REAL_KEY"/"bc93fcb97565b2a443cc362f18f22acebcd8e417"/' \
     -e 's/newrelic.appname = "PHP Application"/newrelic.appname = "Passepag Laravel Api"/' \
         /usr/local/etc/php/conf.d/newrelic.ini

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
    && pecl install mcrypt-1.0.2 && docker-php-ext-enable mcrypt \
    && yes '' | pecl install imagick && docker-php-ext-enable imagick \
    && docker-php-ext-enable pcntl

# Docker Install
RUN curl -fsSL https://get.docker.com -o get-docker.sh && sh get-docker.sh && rm get-docker.sh
    #groupadd docker && usermod -aG docker $USER

RUN apt-get update && \
      apt-get -y install sudo

#RUN useradd -m root && echo "root:root" | chpasswd && adduser root sudo
RUN echo "root:root" | chpasswd && adduser root sudo


# composer
RUN curl -sS http://getcomposer.org/installer | php && \
    mv composer.phar /usr/bin/composer && \
    chmod +x /usr/bin/composer


WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]

