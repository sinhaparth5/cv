FROM nginx:alpine

# Install PHP and PHP-FPM
RUN apk add --no-cache \
    php \
    php-fpm \
    php-json \
    php-openssl \
    php-curl \
    php-zlib \
    php-xml \
    php-phar \
    php-intl \
    php-dom \
    php-xmlreader \
    php-ctype \
    php-session \
    php-mbstring \
    php-gd \
    supervisor

# Copy nginx configuration
COPY nginx.conf /etc/nginx/nginx.conf
COPY default.conf /etc/nginx/conf.d/default.conf

# Copy PHP-FPM configuration
COPY php-fpm.conf /etc/php83/php-fpm.d/www.conf

# Copy supervisord configuration
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Create web directory
RUN mkdir -p /var/www/html
WORKDIR /var/www/html

# Copy website files
COPY src/ /var/www/html/

# Set permissions
RUN chown -R nginx:nginx /var/www/html
RUN chmod -R 755 /var/www/html

# Create PHP-FPM socket directory
RUN mkdir -p /run/php

EXPOSE 8000

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]