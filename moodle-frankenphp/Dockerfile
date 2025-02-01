# Use PHP-FPM as the base image
FROM dunglas/frankenphp:php8.2

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
    && rm -rf /var/lib/apt/lists/*

RUN install-php-extensions \
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
    && unzip moodle.zip -d /app/ \
    && rm moodle.zip \
    && mv /app/moodle-* /app/moodle \
    && chown -R www-data:www-data /app/moodle

# FrankenPHP configuration
COPY config/Caddyfile /etc/caddy/Caddyfile

# Create moodledata directory
RUN mkdir /app/moodledata && \
    chown -R www-data:www-data /app/moodledata && \
    chmod 777 /app/moodledata

# Set working directory
WORKDIR /app/moodle
