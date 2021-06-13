FROM php:7.4.11-fpm
ARG WWW_USER_UID=1000
ARG WWW_GROUP_GID=1000
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_NO_INTERACTION=1

# add apt-get installs to this RUN
RUN apt-get update \
    && apt-get install -y \
        zip git libicu-dev libzip-dev libmemcached-dev nano mc pv htop curl  \
        libpng-dev libmagickwand-dev supervisor wget unzip librabbitmq-dev libssh-dev \
    && pecl install xhprof \
    && pecl install xdebug-3.0.0 \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "extension=$(find /usr/local/lib/php/extensions/ -name xhprof.so)" > /usr/local/etc/php/conf.d/xhprof.ini \
        && git clone https://github.com/edenhill/librdkafka.git \
        && cd librdkafka \
        && ./configure \
        && make \
        && make install \
        && cd .. \
        && rm -Rf librdkafka \
    && docker-php-ext-install \
        intl zip opcache pdo pdo_mysql bcmath sockets gd soap sockets \
    && pecl install memcached \
    && echo extension=memcached.so >> /usr/local/etc/php/conf.d/memcached.ini \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && pecl install rdkafka-4.0.4 \
    && docker-php-ext-enable rdkafka \
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && pecl install apcu \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./conf/php-fpm/dev/php.ini /usr/local/etc/php/php.ini
COPY ./conf/php-fpm/dev/remote-xdebug.ini /usr/local/etc/php/conf.d/remote-xdebug.ini
COPY ./conf/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./conf/supervisor.ini /etc/supervisord.d/supervisor.ini
#COPY ./conf/50-rdkafka.ini /usr/local/etc/php/conf.d/50-rdkafka.ini

### timezone ###
ARG TZ="Europe/Moscow"
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN echo "\ndate.timezone = $TZ" >> /usr/local/etc/php/php.ini

### ssh ###
COPY ./ssh /root/.ssh
RUN chown -R root:root /root/.ssh && printf "Host *\n\tStrictHostKeyChecking no" > /root/.ssh/config && chmod -R 0600 /root/.ssh

### permissions ###
RUN mkdir -p /var/www/var/cache /var/www/var/log /var/www/tests/_output && chmod -R 777 /var/www/var
RUN addgroup -gid $WWW_GROUP_GID  www
RUN adduser www \
	-uid  $WWW_USER_UID \
	--disabled-login \
	--ingroup www \
	--no-create-home \
	--quiet \
	--system

RUN chown -R $WWW_USER_UID:$WWW_USER_UID /var/www/var /var/www/tests/_output && chmod -R 777 /var/www/tests/_output