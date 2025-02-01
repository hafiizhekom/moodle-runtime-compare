# Use PHP-FPM as the base image
FROM php:8.2-fpm

# Install dependencies
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
    nginx \
    && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions
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

# Set recommended PHP.ini settings
RUN { \
        echo 'max_input_vars = 5000'; \
        echo 'memory_limit = 512M'; \
        echo 'max_execution_time = 600'; \
        echo 'upload_max_filesize = 64M'; \
        echo 'post_max_size = 64M'; \
    } > /usr/local/etc/php/conf.d/moodle.ini

# Download and install Moodle
RUN curl -L -o moodle.zip https://github.com/moodle/moodle/archive/refs/tags/v4.5.1.zip \
    && unzip moodle.zip -d /var/www/html/ \
    && rm moodle.zip \
    && mv /var/www/html/moodle-* /var/www/html/moodle \
    && chown -R www-data:www-data /var/www/html/moodle

# Configure Nginx and PHP-FPM
COPY config/nginx-moodle.conf /etc/nginx/sites-available/default
COPY config/www.conf /usr/local/etc/php-fpm.d/www.conf

# Create moodledata directory
RUN mkdir /var/www/html/moodledata && \
    chown -R www-data:www-data /var/www/html/moodledata && \
    chmod 777 /var/www/html/moodledata

# Start Nginx and PHP-FPM
COPY start.sh /start.sh
# Create PHP-FPM socket directory
RUN chmod +x /start.sh \
    && mkdir -p /var/run/php \
    && chown www-data:www-data /var/run/php

WORKDIR /var/www/html/moodle

CMD ["/start.sh"]
