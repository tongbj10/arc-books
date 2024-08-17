FROM phpswoole/swoole:4.8-php7.4-alpine
RUN set -ex \
    && sed -i 's/dl-cdn.alpinelinux.org/mirrors.ustc.edu.cn/' /etc/apk/repositories \
    && apk update \
    && apk add --no-cache --virtual .build-deps ca-certificates curl tar xz libressl libstdc++ openssl openssl-dev tzdata pcre autoconf dpkg-dev dpkg file g++ gcc libc-dev make pkgconf re2c pcre-dev zlib-dev libpng-dev freetype-dev libjpeg-turbo-dev icu-dev libzip-dev \
    && pecl update-channels \
    && pecl install redis-stable \
    && pecl install mongodb-stable \
    && docker-php-ext-enable redis mongodb \
    && docker-php-ext-install pdo_mysql bcmath gd sysvshm sysvmsg sysvsem zip intl
