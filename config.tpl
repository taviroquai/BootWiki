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
define('APPPATH',       '{apppath}');
define('BASEURL',       '{baseurl}'); // IMPORTANT: YOU MAY NEED TO CHANGE THIS
define('DATAPATH',      '{datapath}');
define('DATAURL',       '{dataurl}');
define('TEMPLATEPATH',  '{templatepath}');

/*
 * Database configuration
 */
define('DBDSN',     '{dbdsn}');
define('DBUSER',    '{dbuser}');
define('DBPASS',    '{dbpass}');

/*
 * SEO and Microdata (schema.org) configuration
 */
define('IDIOM',                 '{idiom}');
define('TITLE',                 '{title}');
define('DESCRIPTION',           '{description}');
define('KEYWORDS',              '{keywords}');
define('AUTHOR',                '{author}');
define('ORGANIZATION_NAME',     '{organization_name}');
define('ORGANIZATION_LOGO',     '{organization_logo}');
define('ORGANIZATION_FOUNDER',  '{organization_founder}');

/*
 * Register and mail configuration
 */
define('REGISTER_ALLOWED',  '{register_allowed}');
define('ENCRYPT_SALT',      '{encrypt_salt}');
define('SEND_MAILS',        '{send_mails}');
define('EMAIL_HOST',        '{email_host}');
define('EMAIL_SMTP',        '{email_smtp}');
define('EMAIL_SMTP_SSL',    '{email_smtp_ssl}');
define('EMAIL_SMTP_AUTH',   '{email_smtp_auth}');
define('EMAIL_AUTH_USER',   '{email_auth_user}');
define('EMAIL_AUTH_PASS',   '{email_auth_pass}');
define('EMAIL_FROM',        '{email_from}');
define('EMAIL_CC',          '{email_cc}');
define('EMAIL_BCC',         '{email_bcc}');
define('EMAIL_DEBUG_FILEPATH',  '{email_debug_filepath}');
