FROM php:8.0-apache

# Instalar extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos del proyecto al contenedor
COPY . /var/www/html/

# Establecer permisos adecuados
RUN chown -R www-data:www-data /var/www/html

# Configurar PHP para mostrar errores durante el desarrollo
RUN { \
    echo 'display_errors = On'; \
    echo 'display_startup_errors = On'; \
    echo 'error_reporting = E_ALL'; \
    echo 'log_errors = On'; \
    echo 'error_log = /var/log/php-errors.log'; \
} > /usr/local/etc/php/conf.d/error-logging.ini

# Exponer el puerto 80
EXPOSE 80

# Iniciar Apache en primer plano
CMD ["apache2-foreground"]
