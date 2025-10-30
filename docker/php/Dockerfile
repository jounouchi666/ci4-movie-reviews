FROM php:8.2-apache

# 必要な拡張とツールをインストール
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libicu-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libavif-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
        --with-avif \
    && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    mysqli \
    intl \
    gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Composer インストール
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# mod_rewrite 有効化
RUN a2enmod rewrite

# CodeIgniter4 は public/ をドキュメントルートにする必要あり
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Apacheの設定を修正
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf