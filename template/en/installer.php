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
    <link rel="stylesheet" href="web/css/bootstrap.min.css">
    <link rel="stylesheet" href="web/css/dashboard.css">
    <link rel="stylesheet" href="web/bootstrap-fileupload/bootstrap-fileupload.min.css">
    <link rel="stylesheet" href="web/css/bootstrap-wysihtml5-0.0.2.css">

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
    <script src="web/js/jquery.min.js"></script>
  </head>

  <body itemscope itemtype="http://schema.org/WebPage">

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?=BASEURL?>">
            <span itemprop="logo" itemscope itemtype="http://schema.org/ImageObject">
                <img itemprop="contentURL" src="web/img/logo_bar.png" alt="BootWiki" title="BootWiki" />
            </span>
            <meta itemprop="name" content="BootWiki">
          </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <li>
              <a href="installer.php">Installer</a>
          </li>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-3 sidebar">
            
            <ul class="nav nav-sidebar">
              <li class="nav-header">Installation Steps</li>
              <?php foreach ($steps as $item) { ?>
                <li>
                    <a href="<?=$item['url']?>"><?=$item['label']?> <!--<span class="label wiki-date-min">done</span>--></a>
                </li>
              <?php } ?>
            </ul>
                                
        </div><!--/span-->
        <div class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3 main">
                
              <h1><a href="#">BootWiki Installer</a></h1>
              
              <p>A Wiki built upon Twitter Bootstrap, Slim framework and RedBeanPHP</p>
              
              <div class="clearfix"></div>
            
              <hr />
            
        
              
              <?php if ($_SESSION['step'] == 1) { ?>
              <h2>Step 1 of 7</h2>
              <form method="post">
                  <fieldset>
                      <legend>Application Paths and URLs</legend>

                      <div class="form-group">
                        <label>Application directory</label>
                        <input type="text" name="apppath" placeholder="/var/www/bootwiki"
                              class="form-control"
                               value="<?=$_SESSION['step1']['apppath']?>"
                               title="This is where lives bootwiki files">
                      </div>
                      <div class="form-group">
                        <label>Base URL</label>
                        <input type="text" name="baseurl" placeholder="/bootwiki"
                              class="form-control"
                               value="<?=$_SESSION['step1']['baseurl']?>"
                               title="This is the base URL for all application links">
                      </div>
                      <div class="form-group">
                        <label>Public DATA directory</label>
                        <input type="text" name="datapath" placeholder="/var/www/bootwiki/web/data"
                              class="form-control"
                               value="<?=$_SESSION['step1']['datapath']?>"
                               title="This is where public files will be saved">
                      </div>
                      <div class="form-group">
                        <label>Public DATA URL</label>
                        <input type="text" name="dataurl" placeholder="/bootwiki/web/data"
                              class="form-control"
                               value="<?=$_SESSION['step1']['dataurl']?>"
                               title="This is the base URL to access public DATA">
                      </div>
                      <div class="form-group">
                        <label>Templates Directory</label>
                        <input type="text" name="templatepath" placeholder="/bootwiki/template"
                              class="form-control"
                               value="<?=$_SESSION['step1']['templatepath']?>"
                               title="This is where lives application templates">
                      </div>
                  </fieldset>
                  <button type="submit" class="btn btn-primary">Next</button>
              </form>
              <?php } ?>
              
              <?php if ($_SESSION['step'] == 2) { ?>
              <h2>Step 2 of 7</h2>
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
                        
                        <div class="form-group">
                          <label>Database File (SQLite)</label>
                          <input type="text" name="dbfile" placeholder="./db/wiki.sqlite"
                                class="form-control"
                                 value="<?=$_SESSION['step2']['dbfile']?>"
                                 title="The name for the MySQL database">
                        </div>
                        <div class="form-group">
                          <label>Database Host (MySQL)</label>
                          <input type="text" name="dbhost" placeholder="bootwiki"
                                class="form-control"
                                 value="<?=$_SESSION['step2']['dbhost']?>"
                                 title="The name for the MySQL host">
                        </div>
                        <div class="form-group">
                          <label>Database Name (MySQL)</label>
                          <input type="text" name="dbname" placeholder="bootwiki"
                                class="form-control"
                                 value="<?=$_SESSION['step2']['dbname']?>"
                                 title="The name for the MySQL database">
                        </div>
                        <div class="form-group">
                          <label>Database User (MySQL)</label>
                          <input type="text" name="dbuser" placeholder="bootwiki"
                                class="form-control"
                                 value="<?=$_SESSION['step2']['dbuser']?>"
                                 title="The username to connect to database">
                        </div>
                        <div class="form-group">
                          <label>Database Password (MySQL)</label>
                          <input type="text" name="dbpass" placeholder="bootwiki"
                                class="form-control"
                                 value="<?=$_SESSION['step2']['dbpass']?>"
                                 title="The password to connect to database">      
                        </div>
                  </fieldset>
                  <button type="submit" class="btn btn-primary">Next</button>
              </form>
              <?php } ?>

              <?php if ($_SESSION['step'] == 3) { ?>
              <h2>Step 3 of 7</h2>
              <form method="post">
                  <fieldset>
                      <legend>SEO and Microdata</legend>
                        
                        <div class="form-group">
                          <label>Idiom</label>
                          <select name="idiom" class="form-control" title="Default idiom">
                            <option <?=$_SESSION['step3']['idiom'] == 'en' ? 'selected':''?>
                              value="en">en</option>
                            <option <?=$_SESSION['step3']['idiom'] == 'pt' ? 'selected':''?>
                              value="pt">pt</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>Date Format (PHP date function)</label>
                          <input type="text" name="date_format" placeholder="Y-m-d"
                                class="form-control"
                                 value="<?=$_SESSION['step3']['date_format']?>"
                                 title="Default date format">
                        </div>
                        <div class="form-group">
                          <label>Default Page Title</label>
                          <input type="text" name="title" placeholder="Bootwiki"
                                class="form-control"
                                 value="<?=$_SESSION['step3']['title']?>"
                                 title="The default page title to be listen in search engines">
                        </div>
                        <div class="form-group">
                          <label>Default Description</label>
                          <input type="text" name="description" placeholder="BootWiki is a minimal wiki built upon Twitter Boostrap, RedBeanPHP and Slim Framework"
                                class="form-control"
                                 value="<?=$_SESSION['step3']['description']?>"
                                 title="The default description to be listed in search engines">
                        </div>
                        <div class="form-group">
                          <label>Default Keywords</label>
                          <input type="text" name="keywords" placeholder="wiki,boostrap,redbeanphp,slim"
                                class="form-control"
                                 value="<?=$_SESSION['step3']['keywords']?>"
                                 title="The default keywords to be used by search engines">
                        </div>
                        <div class="form-group">
                          <label>Site Author Name</label>
                          <input type="text" name="author" placeholder="My Name"
                                class="form-control"
                                 value="<?=$_SESSION['step3']['author']?>"
                                 title="The page author">
                        </div>
                        <div class="form-group">
                          <label>Organization Name</label>
                          <input type="text" name="organization_name" placeholder="My Organization name"
                                class="form-control"
                                 value="<?=$_SESSION['step3']['organization_name']?>"
                                 title="The organization name">
                        </div>
                        <div class="form-group">
                          <label>Organization Logo</label>
                          <input type="text" name="organization_logo" placeholder="path/to/public/logo.png"
                                class="form-control"
                                 value="<?=$_SESSION['step3']['organization_logo']?>"
                                 title="The organization logo image path">
                        </div>
                        <div class="form-group">
                          <label>Organization Founder</label>
                          <input type="text" name="organization_founder" placeholder="Organization founder name"
                                class="form-control"
                                 value="<?=$_SESSION['step3']['organization_founder']?>"
                                 title="The organization founder name">
                        </div>
                  </fieldset>
                  <button type="submit" class="btn btn-primary">Next</button>
              </form>
              <?php } ?>
              
              <?php if ($_SESSION['step'] == 4) { ?>
              <h2>Step 4 of 7</h2>
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
                        
                        <div class="form-group">
                          <label>Password Encryption Salt</label>
                          <input type="text" name="encrypt_salt" placeholder="bootwiki"
                                class="form-control"
                                 value="<?=$_SESSION['step4']['encrypt_salt']?>"
                                 title="Used to encrypt user passwords">
                        </div>
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
                        
                        <div class="form-group">
                          <label>SMTP Mail Host</label>
                          <input type="text" name="email_host" placeholder="localhost"
                                class="form-control"
                                 value="<?=$_SESSION['step4']['email_host']?>"
                                 title="The host that will send emails">
                        </div>
                        <div class="form-group">
                          <label>SMTP SSL</label>
                          <input type="text" name="email_smtp_ssl" placeholder="tls"
                                class="form-control"
                                 value="<?=$_SESSION['step4']['email_smtp_ssl']?>"
                                 title="Tells which SSL prototol phpmailer will use">
                        </div>
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
                        
                        <div class="form-group">  
                          <label>Authentication User</label>
                          <input type="text" name="email_auth_user" placeholder="username or email"
                                class="form-control"
                                 value="<?=$_SESSION['step4']['email_auth_user']?>"
                                 title="The username or email to authenticate at the mail server">
                        </div>
                        <div class="form-group">
                          <label>Authentication Password</label>
                          <input type="text" name="email_auth_path" placeholder="password"
                                class="form-control"
                                 value="<?=$_SESSION['step4']['email_auth_pass']?>"
                                 title="The password to authenticate at the mail server">
                        </div>
                        <div class="form-group">
                          <label>Sender mail address (FROM)</label>
                          <input type="text" name="email_from" placeholder="Sender name"
                                class="form-control"
                                 value="<?=$_SESSION['step4']['email_from']?>"
                                 title="The email that will be used when sending emails">
                        </div>
                        <div class="form-group">
                          <label>CC mail address (Optional)</label>
                          <input type="text" name="email_cc" placeholder="Mail copy address or empty"
                                class="form-control"
                                 value="<?=$_SESSION['step4']['email_cc']?>"
                                 title="The email that will receive a copy. Leave empty if not used">
                        </div>
                        <div class="form-group">
                          <label>CC mail address (Optional)</label>
                          <input type="text" name="email_bcc" placeholder="Mail blind copy address or empty"
                                class="form-control"
                                 value="<?=$_SESSION['step4']['email_bcc']?>"
                                 title="The email that will receive a copy. Leave empty if not used">
                        </div>
                        <div class="form-group">
                          <label>Send email debug file (Optional)</label>
                          <input type="text" name="email_debug_filepath" placeholder="./mail.log"
                                class="form-control"
                                 value="<?=$_SESSION['step4']['email_debug_filepath']?>"
                                 title="The file where email logs will be saved ">
                        </div>
                  </fieldset>
                  <button type="submit" class="btn btn-primary">Next</button>
              </form>
              <?php } ?>
              
              <?php if ($_SESSION['step'] == 5) { ?>
              <h2>Step 5 of 7</h2>
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
              <?php if ($_SESSION['step5_ok']) { ?>
                    <h3>Save Configuration</h3>
                    <?php foreach ($step6_results as $line) { ?>
                    <p class="bg-info"><?=$line?></p>
                    <?php } ?>
                    <div class="clearfix"></div>
                    <a href="installer.php?step=6" class="btn btn-primary">Next...</a>
              <?php } else { ?>
                    <div class="clearfix"></div>
                    <a href="installer.php?step=5" class="btn btn-primary">Re-check</a>
              <?php } ?>
              <?php } ?>
             
              <?php if ($_SESSION['step'] == 6) { ?>
                    <h2>Step 6 of 7</h2>
                    <h3>Install Database</h3>
                    <?php foreach ($step6_results as $line) { ?>
                        <p class="bg-info"><?=$line?></p>
                    <?php } ?>
                    <div class="clearfix"></div>
                    <a href="installer.php?step=7" class="btn btn-primary">Next...</a>
              <?php } ?>
                    
              <?php if ($_SESSION['step'] == 7) { ?>
                    <h2>Step 7 of 7</h2>
                    <p>Installer is complete!</p>
                    <p>Use admin/admin as username/password to login</p>
                    <p>Click <a href="index.php" target="_blank">here</a> to see your new wiki</p>
                    <p>If something went wrong, you can yet reconfigure all again.</p>
                    <p>IMPORTANTE: DO NOT FORGET TO REMOVE THIS INSTALL SCRIPT (installer.php) ONCE CONFIGURATION IS COMPLETE</p>
              <?php } ?>
                  
            

        </div><!--/span-->
      </div><!--/row-->
    </div><!--/.fluid-container-->
    
    <footer class="container-fluid">
        <div class="pull-right">BootWiki &copy; Marco Afonso 2013 - <?=date('Y')?></div>
    </footer>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="web/js/bootstrap.min.js"></script>
    
  </body>
</html>
