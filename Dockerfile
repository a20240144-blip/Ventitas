FROM php:8.2-apache

COPY . /var/www/html/

RUN a2enmod rewrite

# Forzar puerto 8080 en Apache (sin usar $PORT)
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf && \
    sed -i 's/:80/:8080/g' /etc/apache2/sites-available/000-default.conf

EXPOSE 8080

CMD ["apache2-foreground"]
