FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies sistem
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev

# Bersihkan apt cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extension PHP yang dibutuhkan Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin konfigurasi php.ini custom
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

# Expose port 9000
EXPOSE 9000
CMD ["php-fpm"]

