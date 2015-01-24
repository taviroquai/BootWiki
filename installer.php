<?php

/**
 * Force to display errors
 */
error_reporting(E_ALL);
ini_set('display_errors', true);
set_time_limit(0);

/**
 * Include required classes
 */
require_once 'lib/Requirement.php';
require_once 'lib/Requirement/DependenciesExists.php';
require_once 'lib/Requirement/MinPhpVersion.php';
require_once 'lib/Requirement/FolderWriteable.php';
require_once 'lib/Requirement/DatabaseDriversExists.php';
require_once 'lib/Requirement/DatabaseConnection.php';

/**
 * Setup configuration defaults
 */
$defaults = array(
    'step1' => array(
        'apppath' => realpath('.'),
        'baseurl' => dirname($_SERVER['REQUEST_URI']),
        'datapath'  => realpath('.').'/web/data',
        'dataurl'   => dirname($_SERVER['REQUEST_URI']).'/web/data',
        'templatepath'  => realpath('.').'/template'
    ),
    'step2' =>  array(
        'dbdriver'  => 'sqlite',
        'dbhost'    => 'localhost',
        'dbname'    => 'bootwiki',
        'dbfile'    => realpath('.').'/db/wiki.sqlite',
        'dbuser'    => 'bootwiki',
        'dbpass'    => 'bootwiki'
    ),
    'step3' => array(
        'idiom'         => 'en',
        'date_format'   => 'Y-m-d',
        'title'         => 'Bootwiki',
        'description'   => 'BootWiki is a minimal wiki built upon Twitter Boostrap, RedBeanPHP and Slim Framework',
        'keywords'      => 'wiki,boostrap,redbeanphp,slim',
        'author'        => 'Author name',
        'organization_name'     => 'Organization name',
        'organization_logo'     => 'web/img/logo_bar.png',
        'organization_founder'  => 'Founder\'s name'
     ),
    'step4' => array(
        'register_allowed'  => '1',
        'encrypt_salt'  => 'bootwiki',
        'send_mails'    => '0',
        'email_smtp'    => '1',
        'email_host'    => 'localhost',
        'email_smtp_ssl'=> 'tls',
        'email_smtp_auth'   => '1',
        'email_auth_user'   => '',
        'email_auth_pass'   => '',
        'email_from'    => 'name@isp.com',
        'email_cc'  => '',
        'email_bcc' => '',
        'email_debug_filepath' => realpath('.').'/mail.log'
    )
);

/**
 * Setup instalation steps
 */
$steps = array(
    array('label' => 'Application Paths and URLs', 'url' => 'installer.php?step=1'),
    array('label' => 'Database Configuration', 'url' => 'installer.php?step=2'),
    array('label' => 'SEO and Micro Data', 'url' => 'installer.php?step=3'),
    array('label' => 'Mail Configuration', 'url' => 'installer.php?step=4'),
    array('label' => 'Check configuration', 'url' => 'installer.php?step=5'),
    array('label' => 'Install database', 'url' => 'installer.php?step=6'),
    array('label' => 'Finish', 'url' => 'installer.php?step=7'),
);

/**
 * Use session to store user configuration
 */
session_start();
define('BASEURL', dirname($_SERVER['REQUEST_URI']));

/**
 * Init defaults
 */
for ($i = 1; $i <= 4; $i++) {
    if (empty($_SESSION['step'.$i])) {
        $_SESSION['step'.$i] = $defaults['step'.$i];
    }
}
if (!isset($_SESSION['step'])) $_SESSION['step'] = 1;
if (!empty($_POST)) {
    $_SESSION['step'.$_SESSION['step']] = $_POST;
    header('Location: installer.php?step='.($_SESSION['step']+1));
    die();
}
if (!empty($_GET['step']) && $_GET['step'] > 0 && $_GET['step'] <= count($steps)) {
    $_SESSION['step'] = $_GET['step'];
}

/**
 * Check for application requirements
 */
$requirements = array(
    new MinPHPVersion(),
    new DependenciesExists(),
    new FolderWriteable($_SESSION['step1']['datapath']),
    new FolderWriteable('config.php', 'touch config.php & sudo chmod 777 config.php'),
    new DatabaseDriversExists()
);
if ($_SESSION['step2']['dbdriver'] == 'sqlite') {
    $requirements[] = new FolderWriteable(dirname($_SESSION['step2']['dbfile']));
}

$requirements[] = new DatabaseConnection($_SESSION['step2']);

if (!empty($_SESSION['step4']['email_debug_filepath'])) {
    $tmp = $_SESSION['step4']['email_debug_filepath'];
    $requirements[] = new FolderWriteable($tmp, 'touch '.$tmp.' & sudo chmod 777 '.$tmp);
    unset($tmp);
}

$_SESSION['step5_ok'] = true;
if (!isset($_SESSION['step6_ok'])) $_SESSION['step6_ok'] = false;
foreach ($requirements as $item) {
    $item->result = $item->test();
    $_SESSION['step5_ok'] = $_SESSION['step5_ok'] & $item->result;
}

/**
 * Do not let to go further than step 5 if requirements are not met
 */
if (!$_SESSION['step5_ok'] && $_SESSION['step'] > 5) $_SESSION['step'] = 5;

/**
 * Requirements are ok, save configuration now
 */
if ($_SESSION['step5_ok']) {
    $step6_results = array();
    
    $config_content = file_get_contents('config.tpl');
    $config_items = array_merge($_SESSION['step1'], $_SESSION['step2'], $_SESSION['step3'], $_SESSION['step4']);
    foreach ($config_items as $k => $v) {
        $config_content = str_replace('{'.$k.'}', addslashes($v), $config_content);
    }
    if ($_SESSION['step2']['dbdriver'] == 'sqlite') {
        $dsn = 'sqlite:'.$_SESSION['step2']['dbfile'];
    } else {
        $dsn = $_SESSION['step2']['dbdriver']
                .':host='.$_SESSION['step2']['dbhost'].';'
                .'dbname='.$_SESSION['step2']['dbname'];
    }
    $config_content = str_replace('{dbdsn}', $dsn, $config_content);
    unset($dsn);
    if (file_put_contents('config.php', $config_content)) {
        $step6_results[] = 'config.php file was updated';
    } else {
        $step6_results[] = 'config.php file could not be updated';
    }
    $count = glob(rtrim($_SESSION['step1']['datapath'], '/').'/*');
    if (empty($count)) {
        exec('cp -R web/data.dist/* '.$_SESSION['step1']['datapath'], $output3);
        $step6_results[] = 'Copy default data to '.$_SESSION['step1']['datapath'];
    }
    if (!empty($_SESSION['step2']['dbfile']) && !file_exists($_SESSION['step2']['dbfile'])) {
        exec('touch '.$_SESSION['step2']['dbfile']);
        $step6_results[] = 'Create database file: '.$_SESSION['step2']['dbfile'];
    }
}

/**
 * STEP 6 - Create database with demo data
 */
if ($_SESSION['step'] == 6 && $_SESSION['step5_ok']) {
    
    $step6_results = array();
    try {
        require_once 'vendor/autoload.php';
        require_once 'lib/Link.php';
        require_once 'lib/BootWiki.php';
        require_once 'lib/Idiom.php';
        require_once 'lib/Image.php';
        require_once 'lib/Content.php';
        require_once 'lib/BootWiki.php';
        if ($_SESSION['step2']['dbdriver'] == 'mysql') {
            $dsn = $_SESSION['step2']['dbdriver'].':host='.$_SESSION['step2']['dbhost'].';dbname='.$_SESSION['step2']['dbname'];
        } else {
            $dsn = $_SESSION['step2']['dbdriver'].':'.$_SESSION['step2']['dbfile'];
        }
        RedBean_Facade::setup($dsn, $_SESSION['step2']['dbuser'], $_SESSION['step2']['dbpass']);
        
        define('ENCRYPT_SALT', $_SESSION['step4']['encrypt_salt']);
        BootWiki::install();
        $step6_results[] = 'Database instalation was completed';
        $_SESSION['step6_ok'] = true;
    } catch (\PDOException $e) {
        $step6_results[] = 'Database error: '.$e->getMessage();
    }
}

/**
 * Do not let to go further than step 6 if database is not installed
 */
if (!$_SESSION['step6_ok'] && $_SESSION['step'] > 6) $_SESSION['step'] = 5;

require_once $_SESSION['step1']['templatepath']
        .DIRECTORY_SEPARATOR.'en'
        .DIRECTORY_SEPARATOR.'installer.php';