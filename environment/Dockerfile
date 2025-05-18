FROM php:8.3-apache
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql
RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
    libicu-dev \
    zip unzip \
    && docker-php-ext-install mysqli pdo_mysql intl





RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN sed -ri -e 's!/var/www/html!/var/www/newsletter-app/public!g' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/newsletter-app
EXPOSE 80