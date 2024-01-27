FROM ubuntu:22.04

ARG NODE_VERSION=18
ARG user
ARG uid

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

# Install required dependencies
RUN apt-get update \
    && apt-get install -y gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 libcap2-bin libpng-dev python2 dnsutils \
    && ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Add PHP repository and install PHP and other dependencies
RUN curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0x14aa40ec0831756756d7f66c4f4ea0aae5267a6c' | gpg --dearmor | tee /usr/share/keyrings/ppa_ondrej_php.gpg > /dev/null \
    && echo "deb [signed-by=/usr/share/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu jammy main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update \
    && apt-get install -y php8.2-cli php8.2-dev \
       php8.2-sqlite3 php8.2-gd \
       php8.2-curl \
       php8.2-imap php8.2-mysql php8.2-mbstring \
       php8.2-xml php8.2-zip php8.2-bcmath php8.2-soap \
       php8.2-intl php8.2-readline \
       php8.2-ldap \
       php8.2-msgpack php8.2-igbinary php8.2-redis php8.2-swoole \
       php8.2-memcached php8.2-pcov php8.2-xdebug \
       php8.2-fpm \
    && php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install Node.js and Yarn
RUN curl -sS https://deb.nodesource.com/setup_$NODE_VERSION.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm \
    && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | gpg --dearmor | tee /usr/share/keyrings/yarn.gpg >/dev/null \
    && echo "deb [signed-by=/usr/share/keyrings/yarn.gpg] https://dl.yarnpkg.com/debian/ stable main" > /etc/apt/sources.list.d/yarn.list \
    && apt-get update \
    && apt-get install -y yarn \
    && apt-get install -y mysql-client \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Set capabilities for PHP
RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.2

COPY . /var/www/html
COPY docker/nginx/start-container /usr/local/bin/start-container
COPY docker/nginx/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/nginx/php.ini /etc/php/8.2/cli/conf.d/99-sail.ini
COPY docker/nginx/nginx.conf /etc/nginx/sites-enabled/default
RUN chmod +x /usr/local/bin/start-container


RUN chown -R $user:$user  /var/www/html \
&& chown -R $user:$user /var/www/html/storage \
&& chmod +x /usr/local/bin/start-container \
&& chmod -R 775 /var/www/html/storage \
&& chmod -R 775 /var/www/html/storage/logs \
&& chmod +x /usr/local/bin/start-container \
&& chmod -R 775 /var/www/html/ 

USER $user

# Composer and NPM installation
RUN composer install --optimize-autoloader \
    && npm install \
    && npm run build

EXPOSE 80

ENTRYPOINT ["start-container"]
