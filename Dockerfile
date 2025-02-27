# Usa una imagen base oficial de PHP con Apache
FROM php:8.1-apache

# Instala las extensiones necesarias para Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Establece el directorio de trabajo en /var/www/html
WORKDIR /var/www/html

# Copia los archivos del proyecto al contenedor
COPY . .

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Ejecuta Composer para instalar las dependencias de Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copia el archivo de configuración de Apache
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Habilita el módulo de reescritura de Apache
RUN a2enmod rewrite

# Da permisos a las carpetas necesarias
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expone el puerto 80
EXPOSE 80
