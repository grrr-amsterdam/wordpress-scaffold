FROM php:7.1-fpm-alpine

ENV GD_DEPS freetype-dev jpeg-dev libpng-dev
ENV MUSL_LOCALE_DEPS cmake make musl-dev gcc gettext-dev libintl
ENV MUSL_LOCPATH /usr/share/i18n/locales/musl

RUN apk add --no-cache \
    $GD_DEPS \
    $MUSL_LOCALE_DEPS \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/bin --with-jpeg-dir=/usr/bin --with-png-dir=/usr/bin \
    && docker-php-ext-install -j$(nproc) gd mysqli pdo pdo_mysql \
    # Install musl-locales for locales support
    && wget "https://gitlab.com/rilian-la-te/musl-locales/-/archive/master/musl-locales-master.zip" && unzip "musl-locales-master.zip" && \
    	cd musl-locales-master && cmake -DLOCALE_PROFILE=OFF -DCMAKE_INSTALL_PREFIX:PATH=/usr . && make && make install && \
    	cd .. && rm -r musl-locales-master

ADD add-reverse-proxy-host.sh docker/php/

ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=composer /usr/bin/composer /usr/bin/composer
