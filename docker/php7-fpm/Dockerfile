# See https://github.com/docker-library/php/blob/4677ca134fe48d20c820a19becb99198824d78e3/7.0/fpm/Dockerfile
FROM php:7.4-fpm as php_base

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    netcat \
    libicu-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    gnupg2 \
    vim \
    libzip-dev

# Set timezone and install Composer
RUN rm /etc/localtime \
    && ln -s /usr/share/zoneinfo/Europe/Berlin /etc/localtime \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) pdo_mysql intl gd bcmath opcache exif zip

# install node
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash - \
    && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && curl -L https://cs.symfony.com/download/php-cs-fixer-v2.phar -o php-cs-fixer && chmod a+x php-cs-fixer && mv php-cs-fixer /usr/local/bin/php-cs-fixer \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
    && apt-get install -y nodejs \
    && apt-get update && apt-get install -y yarn

WORKDIR /var/www

COPY php_custom_dev.ini /usr/local/etc/php/conf.d/
COPY start.sh /usr/local/bin/
ENTRYPOINT ["/usr/local/bin/start.sh"]
CMD ["php-fpm"]


FROM php_base AS php_dev

# install xdebug
#RUN pecl install xdebug-2.6.0
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
