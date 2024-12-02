FROM php:8.2-fpm

# Preparamos la imagen con las dependencias necesarias para trabajar con PHP y Laravel
RUN apt update --fix-missing && apt install -y \
    git \
    curl \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    nodejs \
    npm \
    libpq-dev

RUN apt clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP necesarias para Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip opcache

# Copiar el archivo .env de Laravel (si existe) y configurar permisos para las carpetas necesarias
WORKDIR /var/www

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
