FROM php:8.2-apache

# Install PHP extension yang diperlukan
RUN docker-php-ext-install mysqli

# Copy project ke dalam container
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Berikan izin untuk direktori aplikasi
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 untuk akses HTTP
EXPOSE 80
