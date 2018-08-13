FROM php:apache

# Allow installation
RUN apt-get update

# Install php
RUN apt-get install -y curl git subversion mercurial openssh-client openssl unzip zip zlib1g-dev \
    && docker-php-ext-install opcache pcntl zip \
    && echo 'memory_limit=-1' > '/usr/local/etc/php/conf.d/memory-limit.ini' \
    && echo 'date.timezone="Europe/London"' > '/usr/local/etc/php/conf.d/date_timezone.ini'

# Set up apache
RUN a2enmod rewrite && sed -i 's!/var/www/html!/var/www/public!g' /etc/apache2/sites-available/000-default.conf

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH "/composer/vendor/bin:${PATH}"
RUN mkdir -p /composer/cache/files /composer/cache/repo /composer/cache/vcs  \
     && chmod -R 777 /composer \
     && curl -sfLo /tmp/composer-setup.php https://getcomposer.org/installer \
     && curl -sfLo /tmp/composer-setup.sig https://composer.github.io/installer.sig \
     && php -r " \
        \$hash = hash('SHA384', file_get_contents('/tmp/composer-setup.php')); \
        \$signature = trim(file_get_contents('/tmp/composer-setup.sig')); \
        if (!hash_equals(\$signature, \$hash)) { \
            unlink('/tmp/composer-setup.php'); \
            echo 'Integrity check failed, installer is either corrupt or worse.' . PHP_EOL; \
            exit(1); \
        }" \
     && php /tmp/composer-setup.php --no-ansi --install-dir=/usr/bin --filename=composer \
     && composer --no-interaction --no-ansi --version \
     && rm /tmp/composer-setup.php

# Clean up
RUN rm -rf /tmp/* /tmp/.htaccess \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /var/cache/* \
    && mv /var/www/html /var/www/public

# Install application
WORKDIR /var/www
COPY . /var/www
RUN composer install --no-interaction --no-ansi --no-dev \
    && chown -R "www-data:www-data" /var/www \
    && find /var/www -type d -exec chmod u+rwx,g+rxs,o-rwx {} + \
    && find /var/www -type f -exec chmod u+rw,g+r,o-rwx {} +

VOLUME /data
VOLUME /public