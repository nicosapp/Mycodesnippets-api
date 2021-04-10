FROM php:7.4-apache
RUN apt-get update -qq && \
    apt-get install -qy \
    supervisor \
    wget \
    zip \
    libzip-dev \
    unzip \
    libicu-dev \
    libedit-dev \
    libfcgi0ldbl \
    libfreetype6-dev \
    libicu-dev \
    libpng-dev \
    libpq-dev \
    libxpm-dev \
    locales \
    gnupg2 \
    git-core \
    openssh-server \
    fonts-powerline \
    zsh \
    libsodium-dev

RUN pecl install 
RUN docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure sodium \
    && docker-php-ext-install -j$(nproc) mysqli pdo pdo_mysql intl opcache json readline gd sodium exif zip \
    && apt-get upgrade -y

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

#Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# Laravel

#Install Node.js
RUN curl -sL https://deb.nodesource.com/setup_15.x | bash - && \
    apt-get install -y nodejs

#SSH configuration
RUN apt-get update && apt-get install gnupg2 -y

#Install oh-my-zsh
ENV ZSH_INSTALL_DIR="/var/www"
RUN wget https://github.com/robbyrussell/oh-my-zsh/raw/master/tools/install.sh -O - | zsh || true
RUN cp -r /root/.oh-my-zsh ${ZSH_INSTALL_DIR}
RUN git clone --depth=1 https://github.com/romkatv/powerlevel10k.git ${ZSH_CUSTOM:-$ZSH_INSTALL_DIR/.oh-my-zsh/custom}/themes/powerlevel10k
COPY .p10k.zsh $ZSH_INSTALL_DIR/.p10k.zsh
COPY .zshrc $ZSH_INSTALL_DIR/.zshrc
COPY .env /var/www/html/

RUN chown -R www-data:www-data /var/www
RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data
RUN a2enmod rewrite