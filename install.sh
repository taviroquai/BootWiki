#! /bin/bash

clear

echo "Installing bootwiki..."

composer install

echo "Creating configuration from config.dist.php..."
mv config.dist.php config.php

echo "Creating data directory from web/data.dist..."
4. mv web/data.dist web/data

echo "Giving Apache permissions to data directory..."
5. chown -R www-data web/data
6. chmod -R 2775 web/data

echo "Creating db directory..."
7. mkdir db

echo "Creating sqlite file..."
8. touch db/wiki.sqlite

echo "Giving Apache permissions to db directory..."
9. chown -R www-data db
10. chmod -R 2775 db

echo "Done!"
echo "IMPORTANT: Please open config.php and setup your settings."
