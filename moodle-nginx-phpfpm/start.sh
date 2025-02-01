# In start.sh
#!/bin/bash
set -e

# Specific socket path
SOCKET_PATH="/var/run/php/php8.2-fpm.sock"

# Ensure socket directory exists
mkdir -p $(dirname $SOCKET_PATH)
chown www-data:www-data $(dirname $SOCKET_PATH)

# Remove existing socket
rm -f $SOCKET_PATH

echo "Starting PHP-FPM..."
php-fpm --fpm-config /usr/local/etc/php-fpm.d/www.conf &

echo "Starting Nginx..."
nginx -g "daemon off;"