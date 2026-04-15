FROM php:8.2-apache

COPY . /var/www/html/

RUN a2enmod rewrite

# Cambiar Apache a puerto 8080 (Railway lo acepta)
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 8080

CMD ["apache2-foreground"]
