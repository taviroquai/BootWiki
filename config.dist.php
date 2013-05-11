<?php

/*
 * PHP configuration
 */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('session.gc_probability', 0);

/*
 * Paths configuration
 */
define('APPPATH',       realpath('.'));
define('BASEURL',       '/bootwiki'); // IMPORTANT: YOU MAY NEED TO CHANGE THIS
define('DATAPATH',      APPPATH.'/web/data');
define('DATAURL',       BASEURL.'/web/data');
define('TEMPLATEPATH',  APPPATH.'/template');

/*
 * Database configuration
 */
define('DBDSN',     'sqlite:'.APPPATH.'/db/wiki.sqlite');
//define('DBDSN',   'mysql:host=localhost;dbname=bootwiki');
define('DBUSER',    '');
define('DBPASS',    '');

/*
 * SEO and Microdata (schema.org) configuration
 */
define('IDIOM',                 'en');
define('TITLE',                 'BootWiki');
define('DESCRIPTION',           'BootWiki is a minimal wiki built upon Twitter Boostrap, RedBeanPHP and Slim Framework');
define('KEYWORDS',              'wiki,boostrap,redbeanphp,slim');
define('AUTHOR',                'Marco Afonso');
define('ORGANIZATION_NAME',     'Organization');
define('ORGANIZATION_LOGO',     'web/img/logo_bar.png');
define('ORGANIZATION_FOUNDER',  'Founder');

/*
 * Register and mail configuration
 */
define('REGISTER_ALLOWED',  1);
define('ENCRYPT_SALT',      'wiki');
define('SEND_MAILS',        0);
define('EMAIL_HOST',        '');
define('EMAIL_SMTP',        1);
define('EMAIL_SMTP_SSL',    'tls');
define('EMAIL_SMTP_AUTH',   1);
define('EMAIL_AUTH_USER',   '');
define('EMAIL_AUTH_PASS',   '');
define('EMAIL_FROM',        '');
define('EMAIL_CC',          0);
define('EMAIL_BCC',         0);
//define('EMAIL_DEBUG_FILEPATH',  DATAPATH.'/mail.log');
define('EMAIL_DEBUG_FILEPATH',  0);
