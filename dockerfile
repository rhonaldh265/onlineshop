# Use official PHP with Apache
FROM php:8.1-apache

# Copy all project files into Apache web root
COPY . /var/www/html/

# Create uploads folder and give full permissions
RUN mkdir -p /var/www/html/uploads && chmod -R 777 /var/www/html/uploads

# Ensure products.json exists and is writable
RUN touch /var/www/html/products.json && chmod 666 /var/www/html/products.json

# Expose port 80 for web traffic
EXPOSE 80
