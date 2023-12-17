FROM php:8.2.9-fpm-alpine

# Pacotes e dependências estão sendo instalados no sistema operacional base 
RUN apk update && apk add --no-cache \
    autoconf \
    build-base \
    mysql-client \
    shadow \
    openssl \
    bash \
    nginx \
    git

# Atualize o sistema e instale dependências
RUN apk --no-cache add postgresql-dev

# Instale extensões PHP necessárias
RUN docker-php-ext-install pdo pdo_pgsql

# Instalando Redis e dependências necessárias
RUN pecl install redis && docker-php-ext-enable redis

# Crie o diretório home do usuário www-data (o usuário padrão do PHP-FPM)
RUN mkdir -p /var/www/home/www-data

# Baixa e instala o Composer, uma ferramenta para gerenciar dependências em projetos PHP.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Defina o diretório de trabalho para /var/www
WORKDIR /var/www

# Executa comandos de permissão
RUN chown -R www-data:www-data /var/www
COPY --chown=www-data:www-data ./ .

# Instalacao de dependencias do composer
RUN rm -rf vendor
RUN composer install --no-interaction

# Crie o diretório /var/www/storage
# RUN mkdir -p /var/www/storage

# Defina as permissões para o diretório
# RUN chmod -R 757 /var/www/storage

# Copia os arquivos de configuração do PHP-FPM local para o container
COPY ./.docker/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./.docker/php-fpm/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf