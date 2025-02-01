# Gunakan Nginx Unit dengan PHP 8.2 sebagai base image
FROM unit:php8.2

# Install dependencies untuk Moodle
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    libpng-dev \
    libicu-dev \
    libxml2-dev \
    libldap2-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zlib1g-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    mysqli \
    pdo_mysql \
    zip \
    gd \
    intl \
    xml \
    soap \
    opcache \
    ldap

# Download dan install Moodle
RUN curl -L -o moodle.zip https://github.com/moodle/moodle/archive/refs/tags/v4.5.1.zip \
    && unzip moodle.zip -d /var/www/ \
    && rm moodle.zip \
    && mv /var/www/moodle-* /var/www/moodle \
    && chown -R www-data:www-data /var/www/moodle

# Buat direktori moodledata
RUN mkdir -p /var/www/moodledata \
    && chown -R www-data:www-data /var/www/moodledata \
    && chmod -R 777 /var/www/moodledata

# Salin konfigurasi Unit
# COPY config/nginx-moodle.conf /etc/nginx/conf.d/default.conf
COPY config/unit-config.json /docker-entrypoint.d/config.json

# Expose port yang digunakan oleh Unit
EXPOSE 80

# Set direktori kerja ke folder Moodle
WORKDIR /var/www/moodle
