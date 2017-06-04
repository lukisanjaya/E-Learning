FROM php:7.0-apache
LABEL Name=api Version=0.0.1 
COPY / /var/www/html/

RUN apt-get update && apt-get install -y curl \
    git \
    libmcrypt-dev

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');"

RUN mv composer.phar /usr/local/bin/composer

RUN a2enmod rewrite

RUN docker-php-ext-install pdo pdo_mysql mcrypt