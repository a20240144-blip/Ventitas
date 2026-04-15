FROM php:8.2-apache

# Copiar TODO
COPY . /var/www/html/

# Si tu proyecto está dentro de una carpeta, moverlo
RUN mv /var/www/html/* /var/www/html/ 2>/dev/null || true

RUN a2enmod rewrite

# Puerto fijo
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf && \
    sed -i 's/:80/:8080/g' /etc/apache2/sites-available/000-default.conf

EXPOSE 8080

CMD ["apache2-foreground"]
