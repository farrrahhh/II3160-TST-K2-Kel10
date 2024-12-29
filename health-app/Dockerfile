# Gunakan image resmi PHP 8.2 dengan Apache
FROM php:8.2-apache

# -------------------------------------------------------
# 1. Install packages dan ekstensi PHP
# -------------------------------------------------------
RUN apt-get update && apt-get install -y \
    libicu-dev \        
    libzip-dev \        
    unzip \              
    git && \
    docker-php-ext-configure intl && \
    docker-php-ext-install \
       intl \           
       pdo \            
       pdo_mysql \      
       mysqli \         
           zip
    
    RUN a2enmod rewrite && \
        rm -rf /var/lib/apt/lists/*

# -------------------------------------------------------
# 2. Install Composer
# -------------------------------------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# -------------------------------------------------------
# 3. Atur direktori kerja di dalam container
# -------------------------------------------------------
WORKDIR /var/www/html

# -------------------------------------------------------
# 4. Salin kode sumber ke container
# -------------------------------------------------------
COPY . /var/www/html

# -------------------------------------------------------
# 5. Jalankan Composer install (opsional)
#    - Sesuaikan dengan kebutuhan Anda. Misalnya:
#    - --no-dev jika Anda tidak butuh dev-dependencies di production.
#    - --optimize-autoloader untuk mempercepat load class di production
# -------------------------------------------------------
RUN composer install --no-dev --optimize-autoloader

# -------------------------------------------------------
# 6. Atur hak kepemilikan & izin direktori
# -------------------------------------------------------
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# -------------------------------------------------------
# 7. Ekspos port 80 (HTTP)
# -------------------------------------------------------
EXPOSE 80

# -------------------------------------------------------
# 8. Jalankan Apache saat container di-start
# -------------------------------------------------------
CMD ["apache2-foreground"]