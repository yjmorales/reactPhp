FROM php:8.1-apache

### Install OS tools
RUN apt-get update \
    && apt-get install --yes curl \
    libmcrypt-dev \
    libreadline-dev \
    libzip-dev \
    nano \
    git \
    vim \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxpm-dev \
    libfreetype6-dev \
    python3-distutils \
    python3-apt \
    python3-pip \
    beanstalkd \
\
### Install PHP extras
    && pecl install mcrypt \
    && apt-get update && apt-get install -y zlib1g-dev libmcrypt-dev \
    && docker-php-ext-install -j$(nproc) zip mysqli pdo pdo_mysql gd pcntl sockets posix \
    && docker-php-ext-enable mcrypt \
    && docker-php-ext-configure pcntl --enable-pcntl \
\
### Changing Ownership of document root directory to apache.
    && chown -R www-data:www-data /var/www/html

### Coping vhost template within apache sites.
COPY dockerization/web/000-default.conf /etc/apache2/sites-enabled/000-default.conf

### Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/bin/composer \
    && chmod +x /usr/bin/composer

### Exposing port 80 to the exterior.
EXPOSE 80