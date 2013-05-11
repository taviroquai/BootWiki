#! /bin/bash

clear

echo "Installing bootwiki..."

composer install

echo "Creating configuration from config.dist.php..."
mv config.dist.php config.php

echo "Creating data directory from web/data.dist..."
mv web/data.dist web/data

echo "Giving Apache permissions to data directory..."
chown -R www-data web/data
chmod -R 2775 web/data

echo "Creating db directory..."
mkdir db

echo "Creating sqlite file..."
touch db/wiki.sqlite

echo "Giving Apache permissions to db directory..."
chown -R www-data db
chmod -R 2775 db

echo "Done!"
echo "IMPORTANT: Please open config.php and setup your settings."
echo "DON'T FORGET to remove install_bootwiki.sh and edit index.php to remove install path."
