BootWiki
========

A Wiki built upon Twitter Bootstrap, RedBeanPHP and Slim Framework

Dependencies: Apache + PHP5.3 + Sqlite (or LAMP) and Composer

To install (LINUX) under /var/www/bootwiki:

1. cd to /var/www/bootwiki
2. sudo su
2. composer install
3. mv config.dist.php config.php
4. mv web/data.dist web/data
5. mkdir db
6. chown -R www-data db

Open config.php and change to your configuration, including MAIL configuration

Open http://localhost/bootwiki/install

Done!

Comments and help is appreciated.
