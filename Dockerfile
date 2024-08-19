FROM php:8.2-fpm

# ติดตั้ง dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# ติดตั้ง PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# ติดตั้ง Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ตั้งค่า working directory
WORKDIR /var/www

# คัดลอกไฟล์โปรเจคทั้งหมด
COPY . .

# ติดตั้ง dependencies ของโปรเจค
RUN composer install

# ตั้งค่าสิทธิ์
RUN chown -R www-data:www-data /var/www
