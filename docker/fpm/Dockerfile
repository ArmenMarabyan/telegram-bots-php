FROM ubuntu:18.04
FROM php:7.4-fpm

# PSR for phalcon 4.x
ARG PSR_VERSION=0.6.1

ARG PHALCON_VERSION=4.1.2
ARG PHALCON_EXT_PATH=php7/64bits


RUN apt update && apt -y upgrade && DEBIAN_FRONTEND=noninteractive apt install -y git \
        nano \
        wget \
        curl \
        unzip
#        nginx \
#        supervisor \
#        memcached \
#        sqlite3 \
#        mysql-client \
#        postgresql-client \
#        php7.2-common \
#        php7.2-cli \
#        php7.2-mbstring \
#        php7.2-xml \
#        php7.2-fpm \
#        php7.2-curl \
#        php7.2-mysql \
#        php7.2-pgsql \
#        php7.2-sqlite \
#        php7.2-memcached \
#        php7.2-gd \
#        php-redis \
#        php-apcu \
#        php7.2-zip && \
#    mkdir -p /run/php

# Download and Install composer
RUN wget https://github.com/composer/composer/releases/download/1.10.5/composer.phar && \
    wget https://github.com/phalcon/zephir/releases/download/0.12.18/zephir.phar && \
    chmod ugo+x composer.phar zephir.phar && \
    mv composer.phar /usr/local/bin/composer && \
    mv zephir.phar /usr/local/bin/zephir && \
    composer global require hirak/prestissimo

RUN apt install -y  \
        make \
        gcc \
        re2c \
        autoconf \
        automake \
        build-essential
#        php7.4-dev

# Download and install Zephir
RUN cd /opt && \
    rm -rf php-zephir-parser && \
    git clone git://github.com/phalcon/php-zephir-parser.git && \
    cd php-zephir-parser && \
    phpize && \
    ./configure && \
    make && make install && \
#    echo 'extension=zephir_parser.so' > /etc/php/7.4/cli/conf.d/48-zephir_parser.ini
    echo 'extension=zephir_parser.so' > /usr/local/etc/php/conf.d/48-zephir_parser.ini

## Download, install and enable PSR PHP module
#RUN cd /opt && \
#    rm -rf php-psr && \
#    git clone https://github.com/jbboehr/php-psr.git && \
#    cd php-psr && \
#    phpize && \
#    ./configure && \
#    make && make install && \
#    echo 'extension=psr.so' > /etc/php/7.2/fpm/conf.d/49-psr.ini && \
#    echo 'extension=psr.so' > /etc/php/7.2/cli/conf.d/49-psr.ini

#RUN set -xe && \
#        # Compile PSR
#        curl -LO https://github.com/jbboehr/php-psr/archive/v${PSR_VERSION}.tar.gz && \
#        tar xzf ${PWD}/v${PSR_VERSION}.tar.gz && \
#        cd ${PWD}/php-psr-${PSR_VERSION} && \
#        phpize && \
#        ./configure && \
#        make && \
#        make test && \
#        make install

# Download, install and enable PSR PHP module
RUN cd /opt && \
    rm -rf php-psr && \
    git clone https://github.com/jbboehr/php-psr.git && \
    cd php-psr && \
    phpize && \
    ./configure && \
    make && make install && \
    echo 'extension=psr.so' > /usr/local/etc/php/conf.d/49-psr.ini && \
    echo 'memory_limit=1024M' > /usr/local/etc/php/php.ini

# Install packages
RUN apt-get update && \
        apt-get install -y zlib1g-dev && \
        apt-get install -y libpng-dev && \
        apt-get install -y libzip-dev && \
        apt-get install -y curl && \
        apt-get install -y unzip && \
        apt-get install nano

RUN docker-php-ext-install zip
RUN docker-php-ext-install gd
RUN docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
        && docker-php-ext-configure mysqli --with-mysqli=mysqlnd \
        && docker-php-ext-install pdo_mysql

RUN apt-get install -y libpcre3-dev
RUN docker-php-ext-install opcache && \
    docker-php-ext-enable opcache

RUN echo '\
opcache.interned_strings_buffer=16\n\
opcache.load_comments=Off\n\
opcache.max_accelerated_files=16000\n\
opcache.save_comments=Off\n\
' >> /usr/local/etc/php/conf.d/opcache.ini

RUN set -xe && \
        # Compile Phalcon
        curl -LO https://github.com/phalcon/cphalcon/archive/v${PHALCON_VERSION}.tar.gz && \
        tar xzf ${PWD}/v${PHALCON_VERSION}.tar.gz && \
        cd ${PWD}/cphalcon-${PHALCON_VERSION} && \
            zephir fullclean && \
            COMPOSER_MEMORY_LIMIT=-1 zephir build && \
            cd ext/ && \
            ./install
#        cd ${PWD}/cphalcon-${PHALCON_VERSION}/build/ && \
#        ./install


RUN pecl install xhprof-beta
#RUN echo "extension=xhprof.so" > /usr/local/etc/php/php.ini
#COPY core/xhgui/config.php /var/www/xhgui/config/


# Git clone, build, compile, install and enable Phalcon PHP Module
#RUN cd /opt && \
#    rm -rf cphalcon && \
#    git clone --depth=1 --branch "${PHALCON_VERSION}" "https://github.com/phalcon/cphalcon.git" && \
#    cd cphalcon && \
#    zephir fullclean && \
#    zephir build && \
#    cd ext/ && \
#    ./install && \
##    echo 'extension=phalcon.so' > /etc/php/7.2/fpm/conf.d/50-phalcon.ini && \
##    echo 'extension=phalcon.so' > /etc/php/7.2/cli/conf.d/50-phalcon.ini && \
#    apt purge -y make \
#        gcc \
#        re2c \
#        autoconf \
#        automake \
#        build-essential \
#        php7.4-dev && \
#    apt clean

#RUN php -r 'echo Phalcon\Version::get() . PHP_EOL;'


#RUN docker-php-ext-install -j$(nproc) opcache

#composer

#RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
#
#RUN php composer-setup.php \
#    --install-dir=/usr/local/bin \
#    --filename=composer
#
#RUN rm composer-setup.php

# Enable mod rewrite
#RUN a2enmod rewrite





#FROM php:7.4-fpm
#
#RUN apt-get update \
#  && apt-get install -y \
#    cron \
#    libfreetype6-dev \
#    libicu-dev \
#    libjpeg62-turbo-dev \
#    libmcrypt-dev \
#    libxslt1-dev \
#    libzip-dev \
#    libonig-dev
#
##RUN pecl install mcrypt-1.0.3
#RUN pecl install mcrypt-1.0.3 \
#        && docker-php-ext-enable mcrypt
#
#RUN docker-php-ext-configure \
##  gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
#  gd --with-freetype --with-jpeg
#
#RUN docker-php-ext-install \
#  bcmath \
#  gd \
#  intl \
#  mbstring \
#  pdo_mysql \
#  xsl \
#  zip \
#  soap \
#  sockets
#
#WORKDIR /var/www/html