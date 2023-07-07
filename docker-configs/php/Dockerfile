FROM debian:11.4
RUN apt-get update && apt-get install -y wget curl sudo ca-certificates procps locales zip apt-transport-https git vim && rm -rf /var/lib/apt/lists/*
RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
RUN echo 'deb https://packages.sury.org/php/ bullseye main' > /etc/apt/sources.list.d/php.list
RUN apt-get update && apt-get install -y php8.2-redis php8.2-sqlite3 php8.2-bcmath php8.2-mbstring php8.2-xml php-amqplib php8.2-fpm php-pear php8.2 php8.2-apcu php8.2-cli php8.2-common php8.2-curl php8.2-dev php8.2-gd php8.2-imagick php8.2-intl php8.2-pgsql php8.2-xdebug php8.2-phpdbg php8.2-amqp bash-completion && rm -rf /var/lib/apt/lists/*
RUN pecl config-set php_ini /etc/php/8.2/fpm/php.ini

RUN cd /usr/local/bin && curl -s https://getcomposer.org/installer | php

RUN echo 'www-data ALL=(ALL) NOPASSWD: ALL' > /etc/sudoers.d/10_www_data
ADD www.conf /etc/php/8.2/fpm/pool.d/www.conf
ADD xdebug.ini /etc/php/8.2/mods-available/xdebug.ini
ADD start /usr/local/bin/start
RUN chmod a+x /usr/local/bin/start
RUN mkdir /app && chown www-data:www-data /app
RUN mkdir /var/www
ADD bash-history-user /var/www/.bashrc
ADD bash-history-root /root/.bashrc
RUN wget https://github.com/fabpot/local-php-security-checker/releases/download/v2.0.4/local-php-security-checker_2.0.4_linux_amd64 -O /usr/local/bin/security-checker
RUN chmod a+x /usr/local/bin/security-checker
RUN mkdir /app/uploads && chown www-data:www-data -R /app/uploads && chmod 777 -R /app/uploads
RUN mkdir -p "/opt/phpstorm-coverage" && chmod a+rw "/opt/phpstorm-coverage"
USER www-data
WORKDIR /app
CMD sudo /usr/local/bin/start
