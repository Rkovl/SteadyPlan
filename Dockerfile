FROM php:8.2-apache

# Install PostgreSQL extension for PHP
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && apt-get clean

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy your PHP files to Apache's web directory
COPY index.php /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]