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
    apache2 \
    libapache2-mod-fcgid \
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

# Enable Apache modules
RUN a2enmod actions fcgid alias proxy_fcgi

# Configure Apache to use PHP-FPM
COPY config/apache-moodle.conf /etc/apache2/sites-available/000-default.conf
COPY config/www.conf /usr/local/etc/php-fpm.d/www.conf

# Create moodledata directory
RUN mkdir /var/www/html/moodledata && \
    chown -R www-data:www-data /var/www/html/moodledata && \
    chmod 777 /var/www/html/moodledata

# Copy startup script
COPY start.sh /start.sh

# Create PHP-FPM socket directory
RUN chmod +x /start.sh \
    && mkdir -p /var/run/php \
    && chown www-data:www-data /var/run/php

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN mkdir -p /var/log/php-fpm \
    && touch /var/log/php-fpm/php-fpm.log \
    && chown www-data:www-data /var/log/php-fpm/php-fpm.log

RUN sed -i 's|;catch_workers_output = yes|catch_workers_output = yes|g' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's|error_log = .*|error_log = /var/log/php-fpm/php-fpm.log|g' /usr/local/etc/php-fpm.conf

WORKDIR /var/www/html/moodle

# Use the start.sh script as the entrypoint
CMD ["/start.sh"]