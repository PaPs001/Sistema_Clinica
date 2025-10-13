FROM php:8.2-fpm-alpine

RUN apk update && apk add \
    build-base \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    zip \
    vim \
    unzip \
    git \
    curl \
    oniguruma-dev \
    autoconf \           # ← CORRECTO
    pkgconfig \          # ← CORRECTO  
    redis \              # ← CORRECTO
    linux-headers        # ← CORREGIDO: era "linux-helders"

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# INSTALAR REDIS CORRECTAMENTE
RUN pecl install redis && docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN addgroup -g 1000 -S www && \
    adduser -u 1000 -S www -G www

COPY . /var/www

RUN chown -R www:www /var/www

USER www

WORKDIR /var/www

CMD ["php-fpm"]