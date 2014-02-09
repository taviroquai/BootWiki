<?php

error_reporting(E_ALL);
ini_set('display_errors', true);
set_time_limit(0);

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
        'idiom'     => 'en',
        'title'     => 'Bootwiki',
        'description'   => 'BootWiki is a minimal wiki built upon Twitter Boostrap, RedBeanPHP and Slim Framework',
        'keywords'  => 'wiki,boostrap,redbeanphp,slim',
        'author'    => 'Author name',
        'organization_name' => 'Organization name',
        'organization_logo' => 'web/img/logo_bar.png',
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

$steps = array(
    array('label' => 'Application Paths and URLs', 'url' => 'installer.php?step=1'),
    array('label' => 'Database Configuration', 'url' => 'installer.php?step=2'),
    array('label' => 'SEO and Micro Data', 'url' => 'installer.php?step=3'),
    array('label' => 'Mail Configuration', 'url' => 'installer.php?step=4'),
    array('label' => 'Check configuration', 'url' => 'installer.php?step=5'),
    array('label' => 'Save configuration', 'url' => 'installer.php?step=6'),
    array('label' => 'Install database', 'url' => 'installer.php?step=7'),
    array('label' => 'Finish', 'url' => 'installer.php?step=8'),
);

session_start();

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

define('BASEURL', dirname($_SERVER['REQUEST_URI']));

require_once 'lib/Requirement.php';
require_once 'lib/Requirement/DependenciesExists.php';
require_once 'lib/Requirement/MinPhpVersion.php';
require_once 'lib/Requirement/FolderWriteable.php';
require_once 'lib/Requirement/DatabaseDriversExists.php';
require_once 'lib/Requirement/DatabaseConnection.php';
    
$requirements = array(
    new MinPHPVersion(),
    new DependenciesExists(),
    new FolderWriteable($_SESSION['step1']['datapath']),
    new FolderWriteable('config.php', 'touch config.php & sudo chmod 777 config.php'),
    new DatabaseDriversExists(),
    new DatabaseConnection($_SESSION['step2'])
);
if ($_SESSION['step2']['dbdriver'] == 'sqlite') {
    $requirements[] = new FolderWriteable(dirname($_SESSION['step2']['dbfile']));
}
if (!empty($_SESSION['step4']['email_debug_filepath'])) {
    $tmp = $_SESSION['step4']['email_debug_filepath'];
    $requirements[] = new FolderWriteable($tmp, 'touch '.$tmp.' & sudo chmod 777 config.php');
    unset($tmp);
}

$step5 = true;
foreach ($requirements as $item) {
    $item->result = $item->test();
    $step5 = $step5 & $item->result;
}

if (!$step5 && $_SESSION['step'] > 5) $_SESSION['step'] = 5;

if ($_SESSION['step'] == 6 && $step5) {
    
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
    $count = glob('web/data.dist/*');
    if (empty($count)) {
        exec('cp -R web/data.dist/* '.$_SESSION['step1']['datapath'], $output3);
        $step6_results[] = 'Copy default data to '.$_SESSION['step1']['datapath'];
    }
    if (!empty($_SESSION['step2']['dbfile']) && !file_exists($_SESSION['step2']['dbfile'])) {
        exec('touch '.$_SESSION['step2']['dbfile']);
        $step6_results[] = 'Create database file: '.$_SESSION['step2']['dbfile'];
    }
    $step6 = true;
}

if ($_SESSION['step'] == 7 && $step5) {
    
    $step7_results = array();
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
        $step7_results[] = 'Database instalation was completed';
        $step7 = true;
    } catch (\PDOException $e) {
        $step7_results[] = 'Database error: '.$e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>BootWiki Installer &copy; Marco Afonso 2013 - <?=date('Y')?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="description" content="BootWiki friendly installer">
    <meta name="keywords" content="install BootWiki">
    
    <base href="<?=BASEURL?>/">

    <!-- Le styles -->
    <link href="http://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="web/css/bootstrap.css">
    <link rel="stylesheet" href="web/bootstrap-fileupload/bootstrap-fileupload.min.css">
    <link rel="stylesheet" href="web/css/bootstrap-wysihtml5-0.0.2.css">
    <link rel="stylesheet" href="web/css/bootstrap-responsive.css">
    <link rel="stylesheet" href="web/css/wiki.css">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="web/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="web/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="web/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="web/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="web/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="web/ico/favicon.png">
    
    <!-- Include the badass jQuery -->
    <script src="web/js/jquery-1.7.1.min.js"></script>
  </head>

  <body itemscope itemtype="http://schema.org/WebPage">

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" style="padding: 0" href="<?=BASEURL?>">
            <span itemprop="logo" itemscope itemtype="http://schema.org/ImageObject">
                <img itemprop="contentURL" src="web/img/logo_bar.png" alt="BootWiki" title="BootWiki" />
            </span>
            <meta itemprop="name" content="BootWiki">
          </a>
          <div class="nav-collapse collapse">
            <ul class="nav">
                <li>
                    <a href="installer.php">Installer</a>
                </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
            
            <div class="well sidebar-nav">
              <ul class="nav nav-list">
                <li class="nav-header">Installation Steps</li>
                <? foreach ($steps as $item) { ?>
                  <li>
                      <a href="<?=$item['url']?>"><?=$item['label']?> <!--<span class="label wiki-date-min">done</span>--></a>
                  </li>
                <? } ?>
              </ul>
            </div><!--/.well -->
                                
        </div><!--/span-->
        <div class="span9">
                
            <div class="hero-unit">
              <h1><a href="#">BootWiki Installer</a></h1>
              
              <p>A Wiki built upon Twitter Bootstrap, Slim framework and RedBeanPHP</p>
              
              <div class="clearfix"></div>
            </div>
            
            <hr />
            
            <div class="row-fluid">
              <div class="span12">
                  
                  <?php if ($_SESSION['step'] == 1) { ?>
                  <h2>Step 1 of 8</h2>
                  <form method="post">
                      <fieldset>
                          <legend>Application Paths and URLs</legend>
                            <label>Application directory</label>
                            <input type="text" name="apppath" placeholder="/var/www/bootwiki"
                                   value="<?=$_SESSION['step1']['apppath']?>"
                                   title="This is where lives bootwiki files">
                            
                            <label>Base URL</label>
                            <input type="text" name="baseurl" placeholder="/bootwiki"
                                   value="<?=$_SESSION['step1']['baseurl']?>"
                                   title="This is the base URL for all application links">
                            
                            <label>Public DATA directory</label>
                            <input type="text" name="datapath" placeholder="/var/www/bootwiki/web/data"
                                   value="<?=$_SESSION['step1']['datapath']?>"
                                   title="This is where public files will be saved">
                            
                            <label>Public DATA URL</label>
                            <input type="text" name="dataurl" placeholder="/bootwiki/web/data"
                                   value="<?=$_SESSION['step1']['dataurl']?>"
                                   title="This is the base URL to access public DATA">
                            
                            <label>Templates Directory</label>
                            <input type="text" name="templatepath" placeholder="/bootwiki/template"
                                   value="<?=$_SESSION['step1']['templatepath']?>"
                                   title="This is where lives application templates">
                            
                      </fieldset>
                      <button type="submit" class="btn btn-primary">Next</button>
                  </form>
                  <?php } ?>
                  
                  <?php if ($_SESSION['step'] == 2) { ?>
                  <h2>Step 2 of 8</h2>
                  <form method="post">
                      <fieldset>
                          <legend>Database Configuration</legend>
                            <label>Driver</label>
                            <label class="radio">
                                <input type="radio" name="dbdriver" value="sqlite"
                                       <?=$_SESSION['step2']['dbdriver'] == 'sqlite' ? 'checked' : ''?>>
                                SQLite - Good for small databases and easy to migrate
                              </label>
                              <label class="radio">
                                <input type="radio" name="dbdriver" value="mysql"
                                       <?=$_SESSION['step2']['dbdriver'] == 'mysql' ? 'checked' : ''?>>
                                MySQL - High performance for large databases
                              </label>
                            
                            <label>Database File (SQLite)</label>
                            <input type="text" name="dbfile" placeholder="./db/wiki.sqlite"
                                   value="<?=$_SESSION['step2']['dbfile']?>"
                                   title="The name for the MySQL database">
                            
                            <label>Database Host (MySQL)</label>
                            <input type="text" name="dbhost" placeholder="bootwiki"
                                   value="<?=$_SESSION['step2']['dbhost']?>"
                                   title="The name for the MySQL host">
                            
                            <label>Database Name (MySQL)</label>
                            <input type="text" name="dbname" placeholder="bootwiki"
                                   value="<?=$_SESSION['step2']['dbname']?>"
                                   title="The name for the MySQL database">
                            
                            <label>Database User (MySQL)</label>
                            <input type="text" name="dbuser" placeholder="bootwiki"
                                   value="<?=$_SESSION['step2']['dbuser']?>"
                                   title="The username to connect to database">
                            
                            <label>Database Password (MySQL)</label>
                            <input type="text" name="dbpass" placeholder="bootwiki"
                                   value="<?=$_SESSION['step2']['dbpass']?>"
                                   title="The password to connect to database">      
                      </fieldset>
                      <button type="submit" class="btn btn-primary">Next</button>
                  </form>
                  <?php } ?>

                  <?php if ($_SESSION['step'] == 3) { ?>
                  <h2>Step 3 of 8</h2>
                  <form method="post">
                      <fieldset>
                          <legend>SEO and Microdata</legend>
                            
                            <label>Idiom</label>
                            <input type="text" name="idiom" placeholder="en"
                                   value="<?=$_SESSION['step3']['idiom']?>"
                                   title="Default idiom">
                            
                            <label>Default Page Title</label>
                            <input type="text" name="title" placeholder="Bootwiki"
                                   value="<?=$_SESSION['step3']['title']?>"
                                   title="The default page title to be listen in search engines">
                            
                            <label>Default Description</label>
                            <input type="text" name="description" placeholder="BootWiki is a minimal wiki built upon Twitter Boostrap, RedBeanPHP and Slim Framework"
                                   value="<?=$_SESSION['step3']['description']?>"
                                   title="The default description to be listed in search engines">
                            
                            <label>Default Keywords</label>
                            <input type="text" name="keywords" placeholder="wiki,boostrap,redbeanphp,slim"
                                   value="<?=$_SESSION['step3']['keywords']?>"
                                   title="The default keywords to be used by search engines">
                            
                            <label>Site Author Name</label>
                            <input type="text" name="author" placeholder="My Name"
                                   value="<?=$_SESSION['step3']['author']?>"
                                   title="The page author">
                            
                            <label>Organization Name</label>
                            <input type="text" name="organization_name" placeholder="My Organization name"
                                   value="<?=$_SESSION['step3']['organization_name']?>"
                                   title="The organization name">
                            
                            <label>Organization Logo</label>
                            <input type="text" name="organization_logo" placeholder="path/to/public/logo.png"
                                   value="<?=$_SESSION['step3']['organization_logo']?>"
                                   title="The organization logo image path">
                            
                            <label>Organization Founder</label>
                            <input type="text" name="organization_founder" placeholder="Organization founder name"
                                   value="<?=$_SESSION['step3']['organization_founder']?>"
                                   title="The organization founder name">
                      </fieldset>
                      <button type="submit" class="btn btn-primary">Next</button>
                  </form>
                  <?php } ?>
                  
                  <?php if ($_SESSION['step'] == 4) { ?>
                  <h2>Step 4 of 8</h2>
                  <form method="post">
                      <fieldset>
                          <legend>Mail Configuration</legend>
                            
                            <label>Registration Allowed</label>
                            <label class="radio">
                                <input type="radio" name="register_allowed" value="1" 
                                       <?=$_SESSION['step4']['register_allowed'] == '1' ? 'checked' : ''?>>
                                Yes
                              </label>
                              <label class="radio">
                                <input type="radio" name="register_allowed" value="0"
                                       <?=$_SESSION['step4']['register_allowed'] == '0' ? 'checked' : ''?>>
                                No
                              </label>
                            
                            <label>Password Encryption Salt</label>
                            <input type="text" name="encrypt_salt" placeholder="bootwiki"
                                   value="<?=$_SESSION['step4']['encrypt_salt']?>"
                                   title="Used to encrypt user passwords">
                            
                            <label>Send emails</label>
                            <label class="radio">
                                <input type="radio" name="send_mails" value="1" 
                                       <?=$_SESSION['step4']['send_mails'] == '1' ? 'checked' : ''?>>
                                Yes
                              </label>
                              <label class="radio">
                                <input type="radio" name="send_mails" value="0"
                                       <?=$_SESSION['step4']['send_mails'] == '0' ? 'checked' : ''?>>
                                No
                              </label>
                            
                            <label>SMTP Protocol</label>
                            <label class="radio">
                                <input type="radio" name="email_smtp" value="1"
                                       <?=$_SESSION['step4']['email_smtp'] == '1' ? 'checked' : ''?>>
                                Yes
                              </label>
                              <label class="radio">
                                <input type="radio" name="email_smtp" value="0"
                                       <?=$_SESSION['step4']['email_smtp'] == '0' ? 'checked' : ''?>>
                                No
                              </label>
                            
                            <label>SMTP Mail Host</label>
                            <input type="text" name="email_host" placeholder="localhost"
                                   value="<?=$_SESSION['step4']['email_host']?>"
                                   title="The host that will send emails">
                            
                            <label>SMTP SSL</label>
                            <input type="text" name="email_smtp_ssl" placeholder="tls"
                                   value="<?=$_SESSION['step4']['email_smtp_ssl']?>"
                                   title="Tells which SSL prototol phpmailer will use">
                            
                            <label>SMTP Authentication</label>
                            <label class="radio">
                                <input type="radio" name="email_smtp_auth" value="1"
                                       <?=$_SESSION['step4']['email_smtp_auth'] == '1' ? 'checked' : ''?>>
                                Yes
                              </label>
                              <label class="radio">
                                <input type="radio" name="email_smtp_auth" value="0"
                                       <?=$_SESSION['step4']['email_smtp_auth'] == '0' ? 'checked' : ''?>>
                                No
                              </label>
                            
                            <label>Authentication User</label>
                            <input type="text" name="email_auth_user" placeholder="username or email"
                                   value="<?=$_SESSION['step4']['email_auth_user']?>"
                                   title="The username or email to authenticate at the mail server">
                            
                            <label>Authentication Password</label>
                            <input type="text" name="email_auth_path" placeholder="password"
                                   value="<?=$_SESSION['step4']['email_auth_pass']?>"
                                   title="The password to authenticate at the mail server">
                            
                            <label>Sender mail address (FROM)</label>
                            <input type="text" name="email_from" placeholder="Sender name"
                                   value="<?=$_SESSION['step4']['email_from']?>"
                                   title="The email that will be used when sending emails">
                            
                            <label>CC mail address (Optional)</label>
                            <input type="text" name="email_cc" placeholder="Mail copy address or empty"
                                   value="<?=$_SESSION['step4']['email_cc']?>"
                                   title="The email that will receive a copy. Leave empty if not used">
                            
                            <label>CC mail address (Optional)</label>
                            <input type="text" name="email_bcc" placeholder="Mail blind copy address or empty"
                                   value="<?=$_SESSION['step4']['email_bcc']?>"
                                   title="The email that will receive a copy. Leave empty if not used">
                            
                            <label>Send email debug file (Optional)</label>
                            <input type="text" name="email_debug_filepath" placeholder="./mail.log"
                                   value="<?=$_SESSION['step4']['email_debug_filepath']?>"
                                   title="The file where email logs will be saved ">
                            
                      </fieldset>
                      <button type="submit" class="btn btn-primary">Next</button>
                  </form>
                  <?php } ?>
                  
                  <?php if ($_SESSION['step'] == 5) { ?>
                  <h2>Step 5 of 8</h2>
                  <table class="table">
                      <thead>
                          <tr>
                              <th class="span6">Requirement</th>
                              <th class="span2">Result</th>
                              <th class="span4">Hint</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php foreach ($requirements as $item) { ?>
                          <tr>
                              <td><?=$item->label?></td>
                              <td><?=$item->result ? '<span class="label label-success">OK</span>' : '<span class="label label-important">Failed</span>'?></td>
                              <td><?=!$item->result? $item->hint : ''?></td>
                          </tr>
                          <?php } ?>
                      </tbody>
                  </table>
                  
                  <hr />
                  <?php if ($step5) { ?>
                    <a href="installer.php?step=6" class="btn btn-primary">Next...</a>
                  <?php } else { ?>
                    <a href="installer.php?step=5" class="btn btn-primary">Re-check</a>
                  <?php } ?>
                  <?php } ?>
                  
                  <?php if ($_SESSION['step'] == 6) { ?>
                        <h2>Step 6 of 8</h2>
                        <h3>Save Configuration</h3>
                        <?php foreach ($step6_results as $line) {
                            echo '<br />'.$line;
                        } ?>
                        <a href="installer.php?step=7" class="btn btn-primary">Next...</a>
                  <?php } ?>
                 
                  <?php if ($_SESSION['step'] == 7) { ?>
                        <h2>Step 7 of 8</h2>
                        <h3>Install Database</h3>
                        <?php foreach ($step7_results as $line) {
                            echo '<br />'.$line;
                        } ?>
                        <a href="installer.php?step=8" class="btn btn-primary">Next...</a>
                  <?php } ?>
                        
                  <?php if ($_SESSION['step'] == 8) { ?>
                        <h2>Step 8 of 8</h2>
                        <p>Installer is complete! 
                            Click <a href="index.php" target="_blank">here</a> to see your new wiki</p>
                        <p>If something went wrong, you can yet reconfigure all again.</p>
                        <p>IMPORTANTE: DO NOT FORGET TO REMOVE THIS INSTALL SCRIPT (installer.php) ONCE CONFIGURATION IS COMPLETE</p>
                  <?php } ?>
                  
              </div><!--/span-->
            </div><!--/row-->

        </div><!--/span-->
      </div><!--/row-->
    </div><!--/.fluid-container-->
    
    <footer class="navbar navbar-fixed-bottom">
        <div class="navbar-inner">
            <div class="pull-right">BootWiki &copy; Marco Afonso 2013 - <?=date('Y')?></div>
        </div>
    </footer>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="web/js/bootstrap.min.js"></script>
    
  </body>
</html>