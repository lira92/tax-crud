FROM php:7.0-apache

RUN apt-get update \
 && echo 'deb http://packages.dotdeb.org jessie all' >> /etc/apt/sources.list \
 && echo 'deb-src http://packages.dotdeb.org jessie all' >> /etc/apt/sources.list \
 && apt-get install -y wget \
 && wget https://www.dotdeb.org/dotdeb.gpg \
 && apt-key add dotdeb.gpg \
 && apt-get update \
 && apt-get install -y git zlib1g-dev libicu-dev g++ php7.0-mysql php7.0-intl \
 && docker-php-ext-configure intl \
 && docker-php-ext-install zip pdo_mysql intl \
 && a2enmod rewrite \
 && sed -i 's!/var/www/html!/var/www/public!g' /etc/apache2/sites-available/000-default.conf \
 && mv /var/www/html /var/www/public \
 && curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www
