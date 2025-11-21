FROM php:8.1-apache
COPY . /var/www/html/
RUN mkdir /var/www/html/uploads && chmod -R 777 /var/www/html/uploads
RUN chmod 666 /var/www/html/products.json
EXPOSE 80

