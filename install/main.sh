#!/usr/bin/env bash

DOCUMENT_ROOT="/var/www/test/public"
LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php

apt-get -y update
apt-get -y upgrade
apt-get -y autoremove
apt-get install -y apache2 curl php5.6-cli php5.6 libapache2-mod-php5.6 php5.6-dev php5.6-xdebug php5.6-curl

echo 'xdebug.remote_enable=on
xdebug.remote_connect_back=on
xdebug.idekey="vagrant"' >> /etc/php/5.6/cli/conf.d/20-xdebug.ini

echo "
<VirtualHost *:80>
    ServerName test.local
    DocumentRoot $DOCUMENT_ROOT
    <Directory $DOCUMENT_ROOT>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all

        RewriteEngine on
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^([^/]*)$ index.php?id=\$1

    </Directory>
</VirtualHost>
" > /etc/apache2/sites-available/test.conf
a2enmod rewrite
a2dissite 000-default
a2ensite test
service apache2 restart
cd /var/www/test