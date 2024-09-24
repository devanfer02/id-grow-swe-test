FROM php:8.3-apache-bullseye

ENV PORT=8000

RUN apt-get update -y && apt-get install -y \
    openssl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    git \
    curl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo mbstring

WORKDIR /app

COPY . /app

RUN composer install --ignore-platform-reqs

EXPOSE $PORT

CMD php artisan serve --host=0.0.0.0 --port=8000

