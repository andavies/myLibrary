FROM php:5-apache

RUN docker-php-ext-install pdo pdo_mysql

RUN a2enmod rewrite
RUN service apache2 restart

WORKDIR /var/www/html
RUN /bin/bash -c 'find . -type d -exec chmod 711 {} +'
RUN /bin/bash -c 'find . -name *.php -exec chmod 640 {} +'
RUN /bin/bash -c 'find . -name *.js -exec chmod 644 {} +'
RUN /bin/bash -c 'find . -name *.css -exec chmod 644 {} +'
RUN /bin/bash -c 'find . -name *.map -exec chmod 644 {} +'