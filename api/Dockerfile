# Use a imagem oficial do PHP com as extensões necessárias
FROM php:8.3-fpm

# Instalar dependências
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip exif pcntl gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criar e definir o diretório de trabalho
WORKDIR /var/www/html

# Copiar o arquivo .env
COPY .env.example .env
# Instalar dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Copiar os arquivos do Laravel
COPY . .

# Instalar dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Definir permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expor a porta do PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
