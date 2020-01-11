#!/bin/bash
apk update
apk add autoconf alpine-sdk openssl openssl-dev git
pecl install mongodb
echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongodb.ini
composer require "doctrine/mongodb-odm"