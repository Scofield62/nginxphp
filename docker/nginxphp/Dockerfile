FROM php:7.4.1-fpm-alpine

RUN apk update

#Installing nginx and supervisor
RUN apk add nginx supervisor autoconf openssl alpine-sdk && \
    rm -rf /var/lib/apt/lists/* && \
    rm -r /var/www/html

#Installing php modules
RUN docker-php-ext-install mysqli pdo_mysql

#log routing
RUN ln -sf /dev/stdout /var/log/nginx/app.access.log \
	&& ln -sf /dev/stderr /var/log/nginx/app.error.log \
	&& ln -sf /dev/stderr /var/log/php-fpm.log

RUN mkdir -p /run/php \
    && touch /run/php/php-fpm.sock \
    && touch /run/php/php-fpm.pid \
    && mv /usr/local/etc/php/php.ini-production /usr/local/etc/php/conf.d/php.ini-production.ini

RUN chown www-data:www-data /var/www/ -Rf

RUN mkdir /etc/nginx/sites-available /etc/nginx/sites-enabled
#RUN rm -rf /etc/nginx/sites-available/* && rm -rf /etc/nginx/sites-enabled/*

#nginx config
COPY ./docker/nginxphp/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/nginxphp/app.conf /etc/nginx/sites-available/localhost
RUN ln -s /etc/nginx/sites-available/localhost /etc/nginx/sites-enabled/localhost

#php-fpm config
COPY ./docker/nginxphp/phpfpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./docker/nginxphp/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

#Source code
COPY ./source/ /var/www/

#Uncomment this if you need mongodb
RUN cd /var/www \
    && apk add git \
    && pecl install mongodb \
    && echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongodb.ini
    && curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    && composer require "doctrine/mongodb-odm"

WORKDIR /var/www/

EXPOSE 80

CMD /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisor.conf