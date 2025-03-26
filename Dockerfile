# Use an official PHP image with Apache
FROM php:8.1-apache

# Install required PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mod_rewrite for better URL handling
RUN a2enmod rewrite

# Copy the application files to the container
COPY . /var/www/html/

# Set the working directory
WORKDIR /var/www/html/

# Expose port 80 for HTTP traffic
EXPOSE 80

# Start Apache when the container runs
CMD ["apache2-foreground"]

