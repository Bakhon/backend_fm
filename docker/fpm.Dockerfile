FROM php:7.3-fpm

RUN apt-get update && apt-get install -y \
        build-essential \
        libpng-dev \
        libjpeg62-turbo-dev \
        libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev \
        libfreetype6 \
        libfreetype6-dev \
        locales \
        zip \
        vim \
        jpegoptim optipng pngquant gifsicle \
        git \
        curl \
        libzip-dev zip unzip && \
        docker-php-ext-configure zip && \
        docker-php-ext-install zip && \
        docker-php-ext-install gd && \
        php -m | grep -q 'zip' \
    && docker-php-ext-install pdo pdo_mysql

RUN apt-get update \
&& docker-php-ext-install pdo pdo_mysql

# Redis
#RUN apt-get update \
#    && apt-get -y --no-install-recommends install  php7.3-pgsql php7.3-gd php-redis \
#    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install Postgress
RUN apt-get update && apt-get install -y \
        libmcrypt-dev \
        && apt-get install -y libpq-dev

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pgsql pdo_pgsql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Change current user to www
USER root

# Workdir
WORKDIR /var/www/

# Composer update
#RUN composer install --prefer-source --no-interaction
#RUN cd /var/www/ && composer update --no-scripts --no-autoloader

# Create .env
#RUN cd /var/www/ \
#   && cp .env.example .env \
#   && composer dump-autoload

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
