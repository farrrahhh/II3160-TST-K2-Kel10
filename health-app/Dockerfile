# Menggunakan image PHP dengan Apache
FROM php:8.2-apache

# Install ekstensi PHP yang diperlukan (misalnya, mysqli untuk koneksi database)
RUN docker-php-ext-install mysqli

# Mengaktifkan mod_rewrite untuk Apache (untuk URL yang ramah SEO)
RUN a2enmod rewrite

# Salin file konfigurasi Apache jika diperlukan (misalnya, jika Anda punya file konfigurasi kustom)
# COPY ./config/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Setel direktori kerja (opsional)
WORKDIR /var/www/html

# Salin aplikasi Anda ke dalam kontainer
COPY . /var/www/html

# Berikan hak akses yang sesuai untuk direktori
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Port yang digunakan oleh Apache
EXPOSE 80

# Perintah untuk menjalankan Apache
CMD ["apache2-foreground"]
